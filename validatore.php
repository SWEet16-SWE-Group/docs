<?php

require_once __DIR__ . '/.libphp/utils.php';
require_once __DIR__ . '/.libphp/stream.php';
require_once __DIR__ . '/.libphp/Vocaboli.php';
require_once __DIR__ . '/.libphp/Validatore.php';

// =========================================
// MAIN
// =========================================

function main_vocaboli($files, $latexoutput) {

  if (count($a = findoutliers($files)) > 0) {
    echo "\nCorreggere i seguenti outliers per procedere con il glossario\n"
      . stream(
        $a,
        _map(fn ($a) => "\n" . $a['file'] . ":\n" . $a['context'] . "\n\n"),
        _implode(''),
      );
    die(11);
  }

  $d = preg('/\\\\subsection{(.*?)}(.*?)\n/', file_get_contents($latexoutput));
  $d = array_combine($d[1], $d[2]);

  $a = stream(
    findvocaboli($files),
    _parse(),
    _sort(),
    _unique(),
  );

  if (count($m = stream($a, _filter(fn ($a) => !array_key_exists($a, $d)))) > 0) {
    echo "\nNel Glossario manca la definizione delle seguenti parole:\n";
    echo stream(
      $m,
      _map(fn ($a) => "\t$a\n"),
      _implode(''),
    );
    die(10);
  }

  $a = stream(
    $a,
    _map(fn ($a) => '\\subsection{' . $a . '}' . $d[$a] . "\n"),
    _sort(),
    _implode(""),
  );

  file_put_contents($latexoutput, $a);
}

// MAIN VALIDATORE

function main_validatore_stilistico($files) {
  foreach ($files as $a) {
    echo "Correzione stile: $a\n";
    valida_file($a);
  }
  echo "\n";
}

function main_esegui_php($files) {
  foreach ($files as $a) {
    $pfx = fn ($s) => "Esecuzione PHP: $a: $s\n";
    echo $pfx("INIZIO");

    chdir(dirname($a));
    // ob_start(fn ($b) => preg_replace_callback_array(['/^(.*)$/' => $pfx], $b));
    ob_start(fn ($b) => stream($b, _explode("\n"), _filter(fn ($a) => strlen($a) > 0), _map($pfx), _implode("\n")));
    require_once basename($a);
    ob_end_flush();
    chdir(__DIR__);

    echo $pfx("FINE");
    echo "\n";
  }
}

function main_correttore_ortografico($dict, $files) {
  $a = stream($files, _map(fn ($a) => "\"$a\""), _implode(' '));
  passthru("hunspell -p $dict -d it_IT,en_US $a");
}

function main_correttore_ortografico_action($dict, $files) {
  $a = stream($files, _map(fn ($a) => "\"$a\""), _implode(' '));
  $e = shell_exec("hunspell -p $dict -d it_IT,en_US -l $a");
  print_r($e);
  $e = $e === null ? 0 : 14;
  $e != 0 && print_r("\n\nCorreggere le parole evidenziate sopra\n");
  $e != 0 && die($e);
}

function main_compile($files) {
  foreach ($files as $a) {
    $pfx = fn ($s) => "Compilazione latex: $a: $s\n";
    echo $pfx("INIZIO");

    chdir(dirname($a));
    ob_start(fn ($b) => stream($b, _explode("\n"), _filter(fn ($a) => strlen($a) > 0), _map($pfx), _implode("\n")));
    passthru("mkdir -p .build/ && latexmk -interaction=nonstopmode -halt-on-error -output-directory=.build/ -pdf main.tex > .build/php.out", $e);
    ob_end_flush();
    chdir(__DIR__);

    echo $pfx("FINE");
    echo $pfx("CODICE DI USCITA: $e");
    $e != 0 && die($e);
    echo "\n";
  }
}

echo "\n";

die();

$find = _find('main.tex', __DIR__);
$dict = __DIR__ . '/.lib_php/sweet16-dict';
echo "Controllo esistenza del dizionario: " . json_encode($e = touch($dict)) . "\n\n";
$e == false && die(11);

$tex = array_merge(_find('*.tex', __DIR__ . '/rtb/'), _find('*.tex', __DIR__ . '/pb/'));

main_esegui_php(_find('*.php', __DIR__));
main_validatore_stilistico($tex);
main_vocaboli($tex, __DIR__ . '/glossario/src/vocaboli.tex');

if (in_array('--action', $argv)) {
  main_correttore_ortografico_action($dict, $tex);
} else {
  main_correttore_ortografico($dict, $tex);
  $targets = [];
  foreach ($argv as $i => $a) {
    if ($a == '-t') {
      $targets[] = $argv[$i + 1];
    }
  }
  main_compile(count($targets) > 0 ? array_intersect($targets, $find) : $find);
}

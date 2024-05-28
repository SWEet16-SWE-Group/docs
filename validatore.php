<?php

require_once __DIR__ . '/.libphp/Utils.php';
require_once __DIR__ . '/.libphp/Stream.php';
require_once __DIR__ . '/.libphp/Vocaboli.php';
require_once __DIR__ . '/.libphp/Validatore.php';

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
    echo $pfx("FINE");
    echo $pfx("CODICE DI USCITA: $e");
    if ($e != 0) {
      echo file_get_contents('.build/main.log');
      die($e);
    }
    chdir(__DIR__);
    echo "\n";
  }
}

echo "\n";

$dict = __DIR__ . '/.libphp/sweet16-dict';
echo "Controllo esistenza del dizionario: " . json_encode($e = touch($dict)) . "\n\n";
$e == false && die(11);

foreach (stream(
  _find('main.php', __DIR__),
  _filter(fn ($a) => !str_contains($a, '/Template/')),
) as $file) {
  echo "PREPROCESSING: $file\n";
  if ((require $file) > 0) {
    echo "PREPROCESSING: ERRORE A $file\n";
    die(13);
  }
}

echo "\n";

$tex = stream(
  _find('main.tex', __DIR__),
  _filter(fn ($a) => !str_contains($a, '/Template/')),
);
main_correttore_ortografico_action($dict, $tex);
if (in_array('--compile', $argv)) {
  main_compile($tex);
}

<?php

require_once __DIR__ . '/.libphp/Utils.php';
require_once __DIR__ . '/.libphp/Stream.php';
require_once __DIR__ . '/.libphp/Vocaboli.php';
require_once __DIR__ . '/.libphp/Validatore.php';

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

$dict = __DIR__ . '/.lib_php/sweet16-dict';
echo "Controllo esistenza del dizionario: " . json_encode($e = touch($dict)) . "\n\n";
$e == false && die(11);

foreach (_find('main.php', __DIR__) as $file) {
  $a = require $file;
  if ($a > 0) {
    echo "ERRORE NEL PREPROCESSING DI: $file\n";
    die(13);
  }
}

$tex = _find('main.tex', __DIR__);

if (in_array('--compile', $argv)) {
  main_correttore_ortografico($dict, $tex);
  main_compile($tex);
} else {
  main_correttore_ortografico_action($dict, $tex);
}

<?php

require_once __DIR__ . '/.libphp/Utils.php';
require_once __DIR__ . '/.libphp/Stream.php';
require_once __DIR__ . '/.libphp/Vocaboli.php';
require_once __DIR__ . '/.libphp/Validatore.php';

function _lazifier($fn, ...$args) {
  return fn () => $fn(...$args);
}

function _execdir($dstdir, $fn) {
  $srcdir = getcwd();
  try {
    chdir($dstdir);
    return $fn();
  } finally {
    chdir($srcdir);
  }
}

function errori_ortografici($dict, $file) {
  return stream(
    ($e = shell_exec("hunspell -p $dict -d it_IT,en_US -l \"$file\"")) === null ? '' : $e,
    _explode("\n"),
    _filter(fn ($a) => strlen($a) > 0),
    _map(fn ($a) => "ORTOGRAFIA: $file: $a"),
    _implode(''),
  );
}

function compila($file, $rinomina = false) {
  $pfx = fn ($s) => "Compilazione latex: $file: $s\n";
  echo $pfx("INIZIO");
  passthru(<<<EOF
      mkdir -p .build/ &&
      latexmk -interaction=nonstopmode -halt-on-error -output-directory=.build/ -pdf main.tex > .build/php.out
    EOF, $e);
  echo $pfx("FINE");
  echo $pfx("CODICE DI USCITA: $e");
  if ($e != 0) {
    echo file_get_contents('.build/main.log');
    echo $pfx("CODICE DI USCITA: $e");
    die($e);
  }
  $rinomina and rename(".build/main.pdf", ".build/$rinomina");
}

echo "\n";

const dict = __DIR__ . '/.libphp/sweet16-dict';
echo "Controllo esistenza del dizionario: " . json_encode($e = touch(dict)) . "\n\n";
$e == false && die(11);

$files = stream(_find(__DIR__, 'main.php'), _filter(fn ($a) => !str_contains($a, '/Template/')));

$artefatti = stream(
  $files,
  _map(function ($file) {
    $nome = false;
    echo "PREPROCESSING: $file\n";
    if ((require $file) > 0) {
      echo "PREPROCESSING: ERRORE IN $file\n";
      die(13);
    }
    return [
      'errori_ortografici' => errori_ortografici(dict, preg_replace_array(['/main\.php$/' => 'main.tex'], $file)),
      'compilatore' => fn () => _execdir(dirname($file), fn () => compila($file, $nome)),
    ];
  }),
);


if (
  $errori_ortografici = implode(
    "\n",
    stream(
      array_column($artefatti, 'errori_ortografici'),
      _filter(fn ($a) => $a),
    ),
  )
) {
  print_r("\n\nCorreggere le parole evidenziate di seguito\n");
  print_r($errori_ortografici);
  print_r("\n\n");
  die(14);
}

if (!_compile()) {
  die();
}

foreach (array_column($artefatti, 'compilatore') as $compilatore) {
  $compilatore();
}
die();

// VECCHIO MAIN

function main_correttore_ortografico_action($dict, $files) {
  $a = stream($files, _map(fn ($a) => "\"$a\""), _implode(' '));
  $e = shell_exec("hunspell -p $dict -d it_IT,en_US -l $a");
  if ($e) {
    print_r("\n\nCorreggere le parole evidenziate di seguito\n");
    print_r($e);
    die(14);
  }
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
    isset($nome) and rename('.build/main.pdf', ".build/{$nome()}") and print_r($pfx("FINE"));
    unset($nome);
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
  _map(function ($file) {
    echo "PREPROCESSING: $file\n";
    if ((require $file) > 0) {
      echo "PREPROCESSING: ERRORE A $file\n";
      die(13);
    }
    return compiler();
  }),
) as $file) {
  echo "PREPROCESSING: $file\n";
  if ((require $file) > 0) {
    echo "PREPROCESSING: ERRORE A $file\n";
    die(13);
  }
}

echo "\n";

$compile = _compile();

echo implode(
  "\n",
  array_map(
    function ($file) use ($compile) {
      if ($compile) {
      }
    },
    stream(
      _find('main.tex', __DIR__),
      _filter(fn ($a) => !str_contains($a, '/Template/')),
    )
  )
);

main_correttore_ortografico_action($dict, $tex);
if (_compile()) {
  main_compile($tex);
}

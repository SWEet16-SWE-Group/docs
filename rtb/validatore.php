<?php

require_once __DIR__ . '/.lib_php/utils.php';
require_once __DIR__ . '/.lib_php/Stream.php';

function preg_replace_array($r, $a) {
  return preg_replace(array_keys($r), $r, $a);
}

function _appiattisci_item($text) {
  $a = preg('/\\\\(begin|end){(itemize|enumerate)}/', $text, PREG_OFFSET_CAPTURE)[0];

  $stack = [];
  $i = 0;
  foreach ($a as $b) {
    if (str_contains($b[0], 'begin')) {
      if ($i == 0) {
        $stack[] = [$b];
      }
      $i += 1;
    }
    if (str_contains($b[0], 'end')) {
      $i = max([0, $i - 1]);
      if ($i == 0) {
        $stack[array_key_last($stack)][] = $b;
      }
    }
  }

  $text = array_reduce($stack, function ($text, $a) {
    $o = $a[0][1];
    $l = $a[1][1] - $o;
    return substr_replace($text, str_replace("\n", ' ', substr($text, $o, $l)), $o, $l);
  }, $text);

  $text = preg_replace_array(['/\\\\(item|(begin|end){(itemize|enumerate)})/' => "\n\\\\\\1"], $text);

  return $text;
}

$regexbianco = [
  "/\r/" => '',
  "/\t/" => '  ',
  "/(\\S) +/" => '\1 ',                   // compressione di tanti spazi in uno esclusa indentazione iniziale
  "/ *\\n/" => "\n",                      // testo bianco a fine riga
  "/ *}/" => '}',                         // rimozione spazi tra : e }
  '/:}/' => '}:',
  "/:(\\w)/" => '} \1',                   // spazio dopo :
  "/(\\S) +([;:,.])/" => '\1\2',          // rimozione spazi prima di [:,.;]
  "/([a-zA-Z]),([a-zA-Z])/" => '\1, \2',  // aggiunta spazio dopo ,
  "/\n\n\n/" => "\n\n",
];

$regexmaiuscole = [
  "/\\\\item (\\\\textbf{)?([a-z])/" => fn ($a) => '\\item ' . $a[1] . ucfirst($a[2]),
  "/(}: )([a-z])/" => fn ($a) => $a[1] . ucfirst($a[2]),
  // "/(?:(?<!(?<!\\\\url{)(?<!\\\\href{))):([^0-9A-Z]*)([a-z])/" => fn ($a) => ':' . $a[1] . ucfirst($a[2]), // dopo : preservando caratteri in mezzo e escludendo url e href
];

$regexelenchi = [
  "/(\\\\item [^\n]*?)([\\.;:])?(?=\n\\\\item)/"              => '\1;\3',
  "/(\\\\item [^\n]*?)([\\.;:])?(?=\n\\\\begin{itemize})/"    => '\1:\3',
  "/(\\\\item [^\n]*?)([\\.;:])?(?=\n\\\\begin{enumerate})/"  => '\1:\3',
  "/(\\\\item [^\n]*?)([\\.;:])?(?=\n\\\\end{itemize})/"      => '\1.\3',
  "/(\\\\item [^\n]*?)([\\.;:])?(?=\n\\\\end{enumerate})/"    => '\1.\3',
  "/(\\\\item [^\n]*?\\$\\$)[\\.;:]/" => '\1',
];

// =========================================
// MAIN
// =========================================

function main_validatore_stilistico($files) {
  foreach ($files as $a) {
    echo "Correzione stile : $a\n";
    $text = file_get_contents($a);
    //$text = preg_replace_array($regexbianco, $text);
    //$text = preg_replace_callback_array($regexmaiuscole, $text);
    $text = _appiattisci_item($text);
    //$text = preg_replace_array($regexbianco, $text);
    //$text = preg_replace_array($regexelenchi, $text);
    //$text = preg_replace_array($regexbianco, $text);
    file_put_contents($a, $text);
  }
}

function main_esegui_php($files) {
  foreach ($files as $a) {
    chdir(dirname($a));
    echo "Esecuzione: $a\n";
    require_once $a;
    chdir(__DIR__);
  }
}

function main_correttore_ortografico($files) {
  $a = stream($files, _map(fn ($a) => "\"$a\""), _implode(' '));
  passthru("hunspell -d it_IT,en_US $a");
}

function main_compile($files) {
  foreach ($files as $a) {
    chdir(dirname($a));
    passthru(
      "mkdir -p .build && pdflatex -interaction=nonstopmode -halt-on-error -output-directory=.build/ main.tex > /dev/null",
      $e
    );
    echo "\n\n\n$a\nCODICE DI USCITA: $e\n\n";
    $e != 0 && die("ERRORE DI COMPILAZIONE\n");
    chdir(__DIR__);
  }
}

//main_esegui_php(_find('*.php'));
//main_correttore_ortografico(_find('*.tex'));
//main_validatore_stilistico(_find('*.tex'));
//main_compile(_find('main.tex'));

$a = $argv[1];
main_validatore_stilistico($a);
main_compile($a);

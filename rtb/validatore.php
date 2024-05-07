<?php

require_once __DIR__ . '/.lib_php/utils.php';
require_once __DIR__ . '/.lib_php/Stream.php';

const stile = [
  '\r' => '',                          // carriage return
  '\t' => '  ',                        // tab in 2 spazi
  '(\S) +' => '\1 ',                   // compressione di tanti spazi in uno esclusa indentazione iniziale
  ' *\n' => '\n',                      // testo bianco a fine riga
  ' *}' => '}',                        // rimozione spazi tra : e }
  '}(\w)' => '} \1',                   // spazio dopo :}
  '(\S) +([;:,.])' => '\1\2',          // rimozione spazi prima di [:,.;]
  '([a-zA-Z]),([a-zA-Z])' => '\1, \2', // aggiunta spazio dopo ,
];


function stilizzazione($file) {
  return file_put_contents($file, preg_replace(array_keys(stile), stile, file_get_contents($file)));
}


// stilizzazione($argv[1]);


function merge_items($text) {
  $a = array_merge(
    //preg('/\\\\item/', $text, PREG_OFFSET_CAPTURE)[0],
    preg('/\\\\begin{itemize}/', $text, PREG_OFFSET_CAPTURE)[0],
    preg('/\\\\begin{enumerate}/', $text, PREG_OFFSET_CAPTURE)[0],
    preg('/\\\\end{itemize}/', $text, PREG_OFFSET_CAPTURE)[0],
    preg('/\\\\end{enumerate}/', $text, PREG_OFFSET_CAPTURE)[0],
    // preg('/\\\\item\s*\\\\begin{/', $text, PREG_OFFSET_CAPTURE)[0],
  );
  usort($a, fn ($a, $b) => $a[1] < $b[1] ? -1 : 1);
  //$a = array_combine(array_column($a, 1), array_column($a, 0));
  //ksort($a);
  //$a = array_reverse($a, true);

  $stack = [];
  $i = 0;
  foreach ($a as &$b) {
    if (str_contains($b[0], 'begin')) {
      if ($i == 0) {
        $stack[] = [$b];
        $i += 1;
      }
    }
    if (str_contains($b[0], 'end')) {
      $i = min([0, $i - 1]);
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

  print_r($text);

  //$a = array_values(array_map(fn ($a, $b) => [$a, $b], $a, array_keys($a)));
  //for ($i = 0; $i < count($a) - 1; $i += 1) {
  //  $j = $i + 1;
  //  $o = $a[$j][1];
  //  $l = $a[$i][1] - $o;
  //  $text = substr_replace($text, str_replace("\n", ' ', substr($text, $o, $l)), $o, $l);
  //  //if (str_contains('\\item', $a[$i][0]) && str_contains('\\item', $a[$j][0])) {
  //  //} else if (str_contains('\\item', $a[$i][0]) && str_contains('\\begin', $a[$j][0])) {
  //  //} else if (str_contains('\\item', $a[$i][0]) && str_contains('\\end', $a[$j][0])) {
  //  //}
  //}

  $text = str_replace($b = '\\item', "\n" . $b, $text);
  $text = str_replace($b = '\\begin{itemize}', "\n" . $b, $text);
  $text = str_replace($b = '\\begin{enumerate}', "\n" . $b, $text);
  $text = str_replace($b = '\\end{itemize}', "\n" . $b, $text);
  $text = str_replace($b = '\\end{enumerate}', "\n" . $b, $text);
  //$text = str_replace("\n\n", "\n", $text);

  //print_r($text);
  return;
}

merge_items(file_get_contents($argv[1]));

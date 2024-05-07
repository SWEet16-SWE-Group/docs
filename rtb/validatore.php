<?php

require_once __DIR__ . '/.lib_php/utils.php';
require_once __DIR__ . '/.lib_php/Stream.php';

function preg_replace_array($r, $a) {
  return preg_replace(array_keys($r), $r, $a);
}

function _appiattisci_item($text) {
  $a = array_merge(
    //preg('/\\\\item/', $text, PREG_OFFSET_CAPTURE)[0],
    preg('/\\\\begin{itemize}/', $text, PREG_OFFSET_CAPTURE)[0],
    preg('/\\\\begin{enumerate}/', $text, PREG_OFFSET_CAPTURE)[0],
    preg('/\\\\end{itemize}/', $text, PREG_OFFSET_CAPTURE)[0],
    preg('/\\\\end{enumerate}/', $text, PREG_OFFSET_CAPTURE)[0],
  );
  usort($a, fn ($a, $b) => $a[1] < $b[1] ? -1 : 1);

  $stack = [];
  $i = 0;
  foreach ($a as &$b) {
    if (str_contains($b[0], 'begin')) {
      if ($i == 0) {
        $stack[] = [$b];
      }
      //$b[] = $i;
      $i += 1;
    }
    if (str_contains($b[0], 'end')) {
      $i = max([0, $i - 1]);
      if ($i == 0) {
        $stack[array_key_last($stack)][] = $b;
      }
      //$b[] = $i;
    }
  }

  $text = array_reduce($stack, function ($text, $a) {
    $o = $a[0][1];
    $l = $a[1][1] - $o;
    return substr_replace($text, str_replace("\n", ' ', substr($text, $o, $l)), $o, $l);
  }, $text);

  $a_capo = fn ($s, $t) => str_replace($s, "\n" . $s, $t);
  $text = $a_capo('\\item', $text);
  $text = $a_capo('\\begin{itemize}', $text);
  $text = $a_capo('\\begin{enumerate}', $text);
  $text = $a_capo('\\end{itemize}', $text);
  $text = $a_capo('\\end{enumerate}', $text);

  return $text;
}

function pulizia_regex($text) {
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
    "/(\\\\item [^\n]*?)([\\.;:])?(\n\\\\item)/"            => '\1-\3',
    "/(\\\\item [^\n]*?)([\\.;:])?(\n\\\\begin{itemize})/"  => '\1-\3',
    "/(\\\\item [^\n]*?)([\\.;:])?(\n\\\\begin{enumerate})/" => '\1-\3',
    "/(\\\\item [^\n]*?)([\\.;:])?(\n\\\\end{itemize})/"    => '\1-\3',
    "/(\\\\item [^\n]*?)([\\.;:])?(\n\\\\end{enumerate})/"  => '\1-\3',
  ];

  //$items = preg(
  //  "/(\\\\item [^\n*]*?)([^\\.;:])?(\n\\\\(item|((begin|end){(itemize|enumerate)})))/n",
  //  $text,
  //  PREG_OFFSET_CAPTURE
  //)[0];
  //$items = stream(
  //  $items,
  //  _map(fn ($a) => [
  //    'string' => $a[0],
  //    'replace' => preg_replace_array(
  //      [
  //        "" => "",
  //      ],
  //      $a[0]
  //    ),
  //    'offset' => $a[1],
  //    'length' => strlen($a[0]),
  //  ]),
  //);
  //print_r($items);

  $text = preg_replace_array($regexbianco, $text);
  $text = preg_replace_callback_array($regexmaiuscole, $text);

  $text = _appiattisci_item($text);

  $text = preg_replace_array($regexbianco, $text);
  $text = preg_replace_array($regexelenchi, $text);
  $text = preg_replace_array($regexbianco, $text);

  //print_r($text);
  return $text;
}

function correggi_file($file) {
  file_put_contents($file, pulizia_regex(file_get_contents($file)));
}

correggi_file($argv[1]);

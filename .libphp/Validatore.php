<?php

require_once __DIR__ . '/Stream.php';
require_once __DIR__ . '/Utils.php';
require_once __DIR__ . '/Vocaboli.php';

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

function _valida_testo($text) {
  $regexbianco = [
    "/\r/" => '',
    "/\t/" => '  ',
    "/(\\S) +/" => '\1 ',                   // compressione di tanti spazi in uno esclusa indentazione iniziale
    "/ *\\n/" => "\n",                      // testo bianco a fine riga
    "/ *}/" => '}',                         // rimozione spazi tra : e }
    '/:}/' => '}:',
    //"/:(\\w)/" => '} \1',                   // spazio dopo :
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
    "/(\\\\item [^\n]*?\\$\\$)[\\.;:]\n/" => "\\1\n",
    "/(\\\\item [^\n]*?\\\\end{center})[\\.;:]\n/" => "\\1\n",
  ];

  $text = preg_replace_array($regexbianco, $text);
  $text = preg_replace_callback_array($regexmaiuscole, $text);
  $text = _appiattisci_item($text);
  $text = preg_replace_array($regexbianco, $text);
  $text = preg_replace_array($regexelenchi, $text);
  $text = preg_replace_array($regexbianco, $text);
  return $text;
}


function racatta_errori($titolo, $tex) {
  $outliers = stream(
    _findoutliers($tex),
    _map(fn ($a) => "\t$a\n"),
    _implode(''),
  );
  $missing = stream(
    _findvocaboli($tex),
    _map('ucfirst'),
    _parse(),
    _filter(fn ($a) => !array_key_exists($a, definizioni_glossario)),
    _map(fn ($a) => "\t$a\n"),
    _implode(''),
  );
  $ortografia = '';
  if (strlen($outliers) > 0) {
    $outliers = "\n\nQuesti vocaboli devono essere definiti con \\empf{VOCABOLO}$^{G}$\n" . $outliers;
  }
  if (strlen($missing) > 0) {
    $missing = "\n\nMancano le definizioni dei sequenti vocaboli:\n" . $missing;
  }
  if (strlen($ortografia) > 0) {
    $ortografia = "\n\nPossibili errori di ortografia:\n" . $ortografia;
  }
  if (strlen($errormsg = $outliers . $missing . $ortografia) > 0) {
    return stream(
      $errormsg,
      _explode("\n"),
      _map(fn ($a) => "$titolo:\t$a\n"),
      _implode(''),
    );
  }
  return $errormsg;
}

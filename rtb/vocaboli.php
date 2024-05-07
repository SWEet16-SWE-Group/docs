<?php
require_once __DIR__ . '/.lib_php/Stream.php';

function findoutliers_file($file) {
  return stream(
    preg('/.*?[^}]\$\^{G}\$.*?/', file_get_contents($file))[0],
    _filter(fn ($a) => !str_contains($a, 'La presenza di un termine all’interno del glossario viene indicata applicando una')),
    _map(fn ($a) => ['file' => $file, 'context' => $a]),
  );
}

function findvocaboli_file($file) {
  return preg('/\\\\emph{(.*?)}\$\^{G}\$/', file_get_contents($file))[1];
};

function applicative_list($functions, $args) {
  return array_reduce(
    array_map(fn ($f) => array_map(fn ($a) => $f($a), $args), $functions),
    fn ($a, $b) => array_merge($a, $b),
    []
  );
}

function findoutliers($files) {
  return stream(
    applicative_list(['findoutliers_file'], $files),
    _filter(fn ($a) => count($a) > 0),
    _map(fn ($a) => $a[0]),
  );
}

function findvocaboli($files) {
  return stream(
    applicative_list(['findvocaboli_file'], $files),
    _filter(fn ($a) => count($a) > 0),
    _reduce(fn ($a, $b) => array_merge($a, $b), []),
    _map('ucfirst'),
    _sort(),
    _unique(),
  );
}

const parse = [
  'Ristoratori' => 'Ristoratore',
  'Clienti' => 'Cliente',
  'Coperti' => 'Coperto',
  'Ristoratori' => 'Ristoratore',
  'Prenotazioni' => 'Prenotazione',
  'Requisiti' => 'Requisito',
  'Requisiti funzionali' => 'Requisito funzionale',
  'Profili' => 'Profilo',
  'NextJs' => 'NextJS',
  'PoC' => 'PoC (Proof of Concept)',
  'Proof of Concept' => 'PoC (Proof of Concept)',
  'ITS' => 'ITS (Issue Tracking System)',
  'Express' => 'ExpressJS',
  '\\LaTeX' => 'LaTeX',
  'Capitolato d’appalto' => '',
  '' => '',
];

function _parse() {
  return fn ($a) =>
  _filter(fn ($a) => strlen($a) > 0)(
    preg_replace(
      _map(fn ($a) => '/^' . preg_quote($a) . '$/')(array_keys(parse)),
      parse,
      $a
    )
  );
}

// =========================================
// MAIN
// =========================================

$files = glob('./' . str_repeat('{,*/', 12) . str_repeat('}', 12) . '*.tex', GLOB_BRACE);

count($a = findoutliers($files)) > 0 &&
  die("\nCorreggere i seguenti outliers per procedere con il glossario\n"
    . stream(
      $a,
      _map(fn ($a) => "\n" . $a['file'] . ":\n" . $a['context'] . "\n\n"),
      _implode(''),
    ));

$d = preg('/\\\\subsection{(.*?)}(.*?)\n/', file_get_contents('glossario/src/vocaboli.tex'));
$d = array_combine($d[1], $d[2]);

$a = stream(
  findvocaboli($files),
  _parse(),
  _sort(),
  _unique(),
  _map(fn ($a) => '\\subsection{' . $a . '}' . (array_key_exists($a, $d) ? $d[$a] : 'INSERIRE DEFINIZIONE') . "\n"),
  _sort(),
  _implode(""),
);

file_put_contents('glossario/src/vocaboli.tex', $a);
//print_r($a);

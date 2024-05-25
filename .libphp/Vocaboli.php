<?php

require_once __DIR__ . '/Stream.php';
require_once __DIR__ . '/Utils.php';

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

function findoutliers($files) {
  return stream(
    findoutliers_file($files),
    _filter(fn ($a) => count($a) > 0),
    _map(fn ($a) => $a[0]),
  );
}

function findvocaboli($files) {
  return stream(
    findvocaboli_file($files),
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
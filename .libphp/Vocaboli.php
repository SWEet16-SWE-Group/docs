<?php

require_once __DIR__ . '/Stream.php';
require_once __DIR__ . '/Utils.php';

function _findoutliers($text) {
  return stream(
    preg('/.*?[^}]\$\^{G}\$.*?/', $text)[0],
    _filter(fn ($a) => !str_contains($a, 'La presenza di un termine all’interno del glossario viene indicata applicando una')),
  );
}

function findoutliers_file($file) {
  return stream(
    _findoutliers(file_get_contents($file))[0],
    _map(fn ($a) => ['file' => $file, 'context' => $a]),
  );
}

function findoutliers($files) {
  return stream(
    findoutliers_file($files),
    _filter(fn ($a) => count($a) > 0),
    _map(fn ($a) => $a[0]),
  );
}

function _findvocaboli($text) {
  return preg('/\\\\emph{(.*?)}\$\^{G}\$/', $text)[1];
}

function findvocaboli_file($file) {
  return _findvocaboli(file_get_contents($file))[1];
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

function _parse() {
  $parse = [
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
  return fn ($a) =>
  _filter(fn ($a) => strlen($a) > 0)(
    preg_replace(
      _map(fn ($a) => '/^' . preg_quote($a) . '$/')(array_keys($parse)),
      $parse,
      $a
    )
  );
}

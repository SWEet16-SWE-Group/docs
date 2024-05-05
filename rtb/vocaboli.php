<?php
require_once __DIR__ . '/.lib_php/Stream.php';

function preg($r, $s) {
  preg_match_all($r, $s, $a = []);
  return $a;
}

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
  $a = applicative_list(['findoutliers_file'], $files);
  $a = array_values(array_map(fn ($a) => $a[0], array_filter($a, fn ($a) => count($a) > 0)));
  return $a;
}

function findvocaboli($files) {
  $a = applicative_list(['findvocaboli_file'], $files);
  $a = array_map('ucfirst', array_reduce(array_filter($a, fn ($a) => count($a) > 0), fn ($a, $b) => array_merge($a, $b), []));
  sort($a);
  $a = array_unique($a);
  return $a;
}



array_shift($argv);
$a = $argv;

if (count($a = findoutliers($argv)) > 0) {
  die(implode("", array_map(
    fn ($a) => "\n" . $a['file'] . ":\n" . $a['context'] . "\n\n",
    $a
  )));
}

$a = findvocaboli($argv);


print_r($a);

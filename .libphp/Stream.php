<?php

function _map($f) {
  return fn ($a) => array_map($f, $a);
}

function _filter($f) {
  return fn ($a) => array_filter($a, $f);
}

function _reduce($f, $i) {
  return fn ($a) => array_reduce($a, $f, $i);
}

function _implode($d) {
  return fn ($a) => implode($d, $a);
}

function _explode($d) {
  return fn ($a) => explode($d, $a);
}

function _sort() {
  return function ($a) {
    sort($a);
    return $a;
  };
}

function _unique() {
  return fn ($a) => array_unique($a);
}

function stream($a, ...$p) {
  return array_reduce($p, fn ($a, $f) => $f($a), $a);
}

<?php

function _map($f) {
  return fn ($a) => array_map($f, $a);
}

function _filter($f) {
  return fn ($a) => array_filter($a, $f);
}

function _implode($d) {
  return fn ($a) => implode($d, $a);
}

function _explode($d) {
  return fn ($a) => explode($d, $a);
}

function stream($a, ...$p) {
  return array_reduce($p, fn ($a, $f) => $f($a), $a);
}

<?php

const glob_depth = 12;

function _find($p, $dir) {
  return glob($dir . str_repeat('{,*/', glob_depth) . str_repeat('}', glob_depth) . $p, GLOB_BRACE);
}

function preg($r, $s, $f = 0) {
  $a = [];
  preg_match_all($r, $s, $a, $f);
  return $a;
}

function array_flat($a) {
  $b = [];
  foreach ($a as $i) {
    foreach ($i as $j) {
      $b[] = $j;
    }
  }
  return $b;
}

function preg_replace_array($r, $a) {
  return preg_replace(array_keys($r), $r, $a);
}

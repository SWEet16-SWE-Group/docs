<?php

require_once __DIR__ . '/Utils.php';

function _stampatex($a, $k, $pfx) {
  return "\\$pfx{{$k}}\n\n" . match (gettype($a)) {
    'string' => $a,
    'array' => implode("\n\n", array_map(fn ($a, $k) => _stampatex($a, $k, "sub$pfx"), $a, array_keys($a))),
    'NULL' => "//manca il testo in $k",
  };
}


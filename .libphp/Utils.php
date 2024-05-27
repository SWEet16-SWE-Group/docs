<?php

// Errori belli

set_error_handler(function ($severity, $message, $file, $line) {
  throw new \ErrorException($message, $severity, $severity, $file, $line);
});

set_exception_handler(function (Throwable $exception) {
  $a = explode("\n", "{$exception->getMessage()}\n\n{$exception->getTraceAsString()}");
  $format = '%-' . max(array_map('strlen', $a)) . 's' . "        <br>\n";
  $a = array_map(fn ($a) => sprintf($format, $a), $a);
  $a = implode("", $a);
  die("\n" . $a . "\n");
});

// Utils

function str_replace_array($a, $s) {
  return str_replace(array_keys($a), $a, $s);
}

const glob_depth = 12;

function _find($p, $dir) {
  $depth = fn ($fn, $d, $a) => $d > 0 ? $fn($fn, $d - 1, "{,*/$a}") : $a;
  $depth = fn ($d) => $depth($depth, $d, '');
  return stream(
    glob("$dir/{$depth(12)}/$p", GLOB_BRACE),
    _map(fn ($a) => str_replace("//", "/", $a))
  );
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

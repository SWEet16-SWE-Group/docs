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

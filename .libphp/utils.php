<?php

function str_replace_array($a, $s) {
  return str_replace(array_keys($a), $a, $s);
}

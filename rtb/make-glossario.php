<?php


function texfiles() {
  $dir_iterator = new RecursiveDirectoryIterator(".");
  $iterator = new RecursiveIteratorIterator($dir_iterator, RecursiveIteratorIterator::SELF_FIRST);
  $matches = [];
  foreach ($iterator as $file) {
    if (fnmatch('*.tex', $file)) {
      $matches[] = $file->getPathname();
    }
  }
  return $matches;
}

var_dump(texfiles());

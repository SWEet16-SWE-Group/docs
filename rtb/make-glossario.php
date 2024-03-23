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

function glossari($file) {
  return explode("\n", preg_replace('/\s+/', "\n", file_get_contents($file)));
}

var_dump(glossari(texfiles()[0]));

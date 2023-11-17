<?php


$user = 'u';
if(array_key_exists($user,$_GET)){
  echo "utente: " . $_GET[$user] . "\n";
}

?>

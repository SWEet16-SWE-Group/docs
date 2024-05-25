<?php

function registromodifiche(...$data) {
  return implode('', array_map(fn ($a) => "$a \\\\ \\hline\n", $data));
}

function _log($versione, $data, $autore, $verificatore, $log) {
  return implode(' & ', [$versione, $data, $autore, $verificatore, $log]);
}

$registro = registromodifiche(
  _log('0.0.1', '2024-00-00', 'Alex S.', '', ''),
);

?>

\begin{tblr}{
colspec={|X[1.5cm]|X[2cm]|X[2.5cm]|X[2.5cm]|X[5cm]|},
row{odd}={bg=white},
row{even}={bg=lightgray},
row{1}={bg=black,fg=white}
}

Versione & Data & Autore & Verificatore & Descrizione \\ \hline
<?php echo $registro; ?>

\end{tblr}

<?php

require_once __DIR__ . '/pianificazione.d/pb.php';

?>
\pagebreak
\section{Pianificazione}

\subsection{Verso la RTB}

<?php require_once __DIR__ . "/pianificazione.d/rtb.php"; ?>

\pagebreak
\subsection{Verso la PB}
<?php require_once __DIR__ . "/pianificazione.d/verso_pb.php"; ?>

<?php

echo periodi_tostring($periodi_pb);

$rtb_somma_preventivi = somma3d(array_column($periodi_rtb, preventivo), $membri, range(0, 5));
$rtb_somma_consuntivi = somma3d(array_column($periodi_rtb, consuntivo), $membri, range(0, 5));

$pb_somma_preventivi = somma3d(array_column($periodi_pb, preventivo), $membri, range(0, 5));
$pb_somma_consuntivi = somma3d(array_column($periodi_pb, consuntivo), $membri, range(0, 5));

$progetto_somma_preventivi = somma3d([$rtb_somma_preventivi, $pb_somma_preventivi], $membri, range(0, 5));
$progetto_somma_consuntivi = somma3d([$rtb_somma_consuntivi, $pb_somma_consuntivi], $membri, range(0, 5));

function sezionetabelle($indentazione, $tabella_p, $tabella_c) {
  $a = <<<'EOF'


  \INDENTAZIONE{Preventivo economico totale}

  PREVENTIVO-SOLDI

  \INDENTAZIONE{Consuntivo economico finale}

  CONSUNTIVO-SOLDI

  \INDENTAZIONE{Preventivo orario totale}

  PREVENTIVO-ORE

  \INDENTAZIONE{Consuntivo orario finale}

  CONSUNTIVO-ORE

  EOF;
  return str_replace_array([
    'INDENTAZIONE' => $indentazione,
    'PREVENTIVO-SOLDI'  => tabella_soldi_to_string($tabella_p),
    'CONSUNTIVO-SOLDI'  => tabella_soldi_to_string($tabella_c),
    'PREVENTIVO-ORE'    => tabella_ore_to_string($tabella_p),
    'CONSUNTIVO-ORE'    => tabella_ore_to_string($tabella_c),
  ], $a);
}

echo '\\subsubsection{Riepilogo finale}';
echo sezionetabelle('subsubsubsection',$pb_somma_preventivi,$pb_somma_consuntivi);

echo '\\subsection{Riepilogo finale di tutti i periodi}';
echo sezionetabelle('subsubsection',$progetto_somma_preventivi, $progetto_somma_consuntivi);

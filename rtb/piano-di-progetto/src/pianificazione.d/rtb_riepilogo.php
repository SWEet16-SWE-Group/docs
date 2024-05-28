\subsubsection{Riepilogo finale}

<?php

require_once __DIR__ . '/pb.php';

function somma3d($a, $rows, $cols) {
  return array_combine($rows, array_map(fn ($r) => array_map(fn ($c) => array_sum(array_column(array_column($a, $r), $c)), $cols), $rows));
}

$membri = [
  (string)alberto_c(),
  (string)bilal_em(),
  (string)alberto_m(),
  (string)alex_s(),
  (string)iulius_s(),
  (string)giovanni_z(),
];

$rtb_somma_preventivi = somma3d(array_column($periodi_rtb, preventivo), $membri, range(0, 5));
$rtb_somma_consuntivi = somma3d(array_column($periodi_rtb, consuntivo), $membri, range(0, 5));


?>

\subsubsubsection{Preventivo economico totale}

<?php echo str_replace_array(['SOLDI' => tabella_to_string(tabella_soldi($rtb_somma_preventivi))],  tabella_soldi); ?>

\subsubsubsection{Consuntivo economico finale}

<?php echo str_replace_array(['SOLDI' => tabella_to_string(tabella_soldi($rtb_somma_consuntivi))],  tabella_soldi); ?>

\subsubsubsection{Preventivo orario totale}

<?php echo str_replace_array(['ORE'   => tabella_to_string(tabella_ore($rtb_somma_preventivi))],    tabella_ore); ?>

\subsubsubsection{Consuntivo orario finale}

<?php echo str_replace_array(['ORE'   => tabella_to_string(tabella_ore($rtb_somma_consuntivi))],    tabella_ore); ?>

\paragraph{Gestione dei ruoli}
Durante la fase di RTB, il 29\% delle risorse orario è stato dedicato al ruolo di Analista, il 17\% a quello di Programmatore, il 25\% a quello di Verificatore, mentre
solo l'8 \% per le figure rispettivamente del Responsabile e dell'Amministratore; il 13\% per la figura del Progettista.\\

\paragraph{Retrospettiva finale}
Analizzando le gestione da parte del gruppo dei ruoli, salta subito all'occhio un forte sbilanciamento, in parte abbastanza naturale nella fase di RTB, a favore di alcuni ruoli a discapito di altri: Abbondanti risorse sono state spese
per la figura dell'Analista in quanto la produzione dei documenti in generale, e dell'Analisi dei Requisiti in particolare, si è dimostrata un compito assai più oneroso di quanto si fosse preventivato
inizialmente; di questo fatto, è considerata una diretta conseguenza la quantità di risorse dedicate alla verifica e alla validazione della documentazione e del codice del PoC. \\
Il gruppo riconosce retrospettivamente che troppe poche risorse sono state dedicate in primis alla figura del Responsabile: Un'attenzione evidentemente non sufficiente ai compiti di gestione del gruppo (soprattutto per quanto riguarda la comunicazione), di assegnazione
dei compiti (che ha comportato una differenza importante nella quantità di lavoro profuso da alcuni membri) e
di coordinamento delle risorse impiegate, è considerata dai membri una delle cause principali delle molteplici criticità emerse durante tutta la RTB.

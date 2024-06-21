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

$pb_somma_preventivi = somma3d(array_column($periodi_pb, preventivo), $membri, range(0, 5));
$pb_somma_consuntivi = somma3d(array_column($periodi_pb, consuntivo), $membri, range(0, 5));

?>

% =================================================================================================

\subsubsection{Riepilogo finale}

\subsubsubsection{Preventivo economico totale}

<?php echo str_replace_array(['SOLDI' => tabella_to_string(tabella_soldi($pb_somma_preventivi))],  tabella_soldi); ?>

\subsubsubsection{Consuntivo economico finale}

<?php echo str_replace_array(['SOLDI' => tabella_to_string(tabella_soldi($pb_somma_consuntivi))],  tabella_soldi); ?>

\subsubsubsection{Preventivo orario totale}

<?php echo str_replace_array(['ORE'   => tabella_to_string(tabella_ore($pb_somma_preventivi))],    tabella_ore); ?>

\subsubsubsection{Consuntivo orario finale}

<?php echo str_replace_array(['ORE'   => tabella_to_string(tabella_ore($pb_somma_consuntivi))],    tabella_ore); ?>

\paragraph{Retrospettiva finale}
È andata come così. Non ci si può fare più niente ormai.

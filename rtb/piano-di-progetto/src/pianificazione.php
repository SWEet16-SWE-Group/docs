<?php

require_once __DIR__ . '/pianificazione.d/pb.php';

?>
\pagebreak
\section{Pianificazione}

\subsection{Verso la RTB}

\subsubsection{Primo periodo}
Inizio: 2023/11/08 \\
Fine: 2023/11/24 \\

<?php require_once __DIR__ . "/pianificazione.d/rtb_1.php"; ?>

\subsubsection{Secondo periodo}
Inizio: 2023/11/25 \\
Fine: 2024/01/26 \\

<?php require_once __DIR__ . "/pianificazione.d/rtb_2.php"; ?>

\subsubsection{Terzo periodo}
Inizio: 2024/01/27 \\
Fine: 2024/03/11 \\

<?php require_once __DIR__ . "/pianificazione.d/rtb_3.php"; ?>

\subsubsection{Quarto periodo}
Inizio: 2024/03/12 \\
Fine: 2024/04/18 \\

<?php require_once __DIR__ . "/pianificazione.d/rtb_4.php"; ?>

\subsubsection{Riepilogo finale}
<?php require_once __DIR__ . "/pianificazione.d/rtb_riepilogo.php"; ?>

\pagebreak
\subsection{Verso la PB}
<?php require_once __DIR__ . "/pianificazione.d/verso_pb.php"; ?>

<?php

echo periodi_tostring($periodi_pb);

?>

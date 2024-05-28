<?php

require_once __DIR__ . '/pianificazione.d/pb.php';

?>
\pagebreak
\section{Pianificazione}

\subsection{Verso la RTB}

<?php require_once __DIR__ . "/pianificazione.d/rtb_1.php"; ?>

<?php require_once __DIR__ . "/pianificazione.d/rtb_2.php"; ?>

<?php require_once __DIR__ . "/pianificazione.d/rtb_3.php"; ?>

<?php require_once __DIR__ . "/pianificazione.d/rtb_4.php"; ?>

<?php require_once __DIR__ . "/pianificazione.d/rtb_riepilogo.php"; ?>

\pagebreak
\subsection{Verso la PB}
<?php require_once __DIR__ . "/pianificazione.d/verso_pb.php"; ?>

<?php

echo periodi_tostring($periodi_pb);

?>

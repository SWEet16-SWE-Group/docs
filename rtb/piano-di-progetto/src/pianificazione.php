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

?>

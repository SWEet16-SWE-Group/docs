\nonstopmode
\begin{tblr}{
colspec={|X[1.5cm]|X[2cm]|X[2.5cm]|X[2.5cm]|X[5cm]|},
row{odd}={bg=white},
row{even}={bg=lightgray},
row{1}={bg=black, fg=white}
}
<?php 
$registro = (new RegistroModifiche())
->log(CE, "2024/02/16", alex_s(), alberto_m(), "Stesura scheletro")
->log(CE, "2024/03/19", bilal_em(), alberto_m(), "Stesura introduzione")
->log(CE, "2024/03/22", alberto_c(), alberto_m(), "Stesura test")
->log(CE, "2024/03/25", giovanni_z(), alex_s(), "Stesura qualità di prodotto")
->log(CE, "2024/04/02", alberto_c(), alex_s(), "Stesura resoconto delle attività di verifica")
->log(CE, "2024/04/08", giovanni_z(), alberto_m(), "Stesura qualità di processo")
->log(DX, "2024/04/10", alberto_c(), alex_s(), "Modifica grafici resoconto attività di verifica")
->log(SX, "2024/04/15", alex_s(), "", "Approvazione per il rilascio")
;

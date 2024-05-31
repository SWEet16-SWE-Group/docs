<?php
set_include_path(__DIR__ . '/../../.libphp/');
require_once 'Utils.php';
require_once 'RegistroModifiche.php';
require_once 'Vocaboli.php';
require_once 'Validatore.php';
require_once 'Membri.php';

$titolo = '/home/lumine/Documenti/unipd/2023-2024-swe/docs/rtb/analisi-requisiti/main.tex';
$registro = (new RegistroModifiche())
  ->logArray([
[DX, "2024/02/12", iulius_s(), alex_s(), "Stesura casi d'uso cliente prenotazione"],
[DX, "2024/02/15", iulius_s(), alberto_m(), "Stesura del template"],
[CE, "2024/02/15", iulius_s(), alberto_m(), "Stesura sezione introduzione"],
[DX, "2024/02/16", alberto_m(), alex_s(), "Correzione casi d'uso cliente prenotazione"],
[DX, "2024/02/16", iulius_s(), alberto_m(), "Stesura descrizione"],
[DX, "2024/02/16", iulius_s(), alberto_m(), "Stesura sezione descrizione"],
[DX, "2024/02/17", alex_s(), alberto_m(), "Stesura template casi d'uso"],
[CE, "2024/02/18", alberto_m(), alex_s(), "Stesura casi d'uso ristoratore"],
[CE, "2024/02/20", alberto_m(), alex_s(), "Stesura casi d'uso cliente ordinazione"],
[CE, "2024/02/20", alex_s(), alberto_m(), "Stesura casi d'uso utente autenticato"],
[DX, "2024/02/20", iulius_s(), alberto_m(), "Correzione casi d'uso ristoratore"],
[DX, "2024/02/21", alex_s(), iulius_s(), "Modifica casi d'uso cliente ordinazione"],
[CE, "2024/02/23", alex_s(), alberto_m(), "Stesura casi d'uso chat tra ristoratore e cliente"],
[DX, "2024/02/23", alex_s(), iulius_s(), "Modifica template e stesura casi d'uso cliente mancanti"],
[CE, "2024/02/26", alex_s(), alberto_m(), "Stesura casi d'uso utente autenticato"],
[CE, "2024/02/26", iulius_s(), alex_s(), "Stesura casi d'uso utente non riconosciuto"],
[DX, "2024/02/27", alberto_m(), iulius_s(), "Correzioni minori casi d'uso ristoratore"],
[DX, "2024/02/29", alex_s(), iulius_s(), "Correzioni minori UC"],
[DX, "2024/03/02", alberto_m(), alex_s(), "Aggiunta screenshots casi d'uso"],
[DX, "2024/03/04", alberto_m(), alex_s(), "Correzione UC"],
[CE, "2024/03/04", iulius_s(), alberto_m(), "Stesura requisiti funzionali"],
[DX, "2024/03/05", alex_s(), alberto_m(), "Stesura tracciamento fonti requisiti"],
[SX, "2024/03/05", alex_s(), "", "Approvazione per il rilascio"],
[CE, "2024/03/05", iulius_s(), alberto_m(), "Stesura requisiti non funzionali"],
[CE, "2024/03/25", alex_s(), alberto_m(), "Applicazione correzioni"],
[SX, "2024/04/03", alex_s(), "", "Approvazione per il rilascio"],
])
;
$error_flag = 0;
ob_start();
ob_start(function ($tex) use ($titolo, &$error_flag) {
  $errormsg = racatta_errori($titolo, $tex);
  if (strlen($errormsg) > 0) {
    $error_flag = 11;
    return $errormsg;
  }
  $tex = _valida_testo($tex);
  return $tex;
});
?>
\nonstopmode
\documentclass[a4paper, 11pt]{article}
\usepackage{graphicx} % Required for inserting images
\usepackage{amsmath}
\usepackage{geometry}
\usepackage{hyperref}
\usepackage{setspace}
\usepackage{array}
\usepackage[usenames, dvipsnames]{xcolor}
\usepackage{colortbl}
\usepackage{tabularray}
\usepackage[italian]{babel}

 \geometry{
 a4paper,
 left=25mm,
 right=25mm,
 top=20mm,
 bottom=20mm,
}

\setlength{\parskip}{1em}
\setlength{\parindent}{0pt}
\graphicspath{{../media/}{./src/uc-imgs/}}

\begin{document}

\begin{minipage}{0.35\linewidth}
    \includegraphics[width=\linewidth]{Logo_Università_Padova.svg.png}
\end{minipage}\hfil
\begin{minipage}{0.55\linewidth}
\textbf{Università degli Studi di Padova} \\
Laurea in Informatica \\
Corso di Ingegneria del Software \\
Anno Accademico 2023/2024
\end{minipage}

\vspace{5mm}

\begin{minipage}{0.35\linewidth}
    \includegraphics[width=\linewidth]{logo rotondo.jpg}
\end{minipage}\hfil
\begin{minipage}{0.55\linewidth}
\textbf{Gruppo}: SWEet16 \\
\textbf{Email}:
\href{mailto:sweet16.unipd@gmail.com}{\nolinkurl{sweet16.unipd@gmail.com}}
\end{minipage}

\vspace{15mm}

\begin{center}
\begin{Huge}
        \textbf{Analisi dei requisiti} \\
        \vspace{4mm}
        \end{Huge}

\vspace{20mm}

\begin{large}
\begin{spacing}{1.4}
\begin{tabular}{c c c}
   Redattori: & Alberto M. Alex S. Iulius S. & \\
   Verificatori: & Alberto M. Alex S. Iulius S. & \\
   Amministratore: & Alex S. & \\
   Destinatari: & T. Vardanega & R. Cardin \\
   Versione: & 2.0.0 &
\end{tabular}
\end{spacing}
\end{large}
\end{center}

\pagebreak

<?php echo $registro->latex(); ?>

\pagebreak
\tableofcontents
\pagebreak

<?php require_once __DIR__ . "/src/introduzione.php"; ?>

\pagebreak

<?php require_once __DIR__ . "/src/descrizione.php"; ?>

\pagebreak

<?php require_once __DIR__ . "/src/casi-uso.php"; ?>

\pagebreak

<?php require_once __DIR__ . "/src/requisiti.php"; ?>

\pagebreak

<?php require_once __DIR__ . "/src/elenco-delle-tabelle.php"; ?>

\end{document}

<?php
ob_end_flush();
$tex = ob_get_contents();
ob_end_clean();

$opts = getopt('p');
if (array_key_exists('p', $opts) || $error_flag > 0) {
  echo $tex;
} else {
  chdir(__DIR__);
  file_put_contents('main.tex', $tex);
}
return $error_flag;

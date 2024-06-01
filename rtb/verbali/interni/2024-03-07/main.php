<?php
set_include_path(__DIR__ . '/../../../../.libphp/');
require_once 'Utils.php';
require_once 'RegistroModifiche.php';
require_once 'Vocaboli.php';
require_once 'Validatore.php';
require_once 'Membri.php';

$titolo = '/home/lumine/Documenti/unipd/2023-2024-swe/docs/rtb/verbali/interni/2024-03-07/main.tex';
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
\usepackage{xcolor}
\usepackage{colortbl}
\usepackage{tabularray}
\definecolor{darkgreen}{RGB}{18,94,40}
\definecolor{lightgreen}{RGB}{179,255,179}
\definecolor{moregreen}{RGB}{153,255,143}
 \geometry{
 a4paper,
 left=25mm,
 right=25mm,
 top=20mm,
 bottom=20mm,
}

\setlength{\parskip}{1em}
\setlength{\parindent}{0pt}
\graphicspath{<?php echo includegraphics(); ?>}

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
        \textbf{Verbale Interno} \\
        \vspace{4mm}
        \textbf{07 Marzo 2024}
\end{Huge}

\vspace{20mm}

\begin{large}
\begin{spacing}{1.4}
\begin{tabular}{c c c}
   Redattori: & Iulius S. & \\
   Verificatori: & Alberto M. & \\
   Amministratore: & Alex S. & \\
   Destinatari: & T. Vardanega & R. Cardin \\
   Versione: & 1.0.0 &
\end{tabular}
\end{spacing}
\end{large}
\end{center}

\pagebreak

\begin{huge}
    \textbf{Registro delle modifiche}
\end{huge}
\vspace{5pt}

\begin{tblr}{
colspec={|X[1.5cm]|X[2cm]|X[2.5cm]|X[2.5cm]|X[5cm]|},
row{odd}={bg=white},
row{even}={bg=lightgray},
row{1}={bg=black, fg=white}
}
    Versione & Data & Autore & Verificatore & Descrizione \\
    \hline
    1.0.0 & 2024/03/11 & Alex S. & & Approvazione per il rilascio \\
    \hline
     0.1.0 & 2024/03/08 & Iulius S. & Alberto M. & Prima stesura del documento \\
     \hline
\end{tblr}

\section{Partecipanti}
Di seguito i nomi dei partecipanti con le rispettive matricole: \\
\vspace{5mm}

\begin{table}[h]
\begin{tblr}{
colspec={X[5cm]X[5cm]},
row{odd}={bg=moregreen},
row{even}={bg=lightgreen},
row{1}={bg=darkgreen, fg=white}
}
    Nome & Matricola \\
    Alberto Cinel & 1142833 \\
    Bilal El Moutaren & 2053470 \\
    Alberto Michelazzo & 2010007 \\
    Alex Scantamburlo & 2042326 \\
    Iulius Signorelli & 2012434 \\
    Giovanni Zuliani & 595900
\end{tblr}
\end{table}

\vspace{10pt}

\textbf{Inizio incontro}: Ore 21:00 \newline
\textbf{Fine incontro}: Ore 21:45 \newline

\pagebreak

\section{Sintesi ed elaborazione incontro}

\subsection{Stato dell'arte della documentazione}
All'inizio della riunione è stato chiesto dal Responsabile come fosse proseguito il lavoro
individuale di ogni membro dall'ultimo incontro a quello odierno, se ci fossero state difficoltà di alcuna sorta e se fossero sorti dubbi; i Verificatori del documento dell'Analisi dei Requisiti hanno riportato un impegno per
verificare e validare il suddetto documento assai maggiore di quanto avessero inizialmente preventivato.

\subsection{Completamento Analisi dei Requisiti}
Essendo stata completata l'Analisi dei Requisiti, gli Analisti che vi si sono dedicati hanno fatto una breve presentazione del documento agli altri membri del
gruppo, mettendone in evidenza la struttura.

\subsection{Preparazione incontro RTB}
In seguito alla verifica e validazione dell'Analisi dei Requisiti, è stata avviata una discussione su come impostare la presentazione
per la revisione TB con il prof. Cardin, in particolare su quali contenuti debbano essere assolutamente presenti; dopo un proficuo scambio di idee,
il gruppo ha deciso di concentrarsi sulle tecnologie facenti parte dello stack tecnologico del PoC.

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

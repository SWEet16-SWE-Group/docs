<?php
set_include_path(__DIR__ . '/../../../../.libphp/');
require_once 'Utils.php';
require_once 'RegistroModifiche.php';
require_once 'Vocaboli.php';
require_once 'Validatore.php';
require_once 'Membri.php';

$titolo = '/home/lumine/Documenti/unipd/2023-2024-swe/docs/pb/verbali/esterni/2024-05-17/main.tex';
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
\graphicspath{{../../../media/}}

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
        \textbf{Verbale Esterno} \\
        \vspace{4mm}
        \textbf{31 Maggio 2024}

\end{Huge}

\vspace{20mm}

\begin{large}
\begin{spacing}{1.4}
\begin{tabular}{c c c}
   Redattori: & Alberto C. & \\
   Verificatori: & Julius S. & \\
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
        1.0.0 & 2024/06/03 & Alex S. & & Approvazione per il rilascio \\
        \hline
        0.2.0 & 2024/06/03 & Sig. Staffolani & & Apposizione firma \\
        \hline
        0.1.0 & 2024/05/31 & Alberto C.. & Julius S. & Stesura del documento \\
        \hline

\end{tblr}

\pagebreak
\tableofcontents
\pagebreak

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
    Iulius Signorelli & 2012434 \\
\end{tblr}
\end{table}

Ha inoltre partecipato il Sig. Alessandro Staffolani, rappresentante di \textit{Imola Informatica}.

\vspace{10pt}

\textbf{Inizio incontro}: Ore 16:30 \newline
\textbf{Fine incontro}: Ore 17:00 \newline

\pagebreak

\section{Sintesi dell'incontro}

\subsection{Scopo principale}

In questo breve incontro il proponente, Alessandro Staffolani, ci ha aiutato a risolvere alcuni piccoli dubbi e problemi riscontrati durante questa fase del progetto.

\subsection{Domande generali}

\begin{itemize}
\item \textbf{Domanda}: Stiamo riscontrando alcuni problemi nella fase di testing con GEST: durante l'installazione risultano mancare alcuni moduli e risulta difficile poter procedere con i test, ha qualche soluzione da consigliare ?%;
\item \textbf{Risposta}: Dopo essersi accertato di quale tipologia di React stessimo utilizzando, ReactJS nel nostro caso, e aver approfondito la domanda anche attraverso altri accertamenti come l'installazione del Webpack, il sig. Staffolani ci ha consigliato di seguire i passi del seguente \href{https://create-react-app.dev/}{tutorial}. Inizialmente si dovrebbe creare una nuova app React per poi trasferire i vecchi dati su questa; in questa maniera si potrà verificare infine la corretta installazione e funzionamento del programma di testing. \\ Questa soluzione ovviamente potrà essere presa in considerazione qualora non si riescano a risolvere autonomamente i problemi riscontrati.

\end{itemize}

\begin{itemize}
\item \textbf{Domanda}: È possibile utilizzare delle viste nel databese ?%;
\item \textbf{Risposta}: Data la maggiore performance all'interno del database, ci è stato consigliato di utilizzare le viste solo per query più complesse ("JOIN" per esempio) e non per quelle banali che possono comprendere solamente una clausola "WHERE".
\end{itemize}

\subsection{Prossimo incontro}

Si è deciso di tenere incontri a scadenza settimanale e il prossimo incontro è stato prefissato per il venerdì seguente (2024-06-07) alla stessa ora (16.30 CET).

\vspace{60pt}
\begin{flushleft}
\hfill Firma del proponente \\
\vspace{50pt}
\hfill Alessandro Staffolani, \textit{Imola Informatica}
\end{flushleft}
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

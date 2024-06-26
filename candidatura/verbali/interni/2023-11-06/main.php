<?php
set_include_path(__DIR__ . '/../../../../.libphp/');
require_once 'Utils.php';
require_once 'RegistroModifiche.php';
require_once 'Vocaboli.php';
require_once 'Validatore.php';
require_once 'Membri.php';

$titolo = '/home/lumine/Documenti/unipd/2023-2024-swe/docs/candidatura/verbali/interni/2023-11-06/main.tex';
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
    \includegraphics[width=\linewidth]{logo_unipd.png}
\end{minipage}\hfil
\begin{minipage}{0.55\linewidth}
\textbf{Università degli Studi di Padova} \\
Laurea in Informatica \\
Corso di Ingegneria del Software \\
Anno Accademico 2023/2024
\end{minipage}

\vspace{5mm}

\begin{minipage}{0.35\linewidth}
    \includegraphics[width=\linewidth]{logo_rotondo.jpg}
\end{minipage}\hfil
\begin{minipage}{0.55\linewidth}
\textbf{Gruppo:} SWEet16 \\
\textbf{Email:} 
\href{mailto:sweet16.unipd@gmail.com}{\nolinkurl{sweet16.unipd@gmail.com}}
\end{minipage}

\vspace{15mm}

\begin{center}
\begin{Huge}
        \textbf{Verbale Interno} \\
        \vspace{4mm}
        \textbf{6 Novembre 2023}
\end{Huge}

\vspace{20mm}

\begin{large}
\begin{spacing}{1.4}
\begin{tabular}{c c c}
   Redattori:  &  Alberto C. & \\
   Verificatori: & Alex S. & \\
   Amministratore: &  Alberto C. & \\
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
colspec={|X[1.5cm]|X[2cm]|X[2cm]|X[2.6cm]|X[5cm]|},
row{odd}={bg=white},
row{even}={bg=lightgray},
row{1}={bg=black,fg=white}
}
    Versione & Data & Autore & Ruolo & Descrizione \\
    \hline 
    1.0.0 & 2023/11/06 & Alberto M. & Responsabile & Approvazione per rilascio \\
    \hline
    0.2.0 & 2023/11/06 & Alex S. & Verificatore & Verifica del documento \\
    \hline 
     0.1.0 & 2023/11/06 & Alberto C. & Amministratore & Prima stesura del documento \\
     \hline
\end{tblr}

\pagebreak

\section{Partecipanti}
Di seguito i nomi dei partecipanti con le rispettive matricole: \\
\vspace{5mm}

\begin{table}[h]
\begin{tblr}{
colspec={X[5cm]X[5cm]},
row{odd}={bg=moregreen},
row{even}={bg=lightgreen},
row{1}={bg=darkgreen,fg=white}
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

\textbf{Inizio incontro:} Ore 16:00 \newline
\textbf{Fine incontro:} Ore 17:30  \newline

\pagebreak

\section{Sintesi dell'incontro}

Dopo non aver ottenuto l'approvazione per l'appalto del capitolato \textit{Easy Meal}, soprattutto a causa dell'insostenibile data di consegna proposta sulla lettera di presentazione, si è deciso di effettuare un tempestivo incontro per decidere cosa e come migliorare le varie debolezze riscontrate. \\
Si è imposto come termine ultimo per la ricandidatura per l'appalto del capitolato in questione la mattinata seguente, ossia quella del 7 Novembre 2023, visto che ora tre gruppi sono in gara per il capitolato \textit{Easy Meal}.

Di seguito si presenta un resoconto delle scelte apportate per la risoluzione delle varie criticità. \newline

\subsection{Problemi riscontrati e relative soluzioni}

\subsubsection{Data di consegna prevista insostenibile}
E' stata effettuata un'analisi realistica sul tempo necessario per la consegna di progetto, si è arrivati alla conclusione che serviranno circa 7 settimane per sviluppare il \textit{PoC} e altre 18 per arrivare al \textit{MVP}. \\
E' stata quindi decisa come data di consegna prevista il 30 Aprile 2024 (25 settimane da oggi).

\subsubsection{Distribuzione del tempo e dei ruoli poco ragionata}

Tutto il gruppo ha ragionato sulle motivazioni dietro alle scelte delle divisioni orarie, andando a modificare il documento di Preventivo costi ed assunzione impegni con le motivazione relative ad ogni ruolo. 

\subsubsection{Rischi attesi}
E' stata fatta un'analisi dei rischi più critici attesi durante lo svolgimento del progetto, con le loro relative possibili soluzioni.\\
Sono stati scritti nel documento di Preventivo costi ed assunzione impegni. 

\subsubsection{Presenza di ‘:’ in ogni titolo di sezione della repository}

Si è effettuata la rimozione dei ‘:’ in questione. 

\subsubsection{I nomi dei documenti non ne riportano la versione}

Il problema è stato risolto rinominando ciascun documento con la relativa versione. 

\subsubsection{Verbale non approvato}

Si è proceduto ad inviare la mail per ottenere l'approvazione del verbale esterno da parte del rappresentante di \textit{Imola Informatica}.

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

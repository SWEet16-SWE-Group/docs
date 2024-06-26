<?php
set_include_path(__DIR__ . '/../../../../.libphp/');
require_once 'Utils.php';
require_once 'RegistroModifiche.php';
require_once 'Vocaboli.php';
require_once 'Validatore.php';
require_once 'Membri.php';

$titolo = '/home/lumine/Documenti/unipd/2023-2024-swe/docs/candidatura/verbali/interni/2023-10-25/main.tex';
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
        \textbf{25 Ottobre 2023}
\end{Huge}

\vspace{20mm}

\begin{large}
\begin{spacing}{1.4}
\begin{tabular}{c c c}
   Redattori:  &  Alberto M. & Alberto C.\\
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
     1.0.0 & 2023/10/30 & Alberto M. & Responsabile & Approvazione per rilascio \\
    \hline
    0.3.0 & 2023/10/29 & Alex S. & Verificatore & Verifica documento \\
    \hline
     0.2.0   & 2023/10/27 &  Alberto M. & Responsabile & Modifica sezione 2.2 \\
     \hline
     0.1.0   & 2023/10/25 & Alberto C. & Amministratore & Prima stesura del documento \\
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
row{1,8}={bg=darkgreen,fg=white}
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

\textbf{Inizio incontro:} Ore 15:00 \newline
\textbf{Fine incontro:} Ore 16:30  

\pagebreak

\section{Sintesi dell'incontro}

Durante il secondo incontro abbiamo analizzato nel dettaglio il capitolato deciso durante la prima sessione di incontri, ossia \textit{Easy Meal} di Imola Informatica.

In particolare, abbiamo deciso come organizzare la lettera di presentazione e il documento di valutazione del capitolato. Abbiamo inoltre formulato il preventivo da presentare ad un'ipotetico cliente.

Sono state inoltre scritte le domande per il rappresentante di Imola Informatica per l'incontro di venerdì 27 ottobre.\newline

\subsection{Analisi dei documenti}

Nonostante la riunione via Google Meet con Imola Informatica sia stata fissata per la data del 27 Ottobre 2023, si è anticipatamente abbozzato come strutturare il documento di valutazione del capitolato e la lettera di presentazione in due documenti distinti.

Il primo sarà un'analisi approfondita dei capitolati, contenente il dominio applicativo e tecnologico dei capitolati, e le motivazioni dietro alle nostre scelte.

Il secondo documento sarà una lettera nella quale si dichiara la candidatura di \textit{SWEet16} al progetto di Imola Informatica, evidenziando costi e tempistiche e l'impegno di tutti a rispettarli.\newline

\subsection{Analisi dei costi}

In un file Excel è stato elaborato un preventivo da consegnare ad un presunto cliente. Il documento in questione, una volta redatto, conterrà i costi orari di ciascun membro in base al ruolo che svolgerà. 

Un amministratore, per esempio, avrà un costo orario maggiore rispetto ad un programmatore, ma una somma delle ore minore.



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

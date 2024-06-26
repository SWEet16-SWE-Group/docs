<?php
set_include_path(__DIR__ . '/../../../../.libphp/');
require_once 'Utils.php';
require_once 'RegistroModifiche.php';
require_once 'Vocaboli.php';
require_once 'Validatore.php';
require_once 'Membri.php';

$titolo = '/home/lumine/Documenti/unipd/2023-2024-swe/docs/rtb/verbali/interni/2023-11-10/main.tex';
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
\textbf{Gruppo}: SWEet16 \\
\textbf{Email}:
\href{mailto:sweet16.unipd@gmail.com}{\nolinkurl{sweet16.unipd@gmail.com}}
\end{minipage}

\vspace{15mm}

\begin{center}
\begin{Huge}
        \textbf{Verbale Interno} \\
        \vspace{4mm}
        \textbf{10 Novembre 2023}
\end{Huge}

\vspace{20mm}

\begin{large}
\begin{spacing}{1.4}
\begin{tabular}{c c c}
   Redattori: & Alberto C. & \\
   Verificatori: & Alberto M. & \\
   Amministratore: & Alberto C. & \\
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
    1.0.0 & 2023/11/10 & Alberto M. & & Approvazione per il rilascio \\
    \hline
     0.1.0 & 2023/11/10 & Alberto C. & Alberto M. & Prima stesura del documento \\
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

\textbf{Inizio incontro}: Ore 13:00 \newline
\textbf{Fine incontro}: Ore 14:30 \newline

\pagebreak

\section{Sintesi ed elaborazione incontro}

Dopo aver corretto i problemi relativi alla candidatura ed aver vinto l'appalto del capitolato \textit{Easy Meal}, si è organizzato un incontro per delineare i prossimi passi del progetto.

\subsection{Problemi seconda candidatura}

Nei primi minuti dell'incontro si sono analizzati gli errori commessi durante il secondo tentativo di candidatura, come l'errore concettuale del versionamento, il quale presentava il problema che ciascuna verifica, una volta fatta, veniva salvata come versione successiva del documento. \\
E' stato quindi modificato il template di documento per incorporare un verificatore in ogni versione del documento.

\subsection{Miglioramento Way of Working}

In seguito si è discusso della solidificazione del nostro \textit{Way of Working}, in particolare sono state discusse delle regole per ottimizzare l'interazione tra componenti del gruppo e la suddivisione dei compiti. \\
E' stato quindi deciso di utilizzare GitHub come \emph{ITS (Issue Tracking System)}$^{G}$, stabilendo una prima divisione dei ruoli operativi. \\
Visto che non tutti i componenti del gruppo hanno familiarità con l'utilizzo di GitHub/GitHub Issues, è stato richiesto un allineamento delle conoscenze entro il prossimo incontro sincrono, in modo che tutti possano poter redigere e caricare documenti versionati in maniera autonoma.

\subsection{Analisi dei requisiti}
Si è cominciato a parlare del documento di analisi dei requisiti, è stato quindi deciso di intraprendere un percorso di studio individuale approfondito del capitolato offerto dal proponente, anche in vista di un futuro incontro con l'azienda per discutere dei requisiti da implementare.

\subsection{Studio tecnologie implementative}

Nella parte finale si è cominciato a parlare delle tecnologie da utilizzare durante l'implementazione del progetto e del \emph{PoC (Proof of Concept)}$^{G}$. \\
Essendo molti i linguaggi consigliati dal proponente e le possibilità offerte da ciascuno di questi, la scelta è stata prorogata per il futuro prossimo, dopo un'attenta analisi.
Prima ciascun membro di \textit{SWEet16} dovrà ricercare e studiare le tecnologie più compatibili per questo progetto e successivamente prendere la decisione finale in base allo studio effettuato. Tutto questo andrà fatto, ovviamente, dopo aver analizzato nel dettaglio le richieste del capitolato.

\subsection{Prossimo incontro}
Prima di terminare l'incontro si è decisa la data del prossimo meeting in base agli impegni personali del gruppo. \\
E' stato definito per giovedì 16 novembre.

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

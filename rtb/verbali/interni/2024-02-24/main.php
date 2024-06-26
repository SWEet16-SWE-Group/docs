<?php
set_include_path(__DIR__ . '/../../../../.libphp/');
require_once 'Utils.php';
require_once 'RegistroModifiche.php';
require_once 'Vocaboli.php';
require_once 'Validatore.php';
require_once 'Membri.php';

$titolo = '/home/lumine/Documenti/unipd/2023-2024-swe/docs/rtb/verbali/interni/2024-02-24/main.tex';
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
        \textbf{24 Febbraio 2024}
\end{Huge}

\vspace{20mm}

\begin{large}
\begin{spacing}{1.4}
\begin{tabular}{c c c}
   Redattori: & Alberto M. & \\
   Verificatori: & Alex S. & \\
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
    1.0.0 & 2023/12/16 & Alex S. & & Approvazione per il rilascio \\
    \hline
     0.1.0 & 2023/12/13 & Alberto M. & Alex S. & Prima stesura del documento \\
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

\textbf{Inizio incontro}: Ore 14:30 \newline
\textbf{Fine incontro}: Ore 15:30 \newline

\pagebreak

\section{Sintesi ed elaborazione incontro}

\subsection{Incontro con proponente}
L'incontro si è avviato con la condivisione dei feedback ricevuti dal proponente alla visione del \emph{PoC (Proof of Concept)}$^{G}$, durante l'incontro del 23 febbraio,
visto che non tutti i componenti del gruppo erano presenti perché in concomitanza con il diario di bordo settimanale.

\subsection{Riunioni settimanali}
Essendo la sessione invernale degli esami conclusa è stato deciso di ricominciare ad effettuare delle riunioni interne a cadenza settimanale, il giovedì sera alle 21. \\
Precedentemente alla sessione degli esami gli incontri erano programmati per il martedì sera, ma spostandoli verso la fine della settimana abbiamo la possibilità di fare un resoconto delle attività svolte più completo,
oltre che di semplificare la stesura del diario di bordo, essendo quest'ultimo ogni venerdì pomeriggio.

\subsection{Modalità stesura documentazione}
Tutti i componenti del gruppo sono stati allineati riguardo alla nuova procedura di stesura della documentazione, composta da:

\begin{itemize}
\item Suddivisione dei documenti in sezioni;
\item Apertura di una \emph{issue}$^{G}$ per ogni sezione;
\item Merge tramite \emph{pull request}$^{G}$ una volta terminata la stesura.
\end{itemize}

Alcuni dei componenti avevano dei dubbi riguardo l'utilizzo delle pull request che sono stati prontamente risolti.

\subsection{Scadenze}
Infine è stato deciso, dopo una discussione di gruppo, il 29 febbraio come data limite per la candidatura alla prima parte dell'\emph{RTB}$^{G}$, consistente dell'incontro con il Prof. Cardin e la consegna del documento di Analisi dei Requisiti. \\
Questo ci permetterà, una volta ricevuto il "semaforo verde", di concentrarci nella stesura della documentazione mancante, in particolare del Piano di Qualifica, per la candidatura alla seconda parte dell'RTB con il Prof. Vardanega.

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

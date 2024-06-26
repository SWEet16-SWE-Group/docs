<?php
set_include_path(__DIR__ . '/../../.libphp/');
require_once 'Utils.php';
require_once 'RegistroModifiche.php';
require_once 'Vocaboli.php';
require_once 'Validatore.php';
require_once 'Membri.php';

$titolo = '/home/lumine/Documenti/unipd/2023-2024-swe/docs/rtb/lettera-presentazione/main.tex';
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
\usepackage{float}
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

\setcounter{secnumdepth}{-2}

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
        \textbf{Lettera di presentazione} \\
        \vspace{4mm}

\end{Huge}

\vspace{20mm}

\begin{large}
\begin{spacing}{1.4}
\begin{tabular}{c c c}
   Redattori: & Alex S. & \\
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
  Versione & Data & Autore & Verificatore & Descrizione \\ \hline
  1.0.0 & 2024/04/17 & Alex S. & & Approvazione per il rilascio \\ \hline
  0.1.0 & 2024/04/15 & Alex S. & Alberto M. & Stesura lettera di presentazione per revisione RTB \\ \hline
\end{tblr}

\pagebreak

\section{Candidatura per Requirements and Technology Baseline}

Egregi prof. Vardanega e prof. Cardin,\\
\par
il gruppo SWEet16 è lieto di presentare la propria candidatura per la revisione di avanzamento Requirements and Technology Baseline (RTB),
nell'impegno di consegnare il progetto da Voi commissionato, denominato "Easy Meal" (capitolato C3), proposto dall'azienda Imola Informatica.

\par

La documentazione relativa alla valutazione dei capitolati e verbali
interni ed esterni sono visionabili nel sito:
\begin{center}
    \url{https://sweet16-swe-group.github.io/}
\end{center}
dove è possibile trovare:

\begin{itemize}
\item Verbali interni ed esterni;
\item Norme di Progetto v1.0.0;
\item Piano di Progetto v1.0.0;
\item Piano di Qualifica v1.0.0;
\item Analisi dei Requisiti v2.0.0.
\end{itemize}

Per consultare il repository del progetto è possibile visionare il seguente link:
\begin{center}
  \url{https://github.com/SWEet16-SWE-Group/docs}
\end{center}
\par
\section{Aggiornamento impegni}
Numerose criticità sono emerse durante la fase di RTB, dovute ad un utilizzo delle risorse a disposizione del gruppo non sempre ottimale, efficace e/o efficiente; in particolare,
il gruppo non è riuscito a valorizzare la figura del Responsabile, fondamentale soprattutto nella suddivisione ed assegnazione dei compiti tra i vari membri. \\
\par
Il gruppo si è trovato costretto a constatare tardivamente una deviazione sempre più importante dalla pianificazione originaria del progetto.
\par

Per questi motivi, la data di consegna del progetto è stata modificata. La nuova data di consegna
prevista è il 2024-06-15. Siamo certi che questo nuovo calendario ci permetterà di consegnare il
progetto nei tempi previsti senza comprometterne la qualità.

\par

Riteniamo che queste modifiche siano essenziali per garantire il successo del progetto e la Sua
soddisfazione finale.

\pagebreak
Il team è composto dai seguenti membri:

\begin{center}
  \begin{table}[H]
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
      Giovanni Zuliani & 595900 \\
  \end{tblr}
  \end{table}
  \end{center}

Cordiali saluti,\\
Il gruppo \emph{SWEet16}

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

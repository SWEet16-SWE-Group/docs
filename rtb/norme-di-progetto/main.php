<?php
set_include_path(__DIR__ . '/../../.libphp/');
require_once 'Utils.php';
require_once 'RegistroModifiche.php';
require_once 'Vocaboli.php';
require_once 'Validatore.php';
require_once 'Membri.php';

$titolo = '/home/lumine/Documenti/unipd/2023-2024-swe/docs/rtb/norme-di-progetto/main.tex';
$registro = (new RegistroModifiche())->logArray([
[CE, "2024/02/10", alberto_m(), iulius_s(), "Stesura scheletro"],
[CE, "2024/02/13", alberto_m(), alex_s(), "Stesura introduzione"],
[CE, "2024/02/15", alberto_m(), alex_s(), "Stesura fornitura"],
[CE, "2024/02/18", alberto_m(), alex_s(), "Stesura sviluppo"],
[CE, "2024/02/23", alex_s(), alberto_m(), "Stesura documentazione"],
[DX, "2024/02/27", alberto_m(), iulius_s(), "Aggiunte norme tipografiche"],
[CE, "2024/03/03", alex_s(), alberto_m(), "Stesura codifica"],
[CE, "2024/03/07", bilal_em(), alberto_m(), "Stesura gestione configurazione"],
[CE, "2024/03/11", alberto_m(), alex_s(), "Stesura progettazione"],
[DX, "2024/03/12", alex_s(), alberto_m(), "Modifica struttura UC"],
[CE, "2024/03/15", alberto_m(), alex_s(), "Stesura gestione qualità"],
[CE, "2024/03/19", alberto_m(), bilal_em(), "Stesura validazione"],
[CE, "2024/03/24", bilal_em(), alberto_m(), "Stesura verifica"],
[CE, "2024/03/29", alberto_m(), alex_s(), "Stesura gestione dei processi"],
[SX, "2024/04/15", alex_s(), "", "Approvazione per il rilascio"],
]);
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
\graphicspath{<?php echo pathimmagini(); ?>}

\setcounter{secnumdepth}{5}
\setcounter{tocdepth}{5}

\makeatletter
\newcommand\subsubsubsection{\@startsection{paragraph}{4}{\z@}{-2.5ex\@plus -1ex \@minus -.25ex}{1.25ex \@plus.25ex}{\normalfont\normalsize\bfseries}}
\newcommand\subsubsubsubsection{\@startsection{subparagraph}{5}{\z@}{-2.5ex\@plus -1ex \@minus -.25ex}{1.25ex \@plus.25ex}{\normalfont\normalsize\bfseries}}
\makeatother

% comandi per permettere di aggiungere altre sub section innestate

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
        \textbf{Norme di Progetto} \\
        \vspace{4mm}

\end{Huge}

\vspace{20mm}

\begin{large}
\begin{spacing}{1.4}
\begin{tabular}{c c c}
   Redattori: & Alberto M., Bilal E., Alex S. & \\
   Verificatori: & Iulius S., Alex S., Alberto M., Bilal E. & \\
   Amministratore: & Alex S. & \\
   Destinatari: & T. Vardanega & R. Cardin \\
   Versione: & 1.0.0 &
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
% fine sezione introduzione
\pagebreak

\section{Processi Primari}

<?php require_once __DIR__ . "/src/fornitura.php"; ?>
    %fine subsection fornitura

<?php require_once __DIR__ . "/src/sviluppo.php"; ?>
    %fine subsection sviluppo

<?php require_once __DIR__ . "/src/progettazione.php"; ?>

    %fine progettazione

<?php require_once __DIR__ . "/src/codifica.php"; ?>

    %fine codifica
%fine processi primari
\pagebreak

\section{Processi di Supporto}

<?php require_once __DIR__ . "/src/documentazione.php"; ?>

    % fine documentazione
<?php require_once __DIR__ . "/src/gestione-configurazione.php"; ?>
    % fine gestione della configurazione

<?php require_once __DIR__ . "/src/gestione-qualita.php"; ?>

    % fine gestione della qualità

<?php require_once __DIR__ . "/src/verifica.php"; ?>
    % fine verifica

<?php require_once __DIR__ . "/src/validazione.php"; ?>
% fine processi di supporto
\pagebreak

\section{Processi organizzativi}

<?php require_once __DIR__ . "/src/gestione-processi.php"; ?>

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

<?php
set_include_path(__DIR__ . '/../../.libphp/');
require_once 'Utils.php';
require_once 'RegistroModifiche.php';
require_once 'Vocaboli.php';
require_once 'Validatore.php';
require_once 'Membri.php';

$error_flag = 0;
$titolo = '/home/lumine/Documenti/unipd/2023-2024-swe/docs/rtb/piano-di-progetto/main.tex';
$registro = (new RegistroModifiche())
  ->log(CE, '2024/02/14', alex_s()->nome, iulius_s()->nome, 'Stesura scheletro')
  ->log(CE, '2024/02/23', bilal_em()->nome, alberto_m()->nome, 'Stesura introduzione')
  ->log(CE, '2024/02/24', alex_s()->nome, alberto_m()->nome, 'Stesura preventivo')
  ->log(CE, '2024/02/27', bilal_em()->nome, alex_s()->nome, 'Stesura analisi dei rischi')
  ->log(CE, '2024/03/19', bilal_em()->nome, alex_s()->nome, 'Stesura modello di sviluppo')
  ->log(CE, '2024/03/23', alex_s()->nome, alberto_m()->nome, 'Stesura consuntivo')
  ->log(CE, '2024/03/26', iulius_s()->nome, alex_s()->nome, 'Stesura pianificazione');
$nome = "Piano_di_progetto_v{$registro->versione()}.pdf";

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

\geometry{
a4paper,
left=25mm,
right=25mm,
top=20mm,
bottom=20mm,
}

\makeatletter
\newcommand\subsubsubsection{\@startsection{paragraph}{4}{\z@}{-2.5ex\@plus -1ex \@minus -.25ex}{1.25ex \@plus.25ex}{\normalfont\normalsize\bfseries}}
\newcommand\subsubsubsubsection{\@startsection{subparagraph}{5}{\z@}{-2.5ex\@plus -1ex \@minus -.25ex}{1.25ex \@plus.25ex}{\normalfont\normalsize\bfseries}}
\makeatother
% comandi per permettere di aggiungere altre sub section innestate

\setlength{\parskip}{1em}
\setlength{\parindent}{0pt}
\graphicspath{{../media/},{./src/Gantt}}

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
\textbf{Piano di Progetto} \\
\vspace{4mm}

\end{Huge}

\vspace{20mm}

\begin{large}
\begin{spacing}{1.4}
\begin{tabular}{c c c}
Redattori: & Alex S., Bilal E., Iulius S. & \\
Verificatori: & Alberto M., Alex S., Iulius S. & \\
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

<?php require_once __DIR__ . "/src/registro-modifiche.php"; ?>

\pagebreak
\tableofcontents
\pagebreak

<?php require_once __DIR__ . "/src/introduzione.php"; ?>

<?php require_once __DIR__ . "/src/analisi-dei-rischi.php"; ?>

<?php require_once __DIR__ . "/src/modello-di-sviluppo.php"; ?>

<?php require_once __DIR__ . "/src/pianificazione.php"; ?>

\pagebreak

<?php require_once __DIR__ . "/src/preventivo.php"; ?>

<?php require_once __DIR__ . "/src/consuntivo.php"; ?>

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

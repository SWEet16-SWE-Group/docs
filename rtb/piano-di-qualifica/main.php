<?php
set_include_path(__DIR__ . '/../../.libphp/');
require_once 'Utils.php';
require_once 'RegistroModifiche.php';
require_once 'Vocaboli.php';
require_once 'Validatore.php';
require_once 'Membri.php';

$titolo = '/home/lumine/Documenti/unipd/2023-2024-swe/docs/rtb/piano-di-qualifica/main.tex';

$registro = (new RegistroModifiche())->logArray([
[CE, "2024/02/16", alex_s(), alberto_m(), "Stesura scheletro"],
[CE, "2024/03/19", bilal_em(), alberto_m(), "Stesura introduzione"],
[CE, "2024/03/22", alberto_c(), alberto_m(), "Stesura test"],
[CE, "2024/03/25", giovanni_z(), alex_s(), "Stesura qualità di prodotto"],
[CE, "2024/04/02", alberto_c(), alex_s(), "Stesura resoconto delle attività di verifica"],
[CE, "2024/04/08", giovanni_z(), alberto_m(), "Stesura qualità di processo"],
[DX, "2024/04/10", alberto_c(), alex_s(), "Modifica grafici resoconto attività di verifica"],
[SX, "2024/04/15", alex_s(), "", "Approvazione per il rilascio"],
[CE, "2024/06/21", alex_s(), bilal_em(), "Aggiornamento resoconto"],
[SX, "2024/06/21", alex_s(), "", "Approvazione per il rilascio"],
]);

$nome = "Piano_di_qualifica_v{$registro->versione()}.pdf";
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
\usepackage{verbatim}

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

\setcounter{secnumdepth}{6}
\setcounter{tocdepth}{6}

\makeatletter
\newcommand\subsubsubsection{\@startsection{paragraph}{4}{\z@}{-2.5ex\@plus -1ex \@minus -.25ex}{1.25ex \@plus.25ex}{\normalfont\normalsize\bfseries}}
\newcommand\subsubsubsubsection{\@startsection{subparagraph}{5}{\z@}{-2.5ex\@plus -1ex \@minus -.25ex}{1.25ex \@plus.25ex}{\normalfont\normalsize\bfseries}}
\newcommand\subsubsubsubsubection{\@startsection{subparagraph}{6}{\z@}{-2.5ex\@plus -1ex \@minus -.25ex}{1.25ex \@plus.25ex}{\normalfont\normalsize\bfseries}}
\makeatother

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
        \textbf{Piano di Qualifica} \\
        \vspace{4mm}

\end{Huge}

\vspace{20mm}

\begin{large}
\begin{spacing}{1.4}
\begin{tabular}{c c c}
Redattori: & <?php echo $registro->autori(); ?> & \\
Verificatori: & <?php echo $registro->verificatori(); ?> & \\
Amministratore: & <?php echo alberto_m(); ?> & \\
Destinatari: & T. Vardanega & R. Cardin \\
Versione: & <?php echo $registro->versione(); ?> &
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

<?php require_once __DIR__ . "/src/qualita-di-processo.php"; ?>

<?php require_once __DIR__ . "/src/qualita-di-prodotto.php"; ?>

<?php require_once __DIR__ . "/src/test.php"; ?>

<?php require_once __DIR__ . "/src/resoconto-delle-attivita-di-verifica.php"; ?>

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

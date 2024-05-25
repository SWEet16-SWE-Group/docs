<?php

function str_replace_array($a, $s) {
  return str_replace(array_keys($a), $a, $s);
}

ob_start();
ob_start(function ($tex) {
  $tex = str_replace_array([
    'PATH_IMMAGINI' => '../media/',
    'REDATTORI' => '',
    'VERIFICATORI' => '',
    'AMMINISTRATORI' => '',
    'VERSIONE' => '1.0.0',
  ], $tex);
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
\usepackage[usenames,dvipsnames]{xcolor}
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
\graphicspath{{PATH_IMMAGINI}}

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
\textbf{Gruppo:} SWEet16 \\
\textbf{Email:}
\href{mailto:sweet16.unipd@gmail.com}{\nolinkurl{sweet16.unipd@gmail.com}}
\end{minipage}

\vspace{15mm}

\begin{center}
\begin{Huge}
\textbf{Titolo del documento} \\
\vspace{4mm}

\end{Huge}

\vspace{20mm}

\begin{large}
\begin{spacing}{1.4}
\begin{tabular}{c c c}
Redattori: & REDATTORI & \\
Verificatori: & VERIFICATORI & \\
Amministratore: & AMMINISTRATORI & \\
Destinatari: & T. Vardanega & R. Cardin \\
Versione: & VERSIONE &
\end{tabular}
\end{spacing}
\end{large}
\end{center}

\pagebreak

<?php require_once __DIR__ . '/src/registro-modifiche.php'; ?>

\pagebreak
\tableofcontents
\pagebreak

<?php
?>

\end{document}

<?php

ob_end_flush();
$tex = ob_get_contents();
ob_end_clean();


$a = getopt('p');
if (array_key_exists('p', $a)) {
  echo $tex;
} else {
  chdir(__DIR__);
  file_put_contents('main.tex', $tex);
}

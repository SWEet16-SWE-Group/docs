<?php
set_include_path(__DIR__ . '/../../.libphp/');
require_once 'Utils.php';
require_once 'RegistroModifiche.php';
require_once 'Vocaboli.php';
require_once 'Validatore.php';
require_once 'Membri.php';

$titolo = 'Glossario';
$pathsimmagini = [
  '../media/',
];
$registro = (new RegistroModifiche())
  ->log(CE, '2024/02/14', 'Alex S.   ', 'Iulius S. ', 'Stesura scheletro documento                  ')
  ->log(CE, '2024/02/23', 'Alex S.   ', 'Alberto M.', 'Inserimento prime definizioni                ')
  ->log(CE, '2024/02/24', 'Alberto C.', 'Alberto M.', 'Inserimento definizioni Analisi dei Requisiti')
  ->log(CE, '2024/02/27', 'Alberto C.', 'Alberto M.', 'Inserimento definizioni Norme di Progetto    ')
  ->log(DX, '2024/03/06', 'Alex S.   ', 'Iulius S. ', 'Aggiornamento definizioni                    ')
  ->log(CE, '2024/03/19', 'Alberto C.', 'Iulius S. ', 'Inserimento definizioni Piano di Progetto    ')
  ->log(CE, '2024/03/23', 'Alex S.   ', 'Alberto M.', 'Inserimento definizioni Piano di Qualifica   ')
  ->log(DX, '2024/03/26', 'Alberto C.', 'Iulius S. ', 'Aggiornamento definizioni                    ')
  ->log(SX, '2024/04/16', 'Alex S.   ', '          ', 'Approvazione per il rilascio                 ');

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
\graphicspath{<?php echo implode('', array_map(fn ($a) => sprintf('{%s}',$a), $pathsimmagini)); ?>}
\setcounter{secnumdepth}{-2}

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
\textbf{<?php echo $titolo; ?>} \\
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

\begin{huge}
\textbf{Registro delle modifiche}
\end{huge}
\vspace{5pt}

\begin{tblr}{
colspec={|X[1.5cm]|X[2cm]|X[2.5cm]|X[2.5cm]|X[5cm]|},
row{odd}={bg=white},
row{even}={bg=lightgray},
row{1}={bg=black,fg=white}
}

Versione & Data & Autore & Verificatore & Descrizione \\ \hline
<?php echo $registro; ?>

\end{tblr}

\pagebreak
\tableofcontents
\pagebreak

<?php echo print_vocaboli(); ?>

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

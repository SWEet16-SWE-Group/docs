<?php
set_include_path(__DIR__ . '/../../../../.libphp/');
require_once 'Utils.php';
require_once 'RegistroModifiche.php';
require_once 'Vocaboli.php';
require_once 'Validatore.php';
require_once 'Membri.php';

$titolo = '/home/lumine/Documenti/unipd/2023-2024-swe/docs/pb/verbali/esterni/2024-05-17/main.tex';
$nome = '2024_06_17_v1.0.0.pdf';
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
        \textbf{Verbale Esterno} \\
        \vspace{4mm}
        \textbf{17 giugno 2024}

\end{Huge}

\vspace{20mm}

\begin{large}
\begin{spacing}{1.4}
\begin{tabular}{c c c}
   Redattori: & Alex S. & \\
   Verificatori: & Julius S. & \\
   Amministratore: & Alberto M. & \\
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
        1.0.0 & 2024/06/17 & Alex S. & & Approvazione per il rilascio \\ \hline
        0.2.0 & 2024/06/17 & Sig. Staffolani & & Apposizione firma \\ \hline
        0.1.0 & 2024/06/17 & Alex S. & Alberto M. & Stesura del documento \\
        \hline

\end{tblr}

\pagebreak
\tableofcontents
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

Ha inoltre partecipato il Sig. Alessandro Staffolani, rappresentante di \textit{Imola Informatica}.

\vspace{10pt}

\textbf{Inizio incontro}: Ore 17:00 \newline
\textbf{Fine incontro}: Ore 17:30 \newline

\pagebreak

\section{Sintesi dell'incontro}

\subsection{Scopo principale}

In questo incontro è stato presentato l'MVP al proponente, Alessandro Staffolani, seguendo la tabella dei requisiti presente nella specifica tecnica.
Ogni requisito marcato come soddisfatto è stato mostrato in azione nel prodotto.

Successivamente è stato mostrato come eseguire i test di unità.
I test sono divisi in backend e frontend, le code coverage associate mostravano entrambe il target di 80% prefissato dal capitolato come superato.

Il proponente si è dimostrato molto soddisfatto del lavoro svolto.

\subsection{Miglioramenti proposti}

<?php
$a = [
  'Ingredienti aggiungibili con la pietanza' => <<<'EOF'
  Durante l'inserimento di una pietanza se non stati inseriti tutti i suoi ingredienti dovrebbero essere possibile aggiungerli direttamente lì con la pietanza.
  EOF,
];

echo implode("\n\n", array_map(fn ($domanda, $risposta)  => "\\subsubsection{{$domanda}}\n$risposta", array_keys($a), $a));
?>

\subsection{Approvazione dell'MVP}

Con il seguente documento il proponente dichiara la sua approvazione per il prodotto presentato.

\vspace{60pt}
\begin{flushleft}
\hfill Firma del proponente \\
\vspace{50pt}
\hfill Alessandro Staffolani, \textit{Imola Informatica}
\end{flushleft}
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

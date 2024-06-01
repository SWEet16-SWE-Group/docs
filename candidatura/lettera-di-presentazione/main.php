<?php
set_include_path(__DIR__ . '/../../.libphp/');
require_once 'Utils.php';
require_once 'RegistroModifiche.php';
require_once 'Vocaboli.php';
require_once 'Validatore.php';
require_once 'Membri.php';

$titolo = '/home/lumine/Documenti/unipd/2023-2024-swe/docs/candidatura/lettera-di-presentazione/main.tex';
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
\usepackage{array}
\usepackage[usenames,dvipsnames]{xcolor}
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
\textbf{Gruppo:} SWEet16 \\
\textbf{Email:} 
\href{mailto:sweet16.unipd@gmail.com}{\nolinkurl{sweet16.unipd@gmail.com}}
\end{minipage}

\vspace{15mm}

\begin{center}
\begin{Huge}
        \textbf{Lettera di Presentazione} \\
        \vspace{4mm}
        
\end{Huge}

\vspace{20mm}

\begin{large}
\begin{spacing}{1.4}
\begin{tabular}{c c c}
   Redattori:  &  Alberto M. & \\
   Verificatori: & Iulius S. & \\
   Amministratore: & Alberto C. & \\
   Destinatari: & T. Vardanega & R. Cardin \\  
   Versione: & 2.0.0 & 
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
    2.0.0 & 2023/11/06 & Alberto M. & Responsabile & Approvazione per rilascio \\
    \hline
    1.2.0 & 2023/11/06 & Alex S. & Verificatore & Verifica documento \\
    \hline
    1.1.0 & 2023/11/06 & Alberto M. & Responsabile & Modifica data consegna \\
    \hline
    1.0.0 & 2023/10/30 & Alberto M. & Responsabile & Approvazione per rilascio \\
    \hline
    0.3.0 & 2023/10/28 & Iulius S. & Verificatore & Verifica documento \\
    \hline
    0.2.0 & 2023/10/24 & Alberto M. & Responsabile & Completamento documento \\
    \hline
     0.1.0   & 2023/10/22 & Alberto M. & Responsabile & Stesura iniziale \\
     \hline
\end{tblr}
\pagebreak

Egregio Prof. Vardanega Tullio, \\
Egregio Prof. Cardin Riccardo, \\
il gruppo SWEet16 è lieto di comunicarle che intende candidarsi come fornitore del capitolato C3 proposto dall'azienda \textit{Imola Informatica} denominato \textbf{Easy Meal}.

La documentazione relativa al preventivo dei costi ed i verbali interni ed esterni sono presenti al seguente link:
\begin{center}
    \url{https://github.com/SWEet16-SWE-Group/docs}
\end{center}

all'interno della repository sono presenti i seguenti documenti:
\begin{itemize}
    \item Preventivo dei costi ed impegno individuale e totale;
    \item Studio dei capitolati e motivazione della scelta;
    \item Verbali interni: \\
        - 19/10/2023; \\
        - 25/10/2023; \\
        - 06/11/2023;
    \item Verbali esterni: \\
        - 27/10/2023;
    
\end{itemize}

Come già mostrato all'interno dell'apposito documento, il preventivo per il progetto ammonta ad un totale di \textbf{10.980,00€}, con data di consegna prevista entro il 30/04/2023. \\ \\
Questo il gruppo che lo presenta:

\begin{table}[h]
\begin{tblr}{
colspec={XXX},
row{odd}={bg=moregreen},
row{even}={bg=lightgreen},
row{1,8}={bg=darkgreen,fg=white}
}
    Nome & Matricola & Ruolo \\
    Alberto Cinel & 1142833 & Amministratore \\
    Bilal El Moutaren & 2053470 & Analista \\
    Alberto Michelazzo & 2010007 & Responsabile \\
    Alex Scantamburlo & 2042326 & Verificatore \\
    Iulius Signorelli & 2012434 & Verificatore \\
    Giovanni Zuliani & 595900 & Analista
\end{tblr}
\end{table}
\vspace{20pt}

La ringraziamo anticipatamente e le porgiamo cordiali saluti,  \\

\textit{SWEet16 - SWE Group}


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

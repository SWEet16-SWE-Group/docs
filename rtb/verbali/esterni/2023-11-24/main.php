<?php
set_include_path(__DIR__ . '/../../../../.libphp/');
require_once 'Utils.php';
require_once 'RegistroModifiche.php';
require_once 'Vocaboli.php';
require_once 'Validatore.php';
require_once 'Membri.php';

$titolo = '/home/lumine/Documenti/unipd/2023-2024-swe/docs/rtb/verbali/esterni/2023-11-24/main.tex';
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
        \textbf{Verbale Esterno} \\
        \vspace{4mm}
        \textbf{24 Novembre 2023}
\end{Huge}

\vspace{20mm}

\begin{large}
\begin{spacing}{1.4}
\begin{tabular}{c c c}
   Redattori: & Alberto M. & \\
   Verificatori: & Alex S. & \\
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
colspec={|X[1.5cm]|X[2cm]|X[2.4cm]|X[2.6cm]|X[5cm]|},
row{odd}={bg=white},
row{even}={bg=lightgray},
row{1}={bg=black, fg=white}
}
    Versione & Data & Autore & Verificatore & Descrizione \\
    \hline
    1.0.0 & 2023/11/28 & Alberto M. & & Approvazione per il rilascio \\
    \hline
    0.2.0 & 2023/11/28 & Sig. Staffolani & & Apposizione firma \\
     \hline
     0.1.0 & 2023/11/27 & Alberto M. & Alex S. & Prima stesura del documento \\
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

Ha inoltre partecipato il Sig. Alessandro Staffolani, rappresentante di \textit{Imola Informatica}.

\vspace{10pt}

\textbf{Inizio incontro}: Ore 16:10 \newline
\textbf{Fine incontro}: Ore 16:40 \newline

\pagebreak

\section{Sintesi ed elaborazione dell'incontro}

In questo secondo incontro con il sig. Staffolani, rappresentante di \textit{Imola Informatica}, ci siamo soprattutto concentrati della discussione per l'implementazione del PoC. \\
Abbiamo illustrato quali funzionalità volevamo implementare all'interno dello stesso, ovvero le \emph{prenotazioni}$^{G}$ condivise con amici e la chat testuale tra il cliente ed il ristoratore.

Secondo il rappresentante aziendale la chat può risultare superflua all'interno del PoC,
 ci consiglia quindi di concentrarci nell'implementazione della prenotazione di un tavolo e nell'ordinazione dei pasti (casi d'uso 2 e 3 del capitolato).

Continuando si è parlato delle tecnologie da utilizzare per realizzare il PoC:
dopo una nostra ricerca preliminare abbiamo individuato una libreria che permette di inglobare \emph{front-end}$^{G}$ e \emph{back-end}$^{G}$ all'interno di React: \textit{NextJs}.

E' una tecnologia recente e che il referente non conosce, inoltre teme che abbia funzionalità limitate e mancanza di documentazione. \\
Ci suggerisce uno studio più approfondito a riguardo, in ogni caso farà anche lui delle ricerche e ci farà sapere.

Sempre riguardo alle tecnologie è stato chiesto se sarebbe possibile tenere dei corsi di formazione riguardo alle tecnologie non conosciute dai membri del gruppo, in particolar modo su React. \\
Ci ha informato che anche gli altri gruppi (2) che stanno lavorando sul progetto hanno trovato React come tecnologia molto utile,
 quindi molto probabilmente si faranno i sopra citati incontri formativi in una data da fissare.

Per quanto riguarda i casi d'uso è stato richiesto un incontro per effettuare una revisione insieme al rappresentante, per discutere degli stessi e nel caso migliorarli. \\
E' stato fissato per venerdì 1 dicembre, e nel caso in cui non riuscissimo a terminarli entro quella data, ha dato disponibilità anche per giovedì 7 dicembre.

L'incontro si conclude con la creazione del canale di comunicazione \emph{Telegram}$^{G}$ tra il sig. Staffolani
e il gruppo SWEet16 per permettere una comunicazione asincrona per discutere di piccoli dubbi e delle date degli incontri sincroni.

\vspace{100pt}
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

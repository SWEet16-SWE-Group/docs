<?php
set_include_path(__DIR__ . '/../../../../.libphp/');
require_once 'Utils.php';
require_once 'RegistroModifiche.php';
require_once 'Vocaboli.php';
require_once 'Validatore.php';
require_once 'Membri.php';

$titolo = '/home/lumine/Documenti/unipd/2023-2024-swe/docs/rtb/verbali/esterni/2024-02-23/main.tex';
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
        \textbf{20 Febbraio 2024}

\end{Huge}

\vspace{20mm}

\begin{large}
\begin{spacing}{1.4}
\begin{tabular}{c c c}
   Redattori: & Alex S. & \\
   Verificatori: & Albero C. & \\
   Amministratore: & Alex S. & \\
   Destinatari: & T. Vardanega & R. Cardin \\
   Versione: & 0.1.0 &
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
        1.0.0 & 2024/02/24 & Alex S. & & Approvazione per il rilascio \\
        \hline
        0.2.0 & 2024/02/24 & Sig. Staffolani & & Apposizione firma \\
        \hline
        0.1.0 & 2024/02/23 & Alex S. & Alberto C. & Stesura del documento \\
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
    Alex Scantamburlo & 2042326 \\
    Giovanni Zuliani & 595900
\end{tblr}
\end{table}

Ha inoltre partecipato il Sig. Alessandro Staffolani, rappresentante di \textit{Imola Informatica}.

\vspace{10pt}

\textbf{Inizio incontro}: Ore 14:30 \newline
\textbf{Fine incontro}: Ore 15:00 \newline

\pagebreak

\section{Sintesi dell'incontro}

In questo primo incontro del 2024 con \textit{Imola Informatica}, al Sig. Staffolani sono state presentante le funzionalità implementate all'interno del PoC, concentratesi principalmente sui requisiti 2 e 3 espressi nel capitolato, rispettivamente i sistemi di prenotazione e ordinazione condivisa dei pasti.

Le funzionalità coperte sono le seguenti:

\begin{itemize}
\item Cliente:
\begin{itemize}
\item Prenotazione;
\item Invito di amici;
\item Ordinazione;
\item Visualizzazione in real-time delle ordinazioni;
\item Rimozione di ingredienti;
\item Conferma dei propri ordini.
\end{itemize}
\item Ristoratore:
\begin{itemize}
\item Accettazione o rifiuto di una prenotazione;
\item Visualizzazione in real-time delle ordinazioni con la lista di ingredienti totali necessari.
\end{itemize}
\end{itemize}

Il tour è stato fatto in modo più esaustivo possibile allo scopo di coprire quante più funzionalità possibili simulando l'uso più comune di quello che potrà essere il prodotto finito.
Alla fine del tour il rappresentante si è dimostrato soddisfatto con il lavoro svolto.

In seguito date le tecnologie utilizzate, MySQL in particolare, ci è stata consigliata una modalità per implementare in futuro la componente di login. Abbiamo dunque espresso la nostra idea di implementare un sistema di profili dove, registrato un account con la tipica email e password, l'utente ha poi la possibilità di creare più profili cliente o ristoratore. È stato fatto l'esempio di un gruppo familiare dove l'account è condiviso tra genitori e figli ma ognuno usa un profilo personale dedicato.
La scelta implementativa è stata lasciata a noi seppur sottolineando il guadagno nella esperienza dell'utente.

Concludendo, sono state espressi dei dubbi di natura implementativa e tecnologica.
Se utilizzare il tipo LongBlob all'interno del DB per il salvataggio delle immagini piuttosto che salvarle come file, la raccomandazione è stata invece di usare le funzionalità della REST API come ausilio per il salvataggio dei riferimenti alle immagini sul Database.
Successivamente è stata chiesta un'opinione su possibili framework da utilizzare lato backend con PHP, le cui raccomandazioni sono state Laravel e Symfony.

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

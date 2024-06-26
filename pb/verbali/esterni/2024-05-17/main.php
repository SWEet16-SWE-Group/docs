<?php
set_include_path(__DIR__ . '/../../../../.libphp/');
require_once 'Utils.php';
require_once 'RegistroModifiche.php';
require_once 'Vocaboli.php';
require_once 'Validatore.php';
require_once 'Membri.php';

$titolo = '/home/lumine/Documenti/unipd/2023-2024-swe/docs/pb/verbali/esterni/2024-05-17/main.tex';
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
        \textbf{17 Maggio 2024}

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
        Versione & Data & Autore & Verificatore & Descrizione \\
        \hline
        1.0.0 & 2024/05/20 & Alex S. & & Approvazione per il rilascio \\
        \hline
        0.2.0 & 2024/05/20 & Sig. Staffolani & & Apposizione firma \\
        \hline
        0.1.0 & 2024/05/17 & Alex S. & Alberto M. & Stesura del documento \\
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
    Alberto Michelazzo & 2010007 \\
    Alex Scantamburlo & 2042326 \\
    Iulius Signorelli & 2012434 \\
\end{tblr}
\end{table}

Ha inoltre partecipato il Sig. Alessandro Staffolani, rappresentante di \textit{Imola Informatica}.

\vspace{10pt}

\textbf{Inizio incontro}: Ore 16:30 \newline
\textbf{Fine incontro}: Ore 17:00 \newline

\pagebreak

\section{Sintesi dell'incontro}

\subsection{Scopo principale}

In questo incontro sono stati discussi i requisiti opzionali che saranno implementati.

I requisiti opzionali che saranno implementati nell'MVP sono i seguenti:

\begin{itemize}
\item Il sistema multi utente, utilizzo di più profili con le stesse mail e password;
\item Ricerca tramite tipologie di cucine proposte dal ristorante;
\item Aggiunta di ingredienti a pietanze in fase di ordinazione;
\item Un sistema ‘fittizio’ per pagare in app;
\item Durante la fase di creazione del profilo cliente esso fornisce eventuali allergie o intolleranze;
\item Il messaggio di conferma in caso di selezione di pietanze che contengono allergeni presenti nel profilo del cliente;
\item Durante la creazione di nuovi ingredienti vengono aggiunti gli allergeni ad esso collegati (ad es: Farina - Glutine);
\item Dopo che il primo cliente seleziona la modalità di pagamento non sarà più possibile modificarla.
\end{itemize}

I requisiti opzionali che non saranno implementati al fine dell'MVP sono i seguenti:

\begin{itemize}
\item Push-notification;
\item Recensioni;
\item Chat testuale;
\item Il pagamento in app per clienti che non siamo noi, nel caso di divisione del conto alla romana;
\item Il pagamento in app di pietanze ordinate non da noi, nel caso di divisione del conto proporzionale;
\item La vista a calendario con le prenotazioni raggruppate per giorno e il dettaglio di ingredienti di ogni giorno.
\end{itemize}

Il proponente si è trovato d'accordo con queste decisioni.

\subsection{Domande generali}

\begin{itemize}
\item \textbf{Domanda}: Nei dockerfile bisogna installare NPM e composer per esempio manualmente tramite comando o non serve ?%;
\item \textbf{Risposta}: È norma per ogni servizio fornire un immagine docker già preparata ad hoc, utilizzando ad esempio FROM all'interno del dockerfile, ed è necessario solo importare la propria libreria nel container. \\ Ad esempio per node viene copiato il package.json e il proprio codice ed eseguire `npm build`, il container sarà già fornito di tutti gli strumenti necessari completare la costruzione con successo. \\ \\ Sono stati poi menzionati i bundle (Es. MySQL più Apache) e i dockerfile multistage. \\ Per questi ultimi il sig. Staffolani ci ha spiegato a voce il seguente \href{https://medium.com/@mohamedbenkhemiswork576/how-to-dockerize-a-react-app-with-multi-stage-build-and-nginx-minimize-react-image-size-by-80-33a09ae20118}{tutorial}.
\end{itemize}

\begin{itemize}
\item \textbf{Domanda}: È meglio avere un indicatore di code coverage unico per backend e frontend o averne due separati ?%;
\item \textbf{Risposta}: Ci è stato consigliato di utilizzare due code coverage separate per backend e frontend, quanto contano come due applicazione separate e in un contesto reale sarebbero sviluppate da team diversi.
\end{itemize}

\subsection{Prossimo incontro}

Si è deciso di tenere incontri a scadenza settimanale e il prossimo incontro è stato prefissato per il venerdì seguente (2024-05-24) alla stessa ora (16.30 CET).

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

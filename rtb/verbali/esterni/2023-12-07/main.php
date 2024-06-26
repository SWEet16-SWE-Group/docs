<?php
set_include_path(__DIR__ . '/../../../../.libphp/');
require_once 'Utils.php';
require_once 'RegistroModifiche.php';
require_once 'Vocaboli.php';
require_once 'Validatore.php';
require_once 'Membri.php';

$titolo = '/home/lumine/Documenti/unipd/2023-2024-swe/docs/rtb/verbali/esterni/2023-12-07/main.tex';
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
        \textbf{7 Dicembre 2023}
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
        1.0.0 & 2023/12/14 & Alberto M. & & Approvazione per il rilascio \\
        \hline
        0.2.0 & 2023/12/13 & Sig. Staffolani & & Apposizione firma \\
         \hline
         0.1.0 & 2023/12/07 & Alberto M. & Alex S. & Prima stesura del documento \\
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
\end{tblr}
\end{table}

Ha inoltre partecipato il Sig. Alessandro Staffolani, rappresentante di \textit{Imola Informatica}.

\vspace{10pt}

\textbf{Inizio incontro}: Ore 15:00 \newline
\textbf{Fine incontro}: Ore 15:45 \newline

\pagebreak

\section{Sintesi dell'incontro}

In questo incontro avvenuto con \textit{Imola Informatica} via Microsoft Teams, dopo una prima stesura dei vari casi d'uso, abbiamo illustrato i nostri dubbi riscontrati al sig. Staffolani.
I nostri più grandi dubbi sono sulla prenotazione ed ordinazione condivisa, e su come l'amministratore di ristorante debba rapportarsi rispetto alle ordinazioni dei clienti precedentemente il loro arrivo al ristorante, in modo da creare un \emph{consuntivo}$^{G}$ degli ingredienti necessari.

Di seguito le domande che sono state poste al rappresentante aziendale.

\section{Domande e risposte}

\textbf{Il sistema come deve gestire la situazione in cui non tutti gli utenti di una \\prenotazione hanno fatto il proprio ordine?}

Potete gestirlo come preferite voi, ad esempio si può decidere che in caso un utente (tra quelli invitati) ignori e non confermi la sua partecipazione allora potrà solo ordinare direttamente al ristorante. \\
Chi invece ha dato conferma della sua partecipazione viene aggiunto alla lista delle persone che possono ordinare anticipatamente. \\ \newline

\textbf{La nostra idea era di aggiungere un campo "mail degli amici da invitare" al momento della prenotazione, tuttavia questo genererebbe un problema in quanto non avremmo modo di poter validare se le email effettivamente esistono. \\
Può andare bene come idea?}

Potete eliminare in un primo momento questo campo dalla prenotazione e semplicemente \\generare un link per la condivisione della prenotazione, che poi potrà essere condiviso come ogni utente preferisce (\emph{WhatsApp}$^{G}$, Telegram, email, ecc.) \\ \newline

\textbf{Il ristoratore può vedere il consuntivo degli ingredienti solo di un giorno o anche di un periodo più ampio? Noi cosa dobbiamo offrire come funzionalità?}

Ha senso poter selezionare un range di tempo più ampio (2 giorni, 1 settimana, ecc.), tuttavia il problema è che quasi sicuramente il ristorante non sarà al completo tutti i giorni, e quindi il ristoratore potrebbe avere dei dati fuorvianti, riguardo agli ingredienti da acquistare, ad esempio tra 2 settimane. \\
Per porre rimedio a questo problema si può porre una data limite dopo la quale non è più possibile effettuare ordini o modificarli (ad esempio fino a mezzanotte del giorno prima della data di prenotazione). \\
E' possibile inoltre introdurre una sanzione in caso i clienti non si presentino al ristorante. \\ \newline

\pagebreak

\textbf{Nel capitolato è esplicitato il fatto che il cliente possa rilasciare una recensione solo dopo aver pagato, quindi solo i clienti che hanno effettuato un pagamento possono scrivere delle recensioni?}

No, possono farlo tutti i clienti che hanno partecipato ad una prenotazione, si può ad esempio introdurre un campo all'interno della prenotazione chiamato "Stato pagamento"
e solo una volta che tutte le pietanze della prenotazione sono state effettivamente pagate allora tutti gli utenti facenti parte della prenotazione possono lasciare una recensione. \\ \newline

\textbf{Premettendo di aver deciso in un primo momento di utilizzare React per la parte di front-end e PHP come back-end, ci siamo poi accorti che sarebbe più utile andare ad utilizzare NodeJS per la parte di back-end, lei ha qualche consiglio da darci a riguardo?}

Era stato consigliato PHP come linguaggio per il back-end perché già conosciuto e utilizzato dai membri del gruppo, ad esempio nel corso di Tecnologie Web. \\
NodeJS (ed il framework \emph{Express}$^{G}$) sono molto utili perché nativamente scritti in Javascript, è inoltre molto facile fare deploy delle applicazioni ed utilizzarlo. \\
In più è molto ben documentato, con numerose librerie già implementate per funzionalità da noi utilizzabili (autenticazione, socket, ecc.). \\
Ci viene consigliato di utilizzare \emph{NextJs}$^{G}$, che offre più funzionalità nativamente disponibili \\ "out of the box" rispetto ad Express, ad esempio creare in modo più facile la documentazione per le nostre API.

Tuttavia, che si usi PHP o NodeJS, l'obiettivo finale è lo stesso, ovvero andare a creare delle API REST che vadano a comunicare tramite un'interfaccia standard.\\ \newline

\textbf{Ha qualche novità riguardo ai seminari sulle tecnologie da utilizzare per il progetto?}

Ha chiesto a dei suoi colleghi quando e come sarà possibile effettuare dei seminari su Docker, ci farà sapere più avanti. \\ \newline

\subsection{Problemi con docker}

Sono stati poi chiesti dei consigli di carattere tecnico riguardanti l'utilizzo di docker, con cui stiamo avendo dei problemi.
Ci sono quindi state illustrate alcune soluzioni ai nostri problemi.

\vspace{40pt}
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

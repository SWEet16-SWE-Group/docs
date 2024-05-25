<?php
set_include_path(__DIR__ . '/../../../../.libphp/');
require_once 'Utils.php';
require_once 'RegistroModifiche.php';
require_once 'Vocaboli.php';
require_once 'Validatore.php';
require_once 'Membri.php';

$titolo = '/home/lumine/Documenti/unipd/2023-2024-swe/docs/candidatura/verbali/esterni/2023-10-27/main.tex';
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
        \textbf{Verbale Esterno} \\
        \vspace{4mm}
        \textbf{27 Ottobre 2023}
\end{Huge}

\vspace{20mm}

\begin{large}
\begin{spacing}{1.4}
\begin{tabular}{c c c}
   Redattori:  &  Alberto C. & \\
   Verificatori: & Alberto M. & \\
   Amministratore: &  Alberto C. & \\
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
    1.2.0 & 2023/11/06 & Sig. Staffolani & Esterno & Apposizione firma \\
    \hline
    1.1.0 & 2023/11/06 & Alberto M. & Responsabile & Typo sezione 2.1 \\
    \hline
    1.0.0 & 2023/10/29 & Alberto M. & Responsabile & Approvazione per rilascio \\
    \hline
     0.2.0 & 2023/10/27 & Alberto M. & Responsabile & Verifica documento \\
     \hline
     0.1.0 & 2023/10/27 & Alberto C. & Amministratore & Prima stesura del documento \\
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
row{1}={bg=darkgreen,fg=white}
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

\textbf{Inizio incontro:} Ore 14:30 \newline
\textbf{Fine incontro:} Ore 16:00  \newline

\pagebreak

\section{Sintesi dell'incontro}

In questo incontro avvenuto con Imola Informatica via Microsoft Teams si è fatta la conoscenza sopracitato del sig. Alessandro Staffolani, referente di \textit{Imola Informatica} proponente del capitolato \textit{Easy Meal}.

Dopo una breve presentazione del gruppo, degli aspetti e delle motivazioni che hanno deciso di far concorrere \textit{SWEet16} alla gara d'appalto per questo progetto, si sono posti dubbi e perplessità su quest'ultimo.

Nella prossima pagina sono riportate domande e risposte verbalizzate della videochiamata avvenuta e successivamente un breve resoconto finale.\newline

\subsection{Domande e risposte}

\textbf{In che modo possiamo implementare correttamente l’applicazione richiesta?  \\
Quali linguaggi o framework sono consigliati?}

Nessun vincolo sulla tecnologia, ci sono però alcuni framework consigliati: classici framework tra cui React, Angular e Vue. \\ 
Il proponente consiglia React per la parte client in quanto è la tecnologia che utilizza più spesso e che conosce meglio. \\
Per la parte backend consiglia di usare una REST API, usando un linguaggio come NodeJS, JavaScript, PHP, GO o Rust. La scelta va documentata e motivata.\newline

\textbf{E’ necessario implementare un sistema di pagamento all’interno dell’applicazione?}

L'implementazione è complicata a livello di progettazione universitaria, 
sia dal punto di vista della privacy che da quello dei costi, si può quindi decidere di non implementarlo, basta solo che la Webapp comunichi che il cliente deve effettuare il pagamento delle pietanze prenotate in precedenza, il pagamento avverrà poi in maniera "fisica" alla cassa del ristorante. \newline 

\textbf{Come gestire la chat tra clienti e ristoratori?}

Si può sia implementare una chat da zero, sia prenderla da servizi esterni. Entrambe le soluzioni sono corrette, basta arrivare agli stessi risultati.
Esistono molte librerie online che facilitano molto il lavoro di implementazione. \\
Anche in questo caso la scelta va documentata e motivata.\newline

\textbf{Come gestire la crittografia delle chat testuali?}

La crittografia può essere implementata sia end-to-end sia basata su cloud (tipo Telegram). \\
Si ricorda comunque che questo è un requisito opzionale.\newline

\textbf{Ci sono preferenze sull'implementazione del Database?}

Va bene qualsiasi tipologia di Database, sia SQL che NoSQL.\\
La scelta va comunque documentata e motivata.\newline

\textbf{Che tipo di supporto può fornire l'azienda? Quanto spesso?}

Imola Informatica si impegna ad effettuare una videochiamata con i membri del gruppo almeno una volta a settimana (normalmente di venerdì) in modo da presentare i vari dubbi e ricevere consigli. \\
Questa può anche non esserci per una settimana oppure ce ne possono essere più di una a settimana, in base alla disponibilità dell'aziende e dei bisogni del gruppo. \\
Il sig. Staffolani si è reso disponibile alla creazione di un gruppo Telegram con i membri di \textit{SWEet16} per avere un canale di comunicazione asincrono. \\
Inoltre si valuterà insieme all'azienda se effettuare delle piccole presentazioni di 2-3 ore per mostrare tecnologie non conosciute dal gruppo. \newline

\textbf{Cosa è richiesto per quanto riguarda il POC?}

L'azienda non richiede una cosa troppo complicata, basta la pagina di login, la lista dei ristoranti da scegliere e il menù di ciascun ristorante.
In ogni caso se ne parlerà più specificatamente in un momento successivo.\newline

\subsection{Resoconto finale}

Per quanto riguarda il progetto \textit{Easy Meal}, Imola Informatica lascia generalmente carta bianca su come e cosa implementare, l'importante è che tutto venga documentato e motivato. \\
Il sig. Alessandro Staffolani, il referente, si impegna inoltre a seguire passo passo, di settimana in settimana, il progresso di \textit{SWEet16} e a rispondere ai nostri dubbi.

\vspace{200pt}
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

<?php
set_include_path(__DIR__ . '/../../.libphp/');
require_once 'Utils.php';
require_once 'RegistroModifiche.php';
require_once 'Vocaboli.php';
require_once 'Validatore.php';
require_once 'Membri.php';

$titolo = '/home/lumine/Documenti/unipd/2023-2024-swe/docs/candidatura/analisi-capitolati/main.tex';
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
        \textbf{Analisi capitolati} \\
        \vspace{4mm}
        
\end{Huge}

\vspace{20mm}

\begin{large}
\begin{spacing}{1.4}
\begin{tabular}{c c c}
   Redattori:  &  Alberto M. & \\
   Verificatori: & Iulius S. &  \\
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
    1.1.0 & 2023/11/06 & Alberto C. & Amministratore & Modifica sezione 2 \\
    \hline
    1.0.0 & 2023/10/30 & Alberto M. & Responsabile & Approvazione per rilascio \\
    \hline
    0.5.0 & 2023/10/29 & Alex S. & Verificatore & Verifica documento \\
    \hline
    0.4.0 & 2023/10/29 & Iulius S. & Verificatore & Modifica sezione 2 \\
    \hline
    0.3.0 & 2023/10/25 & Alberto M. & Responsabile & Stesura sezioni 3, 4 \\
    \hline
    0.2.0 & 2023/10/23 & Iulius S. & Verificatore & Verifica sezioni 1, 2 \\
    \hline
     0.1.0   & 2023/10/22 & Alberto M. & Responsabile & Stesura sezioni 1, 2 \\
     \hline
\end{tblr}

\pagebreak
\tableofcontents
\pagebreak 

\section{Introduzione}

\subsection{Scopo del documento}
Lo scopo del presente documento è quello di indicare le motivazioni che hanno portato alla decisione di intraprendere il progetto esposto nel capitolato C3 Easy Meal proposto dall'azienda \textit{Imola Informatica}, tramite un'approfondita analisi. \\

In seguito alla pubblicazione dei capitolati, sono stati individuati quelli di maggior interesse per il gruppo, ovvero:
\begin{itemize}
    \item C3: Easy Meal di \textit{Imola Informatica}
    \item C2: Sistemi di raccomandazione di \textit{Ergon}
    \item C8: JMAP, il nuovo protocollo per la posta elettronica di \textit{Zextras}
\end{itemize}

\vspace{10pt}
\subsection{Riferimenti}
\begin{enumerate}
    \item Capitolato C2, disponibile su \url{https://www.math.unipd.it/~tullio/IS-1/2023/Progetto/C2.pdf}
\item Capitolato C3, disponibile su \url{https://www.math.unipd.it/~tullio/IS-1/2023/Progetto/C3.pdf}
\item Capitolato C8, disponibile su \url{https://www.math.unipd.it/~tullio/IS-1/2023/Progetto/C8.pdf}
\end{enumerate}

\pagebreak

\section{Valutazione del capitolato scelto}
\subsection{Capitolato C3 - Easy Meal}
\subsubsection{Descrizione}
    \begin{itemize}
        \item Proponente: Imola Informatica
        \item Committenti: Prof. Tullio Vardanega e Prof. Riccardo Cardin
        \item Obiettivo: Creare un'applicazione web responsive che permetta di semplificare il processo di prenotazione di un tavolo ed ordinazione nei ristoranti da parte dei clienti.
    \end{itemize}

\subsubsection{Dominio applicativo} 
Due sono gli obiettivi di questo progetto:
\begin{enumerate}
    \item Rendere più semplice, divertente e coinvolgente, tramite un'applicazione web responsive, l’esperienza culinaria del clienti, accompagnandolo in tutte le fasi della stessa, dalla prenotazione al pagamento;
    \item  Fornire al ristoratore uno strumento che gli permetta una pianificazione più precisa dell'acquisto di materie prime, diminuendo così gli sprechi alimentari, tema oggigiorno molto importante;
\end{enumerate}
 
\vspace{20pt}
Sono presenti due tipi di utenti:
\begin{itemize}
    \item \textbf{Clienti:} sono i principali utilizzatori dell’applicazione; possono effettuare la prenotazione presso un ristorante, visionare il relativo menù ed effettuare l'ordinazione eventualmente prima dell'arrivo (condividendo tali esperienze con altri clienti tramite link).
    \item \textbf{Ristoratore:} può controllare le prenotazioni effettuate dai clienti, degli ordini da loro effettuati (potendo così calcolare le materie prime necessarie per il servizio), ed il menù del proprio ristorante.
\end{itemize}

\subsubsection{Dominio tecnologico}
L'azienda committente richiede l'implementazione di un applicazione \textit{web responsive} (PC, IOS e Android).
Durante l'incontro ci è stato detto che viene lasciata totale libertà implementativa, tuttavia sono stati consigliati alcune tecnologie:
\begin{itemize}
    \item Per la parte client l'utilizzo di React, Angular o Vue.
    \item Per la parte server l'utilizzo di API Restful, che possiamo implementare con NodeJS, JavaScript, PHP, ecc.
\end{itemize}
E' stata inoltre sottolineata l'importanza di documentare tutte le scelte implementative che andranno effettuate.

\pagebreak

\subsubsection{Motivazione della scelta}
\begin{itemize}
    \item Risulta interessante da un punto di vista tecnologico e di implementazione da parte di tutti i componenti del gruppo;
    \item Pregressa esperienza riguardante applicazioni \textit{Web Based} da parte di alcuni componenti del gruppo;
    \item Assenza di vincoli per le tecnologie in fase di sviluppo e libertà nell'implementazione;
    \item Presentazione del capitolato chiara e stimolante da parte dell'azienda;
    \item Il rappresentante aziendale si è dimostrato molto collaborativo, ventilando la possibilità di organizzare brevi seminari sulle tecnologie utilizzate nell'ambito del progetto;
    \item Obiettivi e casi d'uso chiari e specifici;
\end{itemize}

\subsubsection{Conclusioni}
Il capitolato in questione ha attirato fin da subito l'attenzione dell'intero gruppo, soprattutto perché gli permetterebbe  di acquisire e consolidare le proprie conoscenze in ambito web, sia front-end che back-end. \\
L'incontro con il rappresentante aziendale e la disponibilità da egli dimostrata nei confronti del gruppo hanno ulteriormente consolidato la nostra scelta. \\ 
A seguito di quanto evidenziato, il gruppo SWEet16 ha deciso questo capitolato come nostra prima scelta.

\pagebreak

\section{Valutazione della seconda scelta}
\subsection{Capitolato C2 - Sistemi di Raccomandazione}
\subsubsection{Descrizione}
    \begin{itemize}
        \item Proponente: Ergon
        \item Committenti: Prof. Tullio Vardanega e Prof. Riccardo Cardin
        \item Obiettivo: Creare un Sistema di Raccomandazione che guidi le aziende suggerendo a quali clienti rivolgere specifiche attività di marketing.
\end{itemize}
\subsubsection{Dominio applicativo}

Il progetto si contestualizza in tutte le aziende in cui il core business è dato dalla vendita di prodotti (alimentari, moda, ecc.) dove i clienti effettuano ordini d'acquisto. \\
Le aziende attivano campagne di marketing per promuovere prodotti a specifichi target, queste campagne si dividono in due categorie:
\begin{enumerate}
    \item Ad ampio spettro, dove tutti i clienti ricevono la stessa offerta.
    \item Con campagne mirate a singoli clienti in base ai loro precedenti acquisti, oppure consigliando prodotti acquistati da altri clienti con interessi simili.
\end{enumerate}

\subsubsection{Dominio tecnologico}
Il progetto si divide in quattro componenti base:
\begin{itemize}
    \item \textbf{Database relazione} per la gestione dei dati: \\
        L'azienda suggerisce di utilizzare un qualsiasi linguaggio per database relazionali.
    \item \textbf{Sistema di raccomandazione}. \\
        In cui l'azienda suggerisce l'uso del framework .NET in linguaggio C\#.
    \item \textbf{Comunicazioni da/per il database}: \\
        L'azienda suggerisce l'utilizzo di un Entity Framework, ad esempio ADO.NET, che consente di astrarre il database dall'applicativo.
    \item \textbf{Interfaccia utente} in cui mostrare i risultati: \\
        Può essere sviluppato desktop-based (.NET) oppure web-based.
\end{itemize}

\pagebreak
\subsubsection{Aspetti positivi}
\begin{itemize}
    \item Progetto innovativo;
    \item Totale libertà nella scelta delle tecnologie da utilizzare;
    \item Il capitolato tratta di Machine Learning, argomento molto interessante in un futuro ambito lavorativo;
    \item Utilizzo e apprendimento di linguaggi di programmazione mai utilizzati dalla maggior parte dei componenti del gruppo;
\end{itemize}

\subsubsection{Aspetti critici}
\begin{itemize}
    \item Limitata conoscenza di Machine Learning e sua implementazione da parte del gruppo;
    \item Il progetto richiederebbe un discreto investimento di risorse relativamente alla formazioni sugli argomenti;
    \item Capitolato molto ambito da diversi gruppi;
\end{itemize}

\subsubsection{Conclusioni}
Questo capitolato è stato scelto come seconda opzione da parte del gruppo a votazione dato che aveva argomenti molto interessanti ed innovativi. \\
Tuttavia, la quasi completa inesperienza verso gli argomenti trattati e la bassa possibilità di aggiudicazione dell'appalto ci ha fatto demordere dalla scelta di questo capitolato come argomento del nostro progetto.

\pagebreak

\section{Valutazione della terza scelta}
\subsection{Capitolato C8 - JMAP: il nuovo protocollo per la posta elettronica}
\subsubsection{Descrizione}
\begin{itemize}
    \item Proponente: Zextras 
    \item Committenti: Prof. Tullio Vardanega e Prof. Riccardo Cardin 
    \item Obiettivo: Implementazione di una demo utilizzabile in cui si implementa il protocollo JMAP, in cui si effettuano test rispetto alla precedente alternativa IMAP.
\end{itemize}
\subsubsection{Dominio applicativo}

Il principale prodotto di Zextras è Carbonio, una soluzione collaborativa online on-premise il cui fulcro ruota attorno l'email personale. \\
Il protocollo utilizzato da Carbonio è IMAP, risalente all'ormai lontano 1986. \\
L'azienda vuole quindi capire se abbia senso investire tempo e denaro per implementare il nuovo standard JMAP all'interno del loro prodotto, mantenendo i vecchi standard per compatibilità.

\subsubsection{Dominio tecnologico}
\begin{itemize}
    \item Il proponente non pone vincoli sul linguaggio utilizzato dal gruppo di lavoro, ma ha comunque una preferenza verso Java (linguaggio principale di Carbonio). 
    \item Richiede l'utilizzo della libreria iNPUTmice/jamp per l'implementazione del protocollo JMAP.
    \item Il servizio deve essere eseguibile in un sistema container, come Docker, per poter testare facilmente le funzionalità e le performance.
    \item Il servizio deve essere inoltre scalabile mediante l'inizializzazione di più nodi stateless.
\end{itemize}

L'azienda inoltre rimarca l'importanza di coprire - anche parzialmente - il requisito riguardante gli stress test.

\subsubsection{Aspetti positivi}
\begin{itemize}
    \item Standard innovativi;
    \item Presentazione del capitolato concisa e stimolante;
    \item Potrebbe essere molto utile all’azienda proponente;
\end{itemize}

\pagebreak

\subsubsection{Aspetti critici}
\begin{itemize}
    \item Gli argomenti nonostante siano molto interessanti sono poco conosciuti dalla maggior parte del gruppo;
    \item Il progetto richiederebbe un discreto investimento di risorse relativamente alla formazione sugli argomenti;
    \item Utilità limitata dell'app;
    \item Obiettivo generico e con una richiesta di impiego di risorse ritenuta eccessivo;
\end{itemize}

\subsubsection{Conclusioni}

Questo capitolato è stato scelto come terza opzione da parte del gruppo a votazione dato che utilizzava standard tecnologici molto innovativi. \\
Tuttavia, la limitata utilità dell'app al di fuori dell'azienda proponente e l'interesse minore di questo capitolato rispetto ad altri, ci ha portato alla decisione di non scegliere questo come argomento del nostro progetto.





































        
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

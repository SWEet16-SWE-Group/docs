\nonstopmode
\section{Introduzione e scopo del documento}

\subsection{Scopo del documento}

Il presente documento ha lo scopo di descrivere e motivare tutte le scelte architetturali che sono state fatte nella fase di progettazione e codifica del prodotto.\\
Vengono quindi descritte l'architettura logica e di deployment, i design pattern adottati e le tecnologie impiegate nella realizzazione del prodotto per il progetto \textit{Easy Meal}.
\subsection{Scopo del prodotto}

Lo scopo dell’applicazione è quello di creare una piattaforma che permetta di gestire e semplificare il processo di \emph{prenotazione}$^{G}$ di tavoli all’interno dei ristoranti. \\
Sarà inoltre possibile anticipare l’esperienza culinaria visionando prima il menù ed andando ad effettuare la propria \emph{ordinazione}$^{G}$ prima di arrivare al ristorante. \\
Il prodotto offre inoltre un’esperienza di ordinazione delle \emph{pietanze}$^{G}$ collaborativa e coinvolgente, permettendo di condividerla con amici.

L’idea è una piattaforma \emph{SaaS (Software as a Service)}$^{G}$, in cui i saranno presenti due tipi di utenti:
\begin{itemize}
\item \emph{Cliente}$^{G}$: Utente registrato all’interno dell’applicazione, può cercare ristoranti, effettuare prenotazioni, ordinazioni e inserire feedback e recensioni;
\item \emph{Ristoratore}$^{G}$: Utente registrato all’interno dell’applicazione, può gestire uno o più ristoranti, controllando le prenotazioni e le ordinazioni dei clienti ed i menù del/i ristorante/i.
\end{itemize}


La piattaforma dovrà essere disponibile attraverso una \emph{Webapp}$^{G}$ accessibile da qualsiasi dispositivo, esso sia \emph{Desktop}$^{G}$ o \emph{Mobile}$^{G}$.


\subsection{Glossario}

Al fine di evitare possibili ambiguità o incomprensioni riguardanti la terminologia usata nel documento, è stato deciso di adottare un glossario in cui vengono riportate le varie definizioni. \\
In questa maniera in esso verranno posti tutti i termini specifici del dominio d’uso con relativi significati. \\
La presenza di un termine all’interno del glossario viene indicata applicando una " $^{G}$ " ad apice della parola.


\subsection{Maturità del documento}

Il presente documento è redatto con un approccio incrementale al fine di poter trattare nuove o ricorrenti questioni in modo rapido ed efficiente, sulla base di decisioni concordate tra tutti i membri del gruppo. \\
Non può pertanto essere considerato definitivo nella sua attuale versione.

\subsection{Riferimenti}

\subsubsection{Riferimenti normativi}

\begin{itemize}
\item Regolamento del progetto didattico: \\
\url{https://www.math.unipd.it/~tullio/IS-1/2023/Dispense/PD2.pdf}
\item \emph{Capitolato d’appalto}$^{G}$ C3 - Easy Meal: \\
\url{https://www.math.unipd.it/~tullio/IS-1/2023/Progetto/C3.pdf}
\end{itemize}

\subsubsection{Riferimenti informativi}

\begin{itemize}
\item I processi di ciclo di vita del software: \\ \url{https://www.math.unipd.it/~tullio/IS-1/2023/Dispense/T2.pdf}
\item Glossario: \\ \url{https://github.com/SWEet16-SWE-Group/docs/blob/main/RTB/Documentazione%20Esterna/Glossario.pdf}
\item ISO/IEC 12207: \\ \url{http://www.colonese.it/SviluppoSw_Standard_ISO12207.html}
\end{itemize}

\subsubsection{Riferimenti tecnici}

Tutti i riferimenti (normativi e informativi) a risorse web soggette a variazione sono stati consultati il
<?php echo (new DateTime())->format('Y/m/d'); ?>.

\begin{itemize}
<?php
$riferimenti = [
  'React'       => 'https://www.react.dev',
  'Axios'       => 'https://www.axios-http.com/',
  'Bootstrap'   => 'https://www.getbootstrap.com/',
  'Laravel'     => 'https://www.laravel.com/',
  'MySQL'       => 'https://www.mysql.com/',
  'NodeJS'      => 'https://www.nodejs.org/',
  'Docker'      => 'https://www.docker.com/',
];
echo implode(
  "\n",
  array_map(
    fn ($k, $v) => sprintf('\\item %s: \\\\ \\url{%s}', $k, $v),
    array_keys($riferimenti),
    $riferimenti
  )
);
?>
\end{itemize}

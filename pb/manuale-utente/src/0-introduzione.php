\nonstopmode
\section{Introduzione e scopo del documento}

\subsection{Scopo del documento}

Lo scopo di questo documento è quello di illustrare le istruzioni per l’utilizzo e le funzionalità fornite dall’applicazione. 
Grazie a ciò l’utente sarà a conoscenza dei requisiti minimi necessari per il corretto funzionamento dell’applicazione, di come installarla in locale e di come farne un utilizzo consapevole.

\subsection{Scopo del prodotto}

L'obiettivo del progetto è creare una piattaforma per la gestione delle prenotazioni e delle ordinazioni nei ristoranti, rivolta sia ai clienti che ai ristoratori, con l'obiettivo di ottimizzare il tempo per entrambe le parti. 
La piattaforma consente agli utenti di accedere al proprio account attraverso un sistema di accesso e condivisione, permettendo l'interazione con vari ristoranti nei quali si vuole consumare un pasto i quali, a loro volta, potranno accettare o rifiutare prenotazioni e ordinazioni.
Possiamo quindi distinguere::
\begin{itemize}
    \item Utenti consumatori (definiti come \textbf{Clienti}) che effettuano prenotazioni e ordinazioni;.
    \item Utenti amministratori (definiti come \textbf{Ristoratori}) che, oltre a  gestire prenotazioni e ordinazioni, possono creare, modificare e cancellare le pietanze del proprio ristorante.
\end{itemize}

Per garantire la massima compatibilità, la piattaforma sarà accessibile tramite browser e supporterà tecnologie come React, CSS, Laravel, oltre ad altre tecnologie che verranno definite in seguito.


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

\pagebreak
\section{Architettura}
\subsection{Architettura Front-end}
\subsubsection{Introduzione}

L’architettura del prodotto \textit{Easy Meal} non segue un pattern architetturale specifico, poiché nessuno di essi soddisfa appieno le esigenze di modularità e scalabilità dell’applicazione. 
Invece, si è scelto di utilizzare una combinazione di design pattern tipici della libreria ReactJS, selezionati e adattati secondo le specifiche necessità del progetto. 
Questo approccio permette di garantire la separazione della logica di business tra le varie componenti, semplificando la gestione degli stati dell’applicazione. \\
Ogni design pattern adottato è descritto dettagliatamente nelle sezioni successive. \\

Ogni pagina dell'applicazione utilizza chiamate alle API per recuperare i dati necessari alla sua visualizzazione. 
Inoltre, sfrutta gli hooks forniti da React, come useState e useEffect, per gestire lo stato dell'applicazione e aggiornare dinamicamente la UI. 
Grazie a questo approccio, l'applicazione è in grado di fornire un'esperienza utente fluida e reattiva, adattandosi in tempo reale alle esigenze dell'utente. 
Le singole chiamate alle API permettono di recuperare i dati in modo efficiente, sicuro e scalabile, separando la logica di business dall’interfaccia utente. 
L'uso degli hook consente di gestire lo stato dell’applicazione in modo dichiarativo e modulare, semplificando la leggibilità del codice e la gestione dei dati.

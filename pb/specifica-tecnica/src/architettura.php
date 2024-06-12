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

\subsubsection{Diagrammi delle classi}

DA FARE UNA VOLTA TERMINATA LA CODIFICA

\subsubsection{Design Pattern utilizzati}

In questa sezione, vengono descritti i design pattern utilizzati nell’applicazione basata su React. Sono state adottate diverse soluzioni per modularizzare le singole componenti e adattarle alle specifiche esigenze di realizzazione ed integrazione previste. \\
In particolare, possiamo dettagliare l’utilizzo di:
\begin{itemize}
\item \textbf{React Hook}: utilizzati per gestire lo stato dell’applicazione in modo efficiente e visualizzare dinamicamente le informazioni. 
Vengono impiegati sia gli hook nativi di React (come useState, useEffect e useContext), sia hook personalizzati creati in base alle esigenze delle singole viste e componenti, come precedentemente descritto.
\item \textbf{Conditional Rendering}: permette di mostrare contenuti diversi in base a determinate condizioni. Vengono sviluppati componenti in grado di verificare suddette condizioni e rendere visibili i dati pertinenti in base a queste.
\item \textbf{Compound Components}: consentono di modularizzare le singole componenti attraverso una gerarchia padre-figlio, dove un componente padre contiene uno o più componenti figlio. 
Questo approccio permette di specializzare la gestione dei dati e personalizzare l’interfaccia utente in modo centralizzato, seguendo una lista di opzioni unica.
\end{itemize}

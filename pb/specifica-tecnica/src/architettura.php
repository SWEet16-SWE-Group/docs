\pagebreak
\section{Architettura}

\subsection{Architettura di Deployment}

SWEet16 ha deciso di adottare un'architettura a tre livelli per implementare \textit{Easy Meal}. \\

Questa architettura va a separare la logica di presentazione dalla logica di business e dal database.
Questi tre livelli comunicano tra di loro attraverso interfacce ben definite.

Nel dettaglio sono:
\begin{itemize}
    \item \textbf{Livello di presentazione (frontend):} viene utilizzato React, che riceve i dati dall'utente e mostra le informazioni restituite dal backend;
    \item \textbf{Livello di logica applicativa (backend):} viene utilizzato Laravel, che gestisce la logica di business elaborando le richieste del frontend interagendo con il database
            per recuperare o salvare i dati;
    \item \textbf{Livello di Dati (database):} viene utilizzato MySQL, che si occupa della gestione dei dati.

Questo approccio ha permesso al team di lavorare in modo parallelo sul frontend e sul backend, riducendo i tempi di sviluppo e rendendo più facile l'implementazione dei test.

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

\subsection{Architettura Back-end}

\subsubsection{Introduzione}

Per il backend del progetto, è stato scelto di adottare il framework Laravel.
Laravel è un framework PHP noto per la sua semplicità e robustezza, che ci ha permesso di sviluppare RESTful API in modo rapido ed efficiente.
Questa scelta consente di beneficiare delle potenti funzionalità di Laravel, come l'ORM Eloquent, la gestione delle migrazioni, e una struttura modulare che favorisce la manutenibilità e la scalabilità dell'applicazione. \\
\\
Per il database è stato scelto MySQL, un sistema di gestione di database relazionali molto diffuso e affidabile. 
MySQL si integra perfettamente con Laravel, permettendo di sfruttare al meglio le funzionalità di entrambe le tecnologie. \\

Le singole componenti del sistema sono strutturate come segue:
\begin{itemize}
\item \textbf{Laravel}: Utilizzato per gestire la logica di business, l'autenticazione, la gestione delle rotte e la comunicazione con il database;
\item \textbf{MySQL}: Utilizzato per la persistenza dei dati, MySQL offre una soluzione robusta e scalabile per gestire le informazioni necessarie all'applicazione. Grazie all'ORM Eloquent di Laravel, è possibile interagire con il database in modo intuitivo e efficiente;
\item \textbf{API RESTful}: Sono state implementate delle API RESTful, che consentono una chiara separazione dei dati tra client e server.
Le API RESTful permettono di esporre le risorse dell'applicazione tramite chiamate HTTP, rendendo possibile la comunicazione sincrona tra il frontend e il backend.
\end{itemize}

L'adozione di Laravel per il backend e MySQL per il database, quindi, consente di creare un'applicazione web potente, scalabile e sicura, con una chiara separazione della logica di business e una gestione efficiente dei dati.

\subsubsection{Design Pattern utilizzati}

Nella seguente sezione, vengono descritti i design pattern adottati per il backend.
Seguendo la descrizione fornita inizialmente possiamo descrivere l'utilizzo di:
\begin{itemize}
    \item \textbf{Facade Pattern}: Fornisce un'interfaccia statica a classi che sono disponibili nel contenitore di servizio di Laravel, rendendo l'uso delle classi di servizio più semplice; sono state largamente usate nella comunicazione con il database;
    \item \textbf{Repository Pattern}: Separazione della logica di accesso ai dati dal business logic, creando un livello di astrazione per le operazioni CRUD e altre query di database.
    \item \textbf{Template Method Pattern}: Utilizzato nelle migrazioni del database, dove la classe di base definisce la struttura dell'operazione di migrazione e le sottoclassi implementano i dettagli specifici.
    \item \textbf{Factory Pattern}: Utilizzato per creare oggetti senza dover specificare la classe esatta dell'oggetto che verrà creato. Utilizzato per generare istanze di modelli in fase di testing o seeding del database.
\end{itemize}


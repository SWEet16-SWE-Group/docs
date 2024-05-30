\pagebreak

\section{Tecnologie}

In questa sezione viene fornita una panoramica generale delle tecnologie utilizzate per la
realizzazione del prodotto in questione. \\
Vengono infatti descritte le procedure, gli strumenti e le librerie necessari per lo sviluppo, il test e la distribuzione del prodotto.\\
In particolare, verranno trattate le tecnologie impiegate per la realizzazione del front-end e del back-end, per la gestione del
database e per l'integrazione con i servizi previsti.

\subsection{Tecnologie per la codifica}

\begin{center}
	\begin{longtblr}{
		colspec={|X[c,2cm]|X[c,12cm]|X[c,2cm]|},
		row{odd}={bg=white},
		row{even}={bg=lightgray}
		}
		\hline
		\textbf{Tecnologia}                                                          & \textbf{Descrizione}                                                                                                                              & \textbf{Versione} \\ \hline
		\SetCell[c=3]{c} \textbf{Linguaggi}                                                                                                                                                                                                                      \\ \hline
		HTML                                                                         & Linguaggio di annotazione (markup) utilizzato per impostare la struttura delle
		singole pagine e definire gli elementi dell’interfaccia                      & 5                                                                                                                                                                     \\ \hline
		CSS                                                                          & Linguaggio utilizzato per la formattazione e la gestione dello stile degli elementi HTML                                                          & 3                 \\ \hline
		JavaScript                                                                   & Linguaggio utilizzato per la gestione di eventi invocati dall'utente                                                                              & ECMAScript 2023   \\ \hline
		PHP                                                                          & Linguaggio per la codifica di applicazioni web lato server, utilizzato per la creazione di \emph{API Rest}$^{G}$                                  & 8.x               \\ \hline
		\SetCell[c=3]{c} \textbf{Librerie e framework}                                                                                                                                                                                                           \\ \hline
		ReactJs                                                                      & Libreria grafica per facilitare lo sviluppo front-end gestendo modularmente le componenti grafiche,
		permettendo performance buone grazie all'efficacia della sua renderizzazione & 18.2.x                                                                                                                                                                \\ \hline
		Laravel                                                                      & Framework PHP utilizzato per facilitare la creazione di API Rest                                                                                  & 11                \\ \hline
		Axios                                                                        & Libreria JavaScript che viene utilizzata per effettuare richieste HTTP sia negli ambienti browser che Node.js                                     & 11.x              \\ \hline
		MaterialUI                                                                   & Framework di componenti React preconfezionati per la creazione di interfacce
		utente gradevoli, funzionali e personalizzabili                              & 4.1.x                                                                                                                                                                 \\ \hline
		Shadcn/ui                                                                    & Libreria di componenti React utilizzata per facilitare la codifica del front-end, incorporando nell’interfaccia grafica componenti prefabbricate,
		personalizzabili e altamente riutilizzabili                                  & 0.8.0                                                                                                                                                                 \\ \hline
		\SetCell[c=3]{c} \textbf{Strumenti e servizi}                                                                                                                                                                                                       \\ \hline
		Node.js                                                                      & Runtime system per esecuzione di codice Javascript                                                                                                & 20.11.0           \\ \hline                                                                                                                              
		NPM                                                                          & Gestore di pacchetti per il linguaggio JavaScript e l'ambiente di esecuzione Node.js                                                              & 9.6.x             \\ \hline
		Docker                                                                       & Piattaforma di sviluppo e gestione di applicazioni che permette di creare, distribuire e eseguire in software in container virtualizzati          & 24.0.7            \\ \hline
		Git                                                                          & Sistema di controllo di versione distribuito utilizzato per la gestione del codice sorgente dal parte del gruppo di progetto                      & /                 \\ \hline
	\end{longtblr}
\end{center}

// va aggiunto bootstrap

\subsection{Tecnologie per l'analisi del codice}
\begin{center}
	\begin{longtblr}{
		colspec={|X[c,2cm]|X[c,12cm]|X[c,2cm]|},
		row{odd}={bg=white},
		row{even}={bg=lightgray}
		}
		\hline
		\textbf{Tecnologia}                                                        & \textbf{Descrizione}                                                                                                         & \textbf{Versione} \\ \hline
		Prettier                                                                   & Strumento di formattazione del codice che aiuta a mantenere uno stile di codifica coerente e leggibile                       & 3.0.x             \\ \hline
		Jest                                                                       & Framework di testing basato su JavaScript utilizzato per l'implementazione ed esecuzione dei test di unità e di integrazione & 29.1.x            \\ \hline
		PHPUnit                                                                    & Framework di unit test per il linguaggio di programmazione PHP                                                               & 11.x              \\ \hline
		React Testing Library                                                      & Libreria di test integrata nativamente che consente di testare il
        comportamento dei \emph{componenti}$^{G}$ React da una prospettiva degli utenti finali & 14.0.x                                                                                                                                           \\ \hline
        GitHub Actions                                                             & Servizio di CI/CD per automatizzare il processo di \emph{build}$^{G}$, test e \emph{deploy}$^{G}$ del progetto software                              & /                 \\ \hline                                                                                                                                                 
	\end{longtblr}
\end{center}



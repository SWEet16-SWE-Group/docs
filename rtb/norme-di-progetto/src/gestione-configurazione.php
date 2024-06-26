\nonstopmode
\pagebreak
\pagebreak
\subsection{Gestione della Configurazione}

\subsubsection{Descrizione, scopo ed aspettative}
    Lo scopo è di supervisionare e regolare in modo organizzato la creazione di
    documenti e codice. Ogni elemento del quale dovrà essere gestita configurazione, sarà soggetto a versionamento
    e controllo delle modifiche, al fine di assicurare l'integrità del prodotto
    nel tempo.
    \\
    Tutti gli strumenti dedicati alla configurazione utilizzati per la produzione
    di documenti e codice vengono raccolti, organizzati e coordinati. Questo include
    la gestione della struttura e della disposizione dei file all'interno del repository,
    nonché gli strumenti per il versionamento e il coordinamento.

\subsubsection{Versionamento}
Ogni modifica apportata a un documento genera una nuova versione seguendo il formato
\textbf{v[X].[Y].[Z]}, dove:

\begin{itemize}
\item \textbf{X}: Rappresenta la versione approvata dal \emph{Responsabile}, l'unico autorizzato ad incrementarla;
\item \textbf{Y}: Rappresenta la versione approvata dal \emph{Verificatore}, l'unico autorizzato ad incrementarla;
\item \textbf{Z}: Rappresenta la versione dell'ultima modifica.
\end{itemize}
Ogni parte del codice di versione inizia da 0 e ritorna a 0 ogni volta che la componente alla sua sinistra
viene incrementata.
\subsubsection{Repository}
    \subsubsubsection{Tecnologie e strumenti}
    Per il progetto viene usato \emph{GitHub}$^{G}$, che a sua volta è basato sul sistema di versionamento
    \emph{Git}$^{G}$. Il gruppo fa pieno uso delle funzionalità di \emph{GitHub} tra cui:

\begin{itemize}
\item \textbf{Issue}: Permette di discutere, tracciare e risolvere un problema nel progetto;
\item \textbf{Milestone}: Permette di raggruppare e monitorare contemporaneamente una serie di issues aiutando a tracciare il progresso verso obiettivi del progetto;
\item \textbf{Pull request}: Consente di proporre delle modifiche al codice e di richiederne la revisione da un altro membro.
\end{itemize}
    \subsubsubsection{Struttura Repository}
    Si è deciso di utilizzare un'unica repository contenente il codice sorgente per la documentazione e per il \emph{PoC}$^{G}$.
    La repository è composta da 3 cartelle così divise:

\begin{itemize}
\item \textbf{Template}: Contenente il template per il documento \LaTeX;
\item \textbf{Candidatura}: Contenente i documenti relativi alla candidatura, come l'analisi dei capitolati, la lettera di presentazione, il preventivo dei costi e infine i verbali;
\item \textbf{RTB}: Contenente i documenti relativi alla revisione ed è suddivisa in tre sotto cartelle:
\begin{itemize}
\item \textbf{Documentazione interna}, all'interno della quale sono contenute le norme di progetto;
\item \textbf{Documentazione esterna}, che comprende i documenti tra cui Analisi dei requisiti, Piano di progetto, Piano di qualifica e il Glossario;
\item \textbf{Verbali}, che a loro volta sono suddivisi in interni ed esterni.
\end{itemize}
\end{itemize}
    Ciascun documento segue la convenzione di nomenclatura \emph{Nome\_documento}, ad eccezione dei verbali che vengono
    denominati con la data della loro stesura nel formato \emph{AAAA\_MM\_GG}. \\
    Inoltre la repository è suddivisa in 3 branch principali:

\begin{itemize}
\item \textbf{Main}: Il branch principale che contiene l'ultima versione dei documenti compilati in formato \emph{PDF};
\item \textbf{PoC-main}: Contiene il codice sorgente del \emph{PoC};
\item \textbf{Rtb-documentazione-main}: Il branch dedicato alla creazione/modifica dei documenti relativi alla revisione RTB.
\end{itemize}
    \subsubsubsection{Modifiche alla repository}
    Le modifiche ai vari documenti non vanno fatte direttamente nel branch \emph{rtb-documentazione-main},
    poiché questo porterebbe ad un elevato rischio di incongruenze e conflitti. Per ogni sezione di un documento, vengono
    creati appositi branch dove è possibile apportare modifiche. Successivamente, una volta terminate le modifiche, è necessario
    effettuare una \emph{pull request}$^{G}$ con verifica obbligatoria per integrare le modifiche nel branch. Se la verifica non è
    soddisfatta bisogna apportare le giuste modifiche e richiedere un'altra verifica. Se la verifica è
    soddisfatta le modifiche verranno integrate con il branch \emph{rtb-documentazione-main}, viene quindi effettuato il \emph{merge}. 
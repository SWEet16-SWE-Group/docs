\nonstopmode
\subsection{Sviluppo}

\subsubsection{Descrizione, scopo ed aspettative}

Il processo di sviluppo contiene le attività e i compiti dello sviluppatore, tra cui le attività per l’Analisi dei Requisiti, la progettazione, la codifica ed gli strumenti utilizzati.

Lo scopo del processo di sviluppo è quello di descrivere i compiti e le attività da svolgere per la codifica del prodotto software richiesto. \\
In questa sezione vengono dunque descritte le attività, le norme e le convenzioni adottate per questo processo.

Le aspettative per una corretta applicazione del processo di sviluppo sono:

\begin{itemize}
\item Realizzare un prodotto finale conforme alle richieste del proponente illustrate dall'Analisi dei Requisiti;
\item Determinare i vincoli tecnologici;
\item Determinare gli obiettivi di sviluppo;
\item Determinare i vincoli di \emph{design}$^{G}$.
\end{itemize}
\subsubsection{Analisi dei Requisiti}

L’Analisi dei Requisiti è l’attività preliminare che permette di definire chiaramente, grazie al lavoro di Analisti, i requisiti diretti ed indiretti,
impliciti ed espliciti che il proponente richiede per la realizzazione del prodotto, ed i vari \emph{casi d’uso}$^{G}$ del prodotto stesso. \\
In questa attività è importante suddividere il problema iniziale in \emph{requisiti}$^{G}$ quanto più elementari possibile, andando a facilitare il lavoro durante la fase di sviluppo.

Al fine di poter fornire una corretta interpretazione e realizzazione del prodotto, l'attività ha lo scopo di comprendere le specificità del \emph{capitolato}$^{G}$, sulla base di un confronto mirato con il proponente, interpretando e ampliando la relativa realizzazione.
\pagebreak

    \subsubsubsection{Denominazione e Legenda}

    \subsubsubsubsection{Struttura Casi d'Uso}

    I casi d’uso esprimono un comportamento o un modo di utilizzare il prodotto per raggiungere un determinato obiettivo. \\
    Vengono descritti graficamente mediante l’ausilio di diagrammi \emph{UML}$^{G}$.

    Ciascun caso d’uso è costituito da:

\begin{itemize}
\item Codice identificativo;
\item Attore Primario;
\item Precondizioni;
\item Postcondizioni;
\item Scenario principale;
\item Generalizzazioni (se esistono);
\item Specializzazioni (se esistono);
\item Estensioni (se esistono).
\end{itemize}

    \subsubsubsubsection{Denominazione Casi d'Uso}

    Ciascun caso d’uso viene classificato univocamente mediante l’utilizzo del seguente schema:

        \begin{center}
            \large{\textbf{UC[Numero].[Sottocaso]-[Titolo]}}
        \end{center}
    Dove:

\begin{itemize}
\item UC: Acronimo di "Use Case";
\item Numero: Numero associato al caso d'uso principale;
\item Sottocaso d'uso: Numero associato al sottocaso d'uso (opzionale);
\item Titolo: Titolo assegnato al caso d'uso.
\end{itemize}

    \subsubsubsubsection{Struttura dei Requisiti}

    I requisiti individuati nell’Analisi dei Requisiti sono stati strutturati nel modo seguente:

\begin{itemize}
\item Codice;
\item Descrizione;
\item Classificazione in:
\begin{itemize}
\item Requisito obbligatorio;
\item Requisito facoltativo;
\item Requisito desiderabile.
\end{itemize}
\item Fonte: L'origine del requisito.
\end{itemize}

    \subsubsubsubsection{Denominazione dei Requisiti}

    Ogni requisito è identificato univocamente secondo il seguente schema:
        \begin{center}
            \large{\textbf{R[Tipo].[Codice].[SottoCodice]}}
        \end{center}
    Dove:

\begin{itemize}
\item Tipo: Indica la tipologia del Requisito e può essere:
\begin{itemize}
\item F: Requisito funzionale;
\item Q: Requisito di qualità;
\item S: Requisito di sistema;
\item P: Requisito prestazionale e di sicurezza.
\end{itemize}
\item Codice: Numero identificativo univoco ed incrementale in base alla tipologia di requisito;
\item SottoCodice: Numero associato al sottorequisito (opzionale).
\end{itemize}


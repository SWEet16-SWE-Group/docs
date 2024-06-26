\nonstopmode

\section{Qualità di prodotto}
\subsection{Scopo}
Facendo riferimento allo standard ISO/IEC 9126:2001, vengono di seguito riportate le caratteristiche che il prodotto deve avere per essere considerato di qualità. \\
Vengono inoltre riportate le relative metriche atte a definire un metodo di valutazione del prodotto finale.\\
Le metriche hanno un identificativo avente come prefisso l'acronimo QPR (Qualità Prodotto) seguito dal codice della singola metrica.\\

\subsection{Usabilità}

\begin{itemize}
\item \textbf{QPR-TA - Tempo Apprendimento}: Tempo necessario all'utente per apprendere l'utilizzo del prodotto;
\item \textbf{QPR-NP - Numero Passi}: Numero di passi necessari per raggiungere lo scopo voluto;
\item \textbf{QPR-TE - Tempo Esplorazione}: Tempo speso nell'esplorazione del prodotto;
\item \textbf{QPR-NE - Numero Errori}: Numero di errori commessi dall'utente prima di raggiungere lo scopo voluto.
\end{itemize}
\subsubsection{Obiettivi}
\begin{table}[H]
    \begin{tblr}{
        colspec={|X[3cm]|X[4cm]|X[4cm]|X[4cm]|},
        row{odd}={bg=white},
        row{even}={bg=lightgray},
        row{1}={bg=black, fg=white}
}
        Metrica & Descrizione & Valore accettabile & Valore ideale \\
        QPR-TA & Tempo Apprendimento & 10 minuti & 5 minuti \\
        QPR-NP & Numero Passi & 20 click & 10 click \\
        QPR-TE & Tempo Esplorazione & 5 minuti & 3 minuti \\
        QPR-NE & Numero Errori & 5 & 0 \\
        \hline
     \end{tblr}
    \caption{Metriche usabilità}
    \label{tab:1}
\end{table}

\subsection{Manutenibilità}

\begin{itemize}
\item \textbf{QPR-CC - Complessità Ciclomatica}: Valutazione della complessità di un algoritmo calcolata utilizzando il grafo di controllo del flusso tramite la formula $$v(G) = L - N + P$$
\begin{itemize}
\item \textbf{V(G)}: Numero ciclomatico relativo al grafo G;
\item \textbf{L}: Numero di archi nel grafo;
\item \textbf{N}: Numero di nodi del grafo;
\item \textbf{P}: Numero dei componenti del grafo disconnessi.
\end{itemize}
\item \textbf{QPR-NPM - Numero parametri per metodo}: Numero di parametri passati ai metodi. Un valore troppo grande può indicare un metodo troppo complesso;
\item \textbf{QPR-FCC - Facilità di comprensione del codice}: Un codice comprensibile permette una manutenibilità e gestione migliore. Viene misurata con la seguente formula $$R = \frac{NR_{com}}{NR_{tot}}$$ che indica il rapporto tra le righe di commenti (${NR_{com}}$) e le righe di codice (${NR_{tot}}$).
\end{itemize}

\begin{table}[H]
    \begin{tblr}{
        colspec={|X[2cm]|X[6cm]|X[3cm]|X[3cm]|},
        row{odd}={bg=white},
        row{even}={bg=lightgray},
        row{1}={bg=black, fg=white}
}
        Metrica & Descrizione & Valore accettabile & Valore ideale \\
        QPR-CC & Complessità Ciclomatica & $\leq 25$ & $\leq 10$ \\
        QPR-NPM & Numero parametri per metodo & $\leq 8$ & $\leq 4$ \\
        QPR-FCC & Facilità di comprensione del codice & $\geq 0.10$ & $\geq 0.20$ \\
        \hline
     \end{tblr}
    \caption{Metriche Manutenibilità}
    \label{tab:2}
\end{table}

\subsection{Affidabilità}

\begin{itemize}
\item \textbf{QPR-AFD - Failure Density}: Indica l'affidabilità del software. Si ricava dal rapporto tra i test falliti e quelli eseguiti. $$FD = \frac{T_{f}}{T_{t}} \cdot 100$$
\begin{itemize}
\item ${T_{f}}$: Test falliti;
\item ${T_{t}}$: Test totali.
\end{itemize}
\item \textbf{QPR-ACC - Code Coverage}: Indica la percentuale di codice eseguito durante i test.
\end{itemize}

\begin{table}[H]
    \begin{tblr}{
        colspec={|X[2cm]|X[6cm]|X[3cm]|X[3cm]|},
        row{odd}={bg=white},
        row{even}={bg=lightgray},
        row{1}={bg=black, fg=white}
}
        Metrica & Descrizione & Valore accettabile & Valore ideale \\
        QPR-AFD & Failure Density & 90\% & 100\% \\
        QPR-ACC & Code Coverage & 80\% & 100\% \\
        \hline
     \end{tblr}
    \caption{Metriche Affidabilità}
    \label{tab:3}
\end{table}

\pagebreak
\subsection{Efficienza}

\begin{itemize}
\item \textbf{QPR-TMR - Tempo di Risposta Medio}: Il tempo impiegato dal software dalla gestione ed elaborazione di una richiesta fino al risultato finale fornito.
\end{itemize}

\begin{table}[H]
    \begin{tblr}{
        colspec={|X[3cm]|X[5cm]|X[4cm]|X[4cm]|},
        row{odd}={bg=white},
        row{even}={bg=lightgray},
        row{1}={bg=black, fg=white}
}
        Metrica & Descrizione & Valore accettabile & Valore ideale \\
        QPR-TMR & Tempo di Risposta Medio & 3 secondi & 2 secondi \\
        \hline
     \end{tblr}
    \caption{Metriche efficienza}
    \label{tab:8}
\end{table}

\subsection{Funzionalità}

\textbf{QPR-RC}: Requirements Coverage, indica la percentuale dei requisiti soddisfatti. Per il calcolo del valore accettato si considerano solo i requisiti obbligatori.\\
Formula valore accettato:
$$RC_{obb} = \frac{NR_{os}}{NR_{ot}} \cdot 100$$

\begin{itemize}
\item $RC_{obb}$: Requirements Coverage obbligatori;
\item $NR_{os}$: Numero di requisiti obbligatori soddisfatti;
\item $NR_{ot}$: Numero di requisiti obbligatori totali.
\end{itemize}

Formula valore ideale:
$$RC_{i} = \frac{NR_{s}}{NR_{t}} \cdot 100$$

\begin{itemize}
\item $RC_{i}$: Requirements Coverage ideali;
\item $NR_{s}$: Numero di requisiti ideali soddisfatti;
\item $NR_{t}$: Numero di requisiti ideali totali.
\end{itemize}

\begin{table}[H]
    \begin{tblr}{
        colspec={|X[3cm]|X[4cm]|X[4cm]|X[4cm]|},
        row{odd}={bg=white},
        row{even}={bg=lightgray},
        row{1}={bg=black, fg=white}
}
        Metrica & Descrizione & Valore accettabile & Valore ideale \\
        QPR-RC & Requirements Coverage & 100\% $RC_{obb}$ & 100\% $RC_{i}$ \\
        \hline
     \end{tblr}
    \caption{Metriche Funzionalità}
    \label{tab:4}
\end{table}

\subsection{Compatibilità}

\textbf{QPR-CB}: Compatibilità Browser, indica la percentuale di browser supportati in relazione a quelli previsti.\\
Formula valore accettato:
$$CB = \frac{BW_{s}}{BW_{p}} \cdot 100$$

\begin{itemize}
\item $CB$: Compatibilità browser;
\item $BW_{s}$: Browser supportati;
\item $BW_{p}$: Browser previsti.
\end{itemize}

\begin{table}[H]
    \begin{tblr}{
        colspec={|X[3cm]|X[4cm]|X[4cm]|X[4cm]|},
        row{odd}={bg=white},
        row{even}={bg=lightgray},
        row{1}={bg=black, fg=white}
}
        Metrica & Descrizione & Valore accettabile & Valore ideale \\
        QPR-CB & Compatibilità Browser & 100\% & 100\% \\
        \hline
     \end{tblr}
    \caption{Metriche Compatibilità}
    \label{tab:5}
\end{table}

\nonstopmode
\section{Qualità di processo}
\subsection{Scopo}
La qualità di un prodotto è influenzata dalla qualità dei processi che lo compongono. \\
È quindi necessario dotarsi di metriche che permettano di valutare tali processi e garantire che essi
raggiungano gli obiettivi di qualità fissati.\\
Per garantire una corretta implementazione ed un mantenimento costante, si seguirà
il \textit{ciclo di Deming}, meglio conosciuto come PDCA, che prevede un approccio iterativo funzionale
all'attuazione di un miglioramento continuo.\\
In questa sezione si espongono le metriche scelte ed i livelli di qualità accettabili e ottimali per ciascuna
di esse.\\
Le metriche hanno un identificativo avente come prefisso l'acronimo QPC (Qualità Processo) seguito dal codice della singola metrica.\\

\subsection{Processi primari}

\subsubsection{Fornitura}

\begin{itemize}
\item \textbf{Budget at Completion (QPC-BAC)}: Totale preventivato del progetto.
\end{itemize}

\begin{itemize}
\item \textbf{QPC-AC - Actual Cost}: Costo sostenuto per il progetto al momento del calcolo;
\item \textbf{QPC-ETC - Estimated to Completion}: Stima del valore per la realizzazione delle rimanenti attività;
\item \textbf{QPC-EAC - Estimated at Completion}: Costo finale stimato alla data della misurazione, revisione del \textbf{QPC-BAC}; $$Formula: \textrm{QPC-AC} + \textrm{QPC-ETC}$$
\item \textbf{QPC-EV - Earned Value}: Importo guadagnato per il lavoro svolto al momento del calcolo; $$Formula: (\%Lavoro \enspace svolto) \cdot QPC-EAC$$
\item \textbf{QPC-PV - Planned Value}: Importo pianificato in base al lavoro svolto, al momento del calcolo; $$Formula: (\%Lavoro \enspace pianificato) \cdot \textrm{QPC-BAC}$$
\item \textbf{QPC-SV - Schedule Variance}: Stato (anticipo/ritardo) della pianificazione. Un valore negativo indica che si è in ritardo rispetto alla pianificazione; $$Formula \enspace base: \textrm{QPC-EV} - \textrm{QPC-PV}$$ $$Formula \enspace in \enspace \%: \textrm{QPC-EV} / \textrm{QPC-PV} \cdot 100$$
\item \textbf{QPC-CV - Cost Variance}: Differenza tra il budget a disposizione e quello effettivamente utilizzato. Un valore negativo indica che si sta lavorando in perdita. $$Formula: \textrm{QPC-EV} - \textrm{QPC-AC}$$ $$Formula \enspace in \enspace \%: \textrm{QPC-EV} / \textrm{QPC-AC} \cdot 100$$
\end{itemize}

\begin{table}[H]
    \begin{tblr}{
        colspec={|X[3cm]|X[5cm]|X[4cm]|X[3cm]|},
        row{odd}={bg=white},
        row{even}={bg=lightgray},
        row{1}={bg=black, fg=white}
}
        Metrica & Descrizione & Valore accettabile & Valore ideale \\
        QPC-AC & Actual Cost & & \\
        QPC-ETC & Estimated to Completion & ${\geq}$ 0\% & ${\leq}$ QPC-EAC\\
        QPC-EAC & Estimated at Completion & Errore del ${\pm}$ 3\% rispetto a QPC-BAC & = QPC-BAC\\
        QPC-EV & Earned Value & ${\geq}$ 0 & ${\leq}$ QPC-EAC \\
        QPC-PV & Planned Value & ${\geq}$ 0 & ${\leq}$ QPC-BAC \\
        QPC-SV & Schedule Variance & ${\geq}$ -10\% & ${\geq}$ 0 \\
        QPC-CV & Cost Variance & ${\geq}$ -5\% & ${\geq}$ 0 \\
        \hline
     \end{tblr}
    \caption{Metriche e obiettivi fornitura}
    \label{tab:20}
\end{table}

\subsubsection{Sviluppo}
\subsubsubsection{Progettazione architetturale}

\begin{itemize}
\item \textbf{QPC-SFIN - Structural Fan-in}: Indice di utilità, indica quante componenti utilizzano un determinato modulo. Un valore alto indica che il componente è molto usato;
\item \textbf{QPC-SFOUT - Structural Fan-out}: Indice di dipendenza, indica quante componenti sono utilizzate dalla componente in esame. Un valore elevato indica che quest'ultima utilizza molte componenti esterne ad essa.
\end{itemize}

\begin{table}[H]
    \begin{tblr}{
        colspec={|X[3cm]|X[5cm]|X[4cm]|X[3cm]|},
        row{odd}={bg=white},
        row{even}={bg=lightgray},
        row{1}={bg=black, fg=white}
}
        Metrica & Descrizione & Valore accettabile & Valore ideale \\
        QPC-SFIN & Structural Fan-in & - & - \\
        QPC-SFOUT & Structural Fan-out & - & - \\
        \hline
     \end{tblr}
    \caption{Metriche e obiettivi progettazione architetturale}
    \label{tab:21}
\end{table}

\pagebreak
\subsubsubsection{Progettazione di dettaglio}

\begin{itemize}
\item \textbf{QPC-NM - Number of Methods}: Indica il numero medio di metodi per package. Un numero eccessivo potrebbe indicare la necessità di refactoring.
\end{itemize}

\begin{table}[H]
    \begin{tblr}{
        colspec={|X[3cm]|X[5cm]|X[4cm]|X[3cm]|},
        row{odd}={bg=white},
        row{even}={bg=lightgray},
        row{1}={bg=black, fg=white}
}
        Metrica & Descrizione & Valore accettabile & Valore ideale \\
        QPC-NM & Number of Methods & 3-11 & 3-8 \\
        \hline
     \end{tblr}
    \caption{Metriche e obiettivi progettazione di dettaglio}
    \label{tab:22}
\end{table}

\subsubsubsection{Codifica}

\begin{itemize}
\item \textbf{QPC-BLC - Bugs for Line of Code}: Indice del numero di righe di codice contenenti bug ed errori al proprio interno;
\item \textbf{QPC-VNU - Variabili Non Utilizzate}: Indice di un errore di programmazione, le variabile non utilizzate sporcano il codice e fanno allocare memoria inutilmente;
\item \textbf{QPC-VND - Variabili Non Definite}: Fonte comune di bug nel software, sono variabili dichiarate ma non inizializzate ad un valore noto definito prima di essere utilizzate.
\end{itemize}

\begin{table}[H]
    \begin{tblr}{
        colspec={|X[3cm]|X[5cm]|X[4cm]|X[3cm]|},
        row{odd}={bg=white},
        row{even}={bg=lightgray},
        row{1}={bg=black, fg=white}
}
        Metrica & Descrizione & Valore accettabile & Valore ideale \\
        QPC-BLC & Bugs for Line of Code & 0-70 & 0-25 \\
        QPC-VNU & Variabili Non Utilizzate & 0 & 0 \\
        QPC-VND & Variabili Non Definite & 0 & 0 \\
        \hline
     \end{tblr}
    \caption{Metriche e obiettivi codifica}
    \label{tab:23}
\end{table}

\subsection{Processi di supporto}

\subsubsection{Documentazione}

\textbf{QPR-DOC}: Indice di Gulpease \\
L'Indice di Gulpease è un indice di leggibilità di un testo tarato sulla lingua italiana.
Si basa sulla seguente formula:
$$GULPEASE = 89+\frac{(NF \cdot 300) - (10 \cdot NL)}{NP}$$

\begin{itemize}
\item \textbf{NF}: Numero frasi;
\item \textbf{NL}: Numero lettere;
\item \textbf{NP}: Numero parole.
\end{itemize}

In generale risulta la seguente suddivisione:

\begin{itemize}
\item GULPEASE ${\le}$ 80: Difficile da leggere per chi ha un licenza elementare;
\item GULPEASE ${\le}$ 60: Difficile da leggere per chi ha un licenza media;
\item GULPEASE ${\le}$ 40: Difficile da leggere per chi ha un diploma superiore.
\end{itemize}

\begin{table}[H]
    \begin{tblr}{
        colspec={|X[3cm]|X[4cm]|X[4cm]|X[4cm]|},
        row{odd}={bg=white},
        row{even}={bg=lightgray},
        row{1}={bg=black, fg=white}
}
        Metrica & Descrizione & Valore accettabile & Valore ideale \\
        QPR-DOC & Indice di Gulpease & GULPEASE ${\geq}$ 40 & GULPEASE ${\geq}$ 60 \\
        \hline
     \end{tblr}
    \caption{Metriche Documentazione}
    \label{tab:24}
\end{table}

\subsubsection{Gestione delle qualità}
\subsubsubsection{Metriche}

\begin{itemize}
\item \textbf{QPC-QMS: Quality Metrics Satisfied}: Percentuale di metriche di qualità soddisfatte. $$\textrm{QPC-QMS} = \frac{NQMS}{TQM} \cdot 100$$
\end{itemize}

\begin{table}[H]
    \begin{tblr}{
        colspec={|X[3cm]|X[5cm]|X[4cm]|X[3cm]|},
        row{odd}={bg=white},
        row{even}={bg=lightgray},
        row{1}={bg=black, fg=white}
}
        Metrica & Descrizione & Valore accettabile & Valore ideale \\
        QPC-QMS & Quality Metrics Satisfied & ${\geq}$ 90\% & 100\% \\
        \hline
     \end{tblr}
    \caption{Metriche e obiettivi gestione della qualità}
    \label{tab:25}
\end{table}

\subsubsection{Verifica}

\begin{itemize}
\item \textbf{QPC-CC - Code Coverage}: Definisce la misura della quantità di codice di un programma che viene eseguita durante uno specifico test. \\ Una percentuale alta indica che il codice è stato testato in modo approfondito nelle sue diverse parti e quindi vi è una minore probabilità che ci siano bug;
\item \textbf{QPC-SC - Statement Coverage}: Metrica utilizzata per calcolare il numero di istruzioni eseguite almeno una volta.\\ Utilizza una tecnica di test chiamata white box che prevede l'esecuzione di tutte le istruzioni presenti nel codice sorgente almeno una volta;
\item \textbf{QPC-BC - Branch Coverage}: Indice di quante diramazioni del codice vengono eseguite dai test. \\ Un "ramo" è uno dei possibili percorsi di esecuzione che il codice può seguire dopo che un'istruzione decisionale (es. if) viene valutata.
\end{itemize}

\begin{table}[H]
    \begin{tblr}{
        colspec={|X[3cm]|X[5cm]|X[4cm]|X[3cm]|},
        row{odd}={bg=white},
        row{even}={bg=lightgray},
        row{1}={bg=black, fg=white}
}
        Metrica & Descrizione & Valore accettabile & Valore ideale \\
        QPC-CC & Code Coverage & ${\geq}$ 80\% & 90\% \\
        QPC-SC & Statement Coverage & ${\geq}$ 70\% & 85\% \\
        QPC-BC & Branch Coverage & ${\geq}$ 50\% & 75\% \\
        \hline
     \end{tblr}
    \caption{Metriche e obiettivi verifica}
    \label{tab:26}
\end{table}

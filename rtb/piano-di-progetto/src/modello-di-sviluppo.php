\nonstopmode

\pagebreak
\section{Modello di sviluppo}
Data la limitata esperienza generale del gruppo riguardo al dominio del progetto
e alle tecnologie impiegate, si è scelto di adottare il modello di sviluppo \textbf{incrementale}. \\
Questa decisione consentirà di migliorare progressivamente il prodotto sviluppato in parallelo
all'acquisizione di conoscenze da parte del gruppo.
\subsection{Modello incrementale}
Il modello incrementale implica un progresso attraverso piccoli passi successivi, con rilasci
multipli che corrispondono ciascuno ad un aumento delle funzionalità. Questo approccio richiede una
classificazione preliminare dei requisiti per identificare quelli prioritari, i quali saranno sviluppati
nei primi incrementi. L'obiettivo è ottenere fin da subito una versione del prodotto il più completa e funzionante
possibile, che verrà poi integrata e migliorata progressivamente. I vantaggi di questo modello includono:

\begin{itemize}
\item Priorità nello sviluppo delle funzionalità principali, che saranno soggette a verifiche ripetute;
\item Disponibilità di un prodotto funzionante già dai primi incrementi, consentendo al cliente di valutarne immediatamente le funzionalità principali;
\item Adattabilità ai cambiamenti;
\item Possibilità di raffinare i requisiti nel tempo, basandosi sull'esperienza e sulla stabilità degli stessi;
\item Riduzione del rischio di fallimento;
\item Semplificazione delle fasi di verifica e test, in quanto mirate a un singolo incremento alla volta;
\item Possibilità di apportare modifiche ed effettuare correzioni degli errori in modo economico.
\end{itemize}
\subsection{Incrementi individuati}
Di seguito sono elencati gli incrementi identificati insieme ai rispettivi obiettivi e requisiti associati.
Questi incrementi si riferiscono al periodo precedente alla prima revisione (\emph{Requirements and Technology Baseline}) e
la tabella verrà quindi ampliata secondo il modello incrementale.

\begin{tblr}{
    colspec={|X[1,c]|X[3,c]|X[2,c]|},
    row{odd}={bg=white},
    row{even}={bg=lightgray},
    row{1}={bg=black, fg=white}
}
    \hline
    \textbf{Incremento} & \textbf{Obiettivo} & \textbf{Fonti} \\
    \hline
    01 & Creazione della prima UI della webapp & Capitolato \\
    02 & Implementazione login con backend & UC2 \\
    03 & Implementazione funzionalità prenotazione & UC18 \\
    04 & Implementazione ordinazione & UC25 \\
    \hline
    \end{tblr}


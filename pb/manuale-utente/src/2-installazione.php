\pagebreak

\section{Installazione}

L'utilizzo dell'applicazione considera i seguenti passi, definiti entrambi come obbligatori e meglio dettagliati nelle successive sottosezioni. Tali passi avvengono in sequenza, come poi spiegato:
\begin{enumerate}
    \item Clonazione della repository
    \item Avvio dell'applicazione
\end{enumerate}

\subsection{Clonazione della repository}

\begin{enumerate}
    \item Scaricare il codice direttamente in formato .zip dal seguente link:
    \begin{itemize}
        \item \url{https://github.com/SWEet16-SWE-Group/docs/archive/refs/heads/mvp-main.zip}
    \end{itemize}
\end{enumerate}
Alternativamente, è possibile:
\begin{enumerate}
    \item Avviare un terminale
    \item Spostarsi nella cartella dove si vuole clonare la repository con il comando:
    \begin{itemize}
        \item \texttt{cd path}
    \end{itemize}
    \item Utilizzando Git, che deve essere installato in locale, clonare la repository utilizzando il comando:
    \begin{itemize}
        \item \texttt{git clone https://github.com/SWEet16-SWE-Group/docs.git}
    \end{itemize}
    \item Spostarsi nella cartella clonata:
    \begin{itemize}
        \item \texttt{cd path/docs}
    \end{itemize}
\end{enumerate}

\subsection{Avvio dell’applicazione}

\begin{enumerate}
    \item Aprire un terminale e posizionarsi nella cartella del progetto, quindi chiamare il comando: \begin{verbatim} docker-compose up --build \end{verbatim}%
    \item Aprire ora un altro terminale e chiamare: \begin{verbatim} docker-compose exec php sh \end{verbatim}%
    \item Installare composer: \begin{verbatim} composer install \end{verbatim}%
    \item Generare la chiave dell'applicazione: \begin{verbatim} php artisan key:generate \end{verbatim}%
    \item Eseguire le migrazioni del database: \begin{verbatim} php artisan migrate \end{verbatim}%
    \item Installare npm: \begin{verbatim} npm install \end{verbatim}%
    \item Controllare se la pagina di Laravel (\url{http://localhost:8000}) non dia errori. Se così non fosse, chiamare sempre da dentro il container Docker: \begin{verbatim} chmod -R 777 storage \end{verbatim}%
   \item L’applicazione disponibile sul browser all’indirizzo: \begin{verbatim} http://localhost:3000 \end{verbatim}%
\end{enumerate}

\subsection{Testing}

Per eseguire i test e ottenere le rispettive code coverage per frontend e backend, i comandi sono i seguenti:
\begin{itemize}
\item \begin{verbatim} npm test -- --coverage \end{verbatim}%
\item \begin{verbatim} XDEBUG_MODE=coverage php artisan test --coverage-html coverage/ \end{verbatim}%
\end{itemize}

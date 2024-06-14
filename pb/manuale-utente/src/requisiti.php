\pagebreak

\section{Requisiti}

In questa sezione sono elencati i requisiti minimi necessari all’esecuzione dell’applicazione, elencando le caratteristiche necessarie atte alla configurazione dell’ambiente di sviluppo del progetto. 

\subsection{Requisiti di sistema}

Per far sì che le operazioni di installazione e avvio del prodotto avvengano correttamente e avere un’esperienza soddisfacente e completa nell’uso dell’applicazione, è necessario installare i seguenti software.

\begin{center}
\begin{longtblr}{
colspec={|X[m,3cm]|X[m,1.5cm]|X[m,11cm]|},
row{odd}={bg=white},
row{even}={bg=lightgray}
}
\hline
\textbf{Componente} & \textbf{Versione} & \textbf{Riferimenti per il download} \\ \hline
Node.js & \(\ge18.x.x\) & \url{https://nodejs.org/en/} \\ 
Npm & \(\ge9.0.x\) & Integrato con il download di Node.js \\ 
Composer & \(\ge1.0\) & \url{https://getcomposer.org/} \\ 
Docker & \(\ge4.28\) & \url{https://www.docker.com/} \\ 
\end{longtblr}
\end{center}

\subsection{Requisiti hardware}

L’applicazione esegue su browser, come tale non si individuano dei requisiti specifici, fissati da parte del proponente, del capitolato o dal progetto stesso. I seguenti, pertanto, sono individuati come riferimento di massima per l’esecuzione del prodotto creato.

\begin{center}
\begin{longtblr}{
colspec={|X[m,4.5cm]|X[m,11cm]|},
row{odd}={bg=white},
row{even}={bg=lightgray}
}
\hline
\textbf{Componente} & \textbf{Requisito} \\ \hline
Processore & Quad-Core 3,2 GHz \\ 
Memoria & 8GB DDR4 \\ 
Scheda grafica & Supporto a scheda grafica integrata con supporto OpenGL \\ 
Connessione Internet & Connessione Internet stabile e veloce, in grado di supportare le esigenze di traffico dell'applicazione \\ 
\end{longtblr}
\end{center}

\subsection{Requisiti software}

L’applicazione è stata testata sui browser principali, di cui si riportano le versioni iniziali, dalle quali si è cominciato a sviluppare il progetto, considerando incrementalmente le versioni più recenti dei singoli browser.

\begin{center}
\begin{longtblr}{
colspec={|X[m,4.5cm]|X[m,11cm]|},
row{odd}={bg=white},
row{even}={bg=lightgray}
}
\hline
\textbf{Browser} & \textbf{Versione} \\ \hline
Google Chrome & 110.0 \\ 
Microsoft Edge & 94.0 \\ 
Mozilla Firefox & 115.0 \\ 
Safari & 17.0 \\ 
\end{longtblr}
\end{center}

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
    \item Aprire un terminale e posizionarsi nella cartella del progetto, quindi chiamare il comando:
    \begin{verbatim}
    docker-compose up --build
    \end{verbatim}
    \item Aprire ora un altro terminale e chiamare:
    \begin{verbatim}
    docker-compose exec php sh
    \end{verbatim}
    \item Installare composer:
    \begin{verbatim}
    composer install
    \end{verbatim}
    \item Generare la chiave dell'applicazione:
    \begin{verbatim}
    php artisan key:generate
    \end{verbatim}
    \item Eseguire le migrazioni del database:
    \begin{verbatim}
    php artisan migrate
    \end{verbatim}
    \item Installare npm:
    \begin{verbatim}
    composer install
    \end{verbatim}
    \item Controllare se la pagina di Laravel (\url{http://localhost:8000}) non dia errori. Se così non fosse, chiamare sempre da dentro il container Docker:
    \begin{verbatim}
    chmod -R 777 storage
    \end{verbatim}
\end{enumerate}
    Per collegarsi a React e avviare l'applicazione tramite il comando:
    \begin{verbatim}
    npm start
    \end{verbatim}
     L’applicazione verrà eseguita automaticamente sul browser predefinito all’indirizzo:
    \begin{verbatim}
        http://localhost:3000
    \end{verbatim}

\section{Istruzioni all'uso}

// DA FARE TERMINATA LA CODIFICA



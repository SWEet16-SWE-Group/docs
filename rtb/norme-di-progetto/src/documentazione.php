\nonstopmode
\subsection{Documentazione}

\subsubsection{Scopo}
Lo scopo di questo documento è fornire uno standard da seguire durante il processo di documentazione.

\subsubsection{Ciclo di vita del documento}
Tappe fondamentali del ciclo di vita di ogni documento sono:

\begin{itemize}
\item \textbf{Creazione}: Creazione del documento partendo da un template;
\item \textbf{Strutturazione}: Creazione di file distinti rappresentanti le singole sezioni dell'indice dei contenuti;
\item \textbf{Stesura}: Fase di scrittura dei contenuti nei documenti. Può essere fatta da uno o più redattori, lavorando asincronicamente su diverse sezioni;
\item \textbf{Verifica}: Una volta che una sezione viene completata entra in fase di verifica, dove uno o più verificatori confermeranno le modifiche o rilasceranno dei commenti di correzione, in questo secondo caso il documento torna nella fase di stesura;
\item \textbf{Approvazione}: Rilascio del documento.
\end{itemize}
  Le prime due fasi sono svolte da tutti i membri del gruppo mentre la terza è affidata esclusivamente al responsabile.

\subsubsection{Template}
È stato deciso di utilizzare un template \emph{\LaTeX}$^{G}$ come base di partenza per la stesura di ogni documento.

\subsubsection{Documenti prodotti}
I documenti prodotti si possono suddividere in due macrosezioni.

    \subsubsubsection{Esterni}
    Di interesse principale per il proponente e i committenti.

\begin{itemize}
\item Analisi dei requisiti;
\item Piano di progetto;
\item Piano di qualifica;
\item Verbali esterni.
\end{itemize}

    \subsubsubsection{Interni}
    Di interesse principale solo per membri del gruppo.

\begin{itemize}
\item Norme di progetto;
\item Verbali interni.
\end{itemize}

\subsubsection{Struttura del documento}

        \subsubsubsection{Prima pagina}
        La prima pagina di ogni documento dovrà contenere:

\begin{itemize}
\item Logo di Unipd accompagnato dal nome dell'università, corso di laurea, materia e anno accademico;
\item Logo del gruppo SWEet16 accompagnato dal nome del gruppo e la rispettiva email;
\item Titolo del documento;
\item Informazioni aggiuntive:
\begin{itemize}
\item \textbf{Redattori}: Indica chi si è occupato di redigere il documento;
\item \textbf{Verificatori}: Indica chi sono stati i verificatori in quel documento;
\item \textbf{Destinatari}: Indica a chi è destinato il documento;
\item \textbf{Versione}: Indica l'attuale versione del documento.
\end{itemize}
\end{itemize}

        \subsubsubsection{Registro delle modifiche - Changelog}

        Il file \texttt{registro-modifiche.tex} contiene il registro delle modifiche, presente in ogni singolo documento, ad eccezione dei verbali. \\
        Esso corrisponde ad una tabella nella quale si tiene traccia di ogni attività svolta sulla documentazione.
        In particolare la tabella è composta dalle seguenti voci:

\begin{itemize}
\item \textbf{Versione}: L'attuale versione del documento;
\item \textbf{Data}: La data in cui avviene un'attività;
\item \textbf{Autore}: Nome della persona che ha apportato i cambiamenti al documento;
\item \textbf{Verificatore}: Nome della persona che ha verificato i cambiamenti apportati al documento;
\item \textbf{Descrizione}: Breve descrizione della modifica effettuata.
\end{itemize}

        \subsubsubsection{Indice}
        Ogni documento presenta un indice di navigazione allo scopo di facilitare quest'ultima e
        dare un'anteprima di ciò che esso contiene.

        %\subsubsubsection{Piè di Pagina} si può pensare di aggiungere un piè di pagina ai documenti

        \subsubsubsection{Verbali}
        I verbali sono documenti informali non troppo diversi dagli altri documenti, con l'unica differenza
        di non essere soggetti a versionamento.
        La prima pagina è la stessa fornita da template.
        Il resto della struttura è divisa in due:

\begin{itemize}
\item Partecipanti: Coloro che hanno effettivamente partecipato all'incontro;
\item Orario di inizio e fine;
\item Sintesi ed elaborazione dell'incontro.
\end{itemize}

\subsubsection{Norme tipografiche}

    \subsubsubsection{Nome del file}
    Di seguito viene descritta la convenzione per la rappresentazione dei nomi dei file, validi per tutti i documenti:

\begin{itemize}
\item Il nome di ogni file inizia con la lettera maiuscola;
\item Se il nome comprende più parole queste iniziano per lettera minuscola e sono separate da '\_';
\item Segue poi il numero di versione composto da una 'v' e tre numeri separati da un '.';
\item Un esempio corretto è \texttt{Norme\_di\_progetto\_v0.1.0}.
\end{itemize}

    Per i verbali il nome del documento sarà semplicemente la data in cui si è tenuto l'incontro nel formato \texttt{AAAA-MM-GG}.

    \subsubsubsection{Stile del testo}

    Gli stili del testo che vengono apportati all’interno di tutti i documenti sono:

\begin{itemize}
\item \textbf{Grassetto}: Lo stile grassetto viene utilizzato per indicare i termini degli elenchi puntati ed i titoli delle sezioni;
\item \textbf{Corsivo}: Lo stile corsivo viene utilizzato per indicare il nome del gruppo, il nome dell'azienda proponente e per le parole di particolare rilevanza;
\item \textbf{Sottolineato}: Utilizzato per i link presenti nei documenti;
\item \textbf{Monospazio}: Utilizzato per riferimenti a codice.
\end{itemize}

    \pagebreak

    \subsubsubsubsection{Elenchi puntati e numerati}

    Di seguito lo stile utilizzato dal team di sviluppo per gli elenchi puntati e numerati:

\begin{itemize}
\item Ogni punto dell'elenco inizia con la lettera maiuscola;
\item Alla fine di ogni punto vi è un ';';
\item Dopo l'ultima voce vi è un '.';
\item Se vi è un concetto da spiegare esso viene scritto in grassetto seguito da ':' e segue la spiegazione di esso che comincia per lettera maiuscola.
\end{itemize}

    \subsubsubsection{Glossario}
    % TODO da ricontrollare anche questo che ho visto c'è anche nell'introduzione
    Il Glossario è un documento che contiene tutte le parole ritenute ambigue nel contesto del progetto.

    I termini presenti sono separati in sezioni indicanti la loro prima lettera, in ordine alfabetico, affiancati
    da una breve descrizione del significato con cui sono usati e eventuali sinonimi.
    La definizione di questi ultimi non sarà riportata all'interno.

    I termini e i loro eventuali sinonimi riporteranno una 'G' in apice all'interno dei documenti. La G sarà
    presente solo nella prima occorrenza di quella parola in quel documento.

    \subsubsubsection{Altre norme tipografiche}

\begin{itemize}
\item Data in formato \texttt{AAAA/MM/GG}. % TODO aggiungere altre se ci sono.
\end{itemize}

\subsubsection{Elementi grafici}

    \subsubsubsection{Immagini}
    Le immagini vanno centrate orizzontalmente nella pagina e devono rispettare i margini previsti dal foglio qual ora
    fossero molto grandi.\\
    Grafici, diagrammi e schemi contano come immagini.

    \subsubsubsection{Tabelle}
    Le tabelle devono occupare tutta la larghezza del foglio indipendentemente dal numero di colonne.
    Inoltre per tabelle troppo grandi, queste vanno spezzate su più pagine e l'intestazione deve essere ripetuta
    per ognuno dei seguenti pezzi.\\
    Le righe devono essere a colori alternati per facilitarne la lettura.
\pagebreak
\subsubsection{Strumenti}

Di seguito sono riportati gli strumenti utilizzati dal team di sviluppo in fase di redazione dei documenti:

\begin{itemize}
\item \textbf{\LaTeX}: Linguaggio di markup per la preparazione di testi, basato sul programma di composizione tipografica TEX: \begin{center} \url{https://latex-project.org} \end{center}
\item \textbf{\LaTeX Workshop}: Estensione per VSCode che include un compilatore integrato, l'autocompletamento dei comandi \LaTeX e la segnalazione di errori di sintassi. L'estensione è poi configurata in sinergia con \emph{Git}$^{G}$ per ignorare la presenza di eventuali artefatti binari risultati dalla compilazione: \begin{center} \url{https://github.com/James-Yu/LaTeX-Workshop} \end{center}
\item \textbf{StarUML}: Software di disegno grafico multipiattaforma per la produzione di diagrammi \emph{UML}$^{G}$. Il gruppo ha scelto questo strumento perché gratuito (anche se con qualche limitazione) e perché comprende tutte le funzionalità necessarie al nostro utilizzo: \begin{center} \url{https://staruml.io/} \end{center}
\item \textbf{Docker}: Preparazione di un ambiente universale dove eseguire i seguenti strumenti di automazione per la correzione dei documenti: \begin{center} \url{https://www.docker.com/} \end{center}
\item \textbf{Hunspell}: Controllore ortografico, provvisto di dizionari in qualsiasi lingua e consente anche di utilizzare un dizionario personale: \begin{center} \url{https://hunspell.github.io/} \end{center}
\item \textbf{PHP}: Preprocessore e linguaggio di scripting utilizzato per la validazione dello stile dei documenti e costruzione del Glossario: \begin{center} \url{https://www.php.net/} \end{center}
\end{itemize}


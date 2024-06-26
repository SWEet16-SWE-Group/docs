\nonstopmode
\section{Requisiti}

In seguito allo studio del documento di capitolato, ai colloqui avuti con il proponente, alle sessioni di
brainstorming fra i membri del gruppo e all'analisi degli casi d'uso, sono stati individuati molteplici requisiti
che verranno di seguito elencati, suddivisi in due categorie:

\begin{itemize}
\item Requisiti funzionali: Sono strettamente legati alle funzionalità che il prodotto deve offrire agli utenti, al modo in cui il prodotto deve reagire a determinati input, agli output che deve produrre e al suo comportamento in determinate situazioni;
\item Requisiti non funzionali: Rappresentano i vincoli che il prodotto deve rispettare, legati alle caratteristiche tipiche di ogni prodotto software, come ad es. la scalabilità, la sicurezza, la performance.
\end{itemize}

\subsection{Requisiti funzionali}

Di seguito la specifica per i requisiti funzionali, i quali descrivono le funzionalità del sistema, le azioni che il sistema può compiere e le informazioni che il sistema può fornire.\\
Ogni requisito presenta un codice identificativo univoco, così definito:

\begin{itemize}
\item \textbf{RFO}: Requisito Funzionale Obbligatorio;
\item \textbf{RFD}: Requisito Funzionale Desiderabile.
\end{itemize}

\subsubsection{Obbligatori}

\begin{center}
    \begin{longtblr}{
        colspec={|X[1.5cm]|X[12cm]|X[2.5cm]|},
        row{odd}={bg=white},
        row{even}={bg=lightgray}
}
     \hline
     \textbf{Codice} & \textbf{Descrizione} & \textbf{Fonte} \\ \hline
     RFO1 & L'utente non riconosciuto deve poter registrare un nuovo account & UC1 \\ \hline
     RFO2 & L'utente non riconosciuto deve visualizzare un messaggio d'errore se la registrazione non va a buon fine & UCE1.1 e UCE1.2 \\ \hline
     RFO3 & L'utente non riconosciuto deve poter effettuare il login & UC2 \\ \hline
     RFO4 & L'utente non riconosciuto deve visualizzare un messaggio se il login non va a buon fine & UCE21 \\ \hline
     RFO5 & L'utente autenticato deve poter modificare le informazioni del suo account & UC14 \\ \hline
     RFO6 & L'utente non riconosciuto deve poter effettuare il logout & UC4 \\ \hline
     RFO7 & L'utente autenticato deve poter creare un profilo di tipo cliente & UC6\\ \hline
     RFO8 & L'utente autenticato deve poter creare un profilo di tipo ristoratore & UC7\\ \hline
     RFO9 & L'utente autenticato deve visualizzare un messaggio d'errore se la creazione del profilo di tipo ristoratore non va a buon fine & UCE7.1 e UCE7.2 \\ \hline
     RFO10 & L'utente autenticato deve poter cancellare un profilo & UC8 \\ \hline
     RFO11 & L'utente deve poter selezionare un qualunque profilo afferente al suo account & UC9 e UC10\\ \hline
     RFO12 & Il cliente deve poter modificare le informazioni relative al suo profilo & UC12\\ \hline
     RFO13 & Il ristoratore deve poter modificare le informazioni relative al suo profilo & UC13\\ \hline
     RFO14 & Il cliente e il ristoratore devono poter uscire dal loro profilo & UC15 \\ \hline
     RFO15 & L'utente non riconosciuto e il cliente devono poter visualizzare una lista di ristoranti & UC16 \\ \hline
     RFO16 & L'utente non riconosciuto e il cliente devono poter ricercare un ristorante & UC17\\ \hline
     RFO17 & L'utente non riconosciuto e il cliente devono poter applicare dei filtri alla ricerca di un ristorante & UC17\\ \hline
     RFO18 & L'utente non riconosciuto e il cliente devono poter visualizzare le informazioni relative ad un particolare ristorante, il suo menù e le relative recensioni & UC18 \\ \hline
     RFO19 & Il cliente deve poter effettuare una prenotazione presso un ristorante & UC19 \\ \hline
     RFO20 & Il cliente deve poter consultare la lista delle sue prenotazioni & UC20 \\ \hline
     RFO21 & Il cliente deve poter annullare una sua prenotazione & UC21 \\ \hline
     RFO22 & Il cliente deve poter visualizzare le informazioni relative ad una sua prenotazione in particolare & UC22 \\ \hline
     RFO23 & Il cliente deve poter invitare altri clienti a partecipare ad una sua prenotazione & UC23\\ \hline
     RFO24 & Il cliente deve poter accettare l'invito ricevuto, a partecipare ad una prenotazione & UC24 \\ \hline
     RFO25 & Il cliente deve poter effettuare un'ordinazione nel contesto di una sua prenotazione & UC25 \\ \hline
     RFO26 & Nell'effettuare l'ordinazione, il cliente deve poter apportare modifiche alle pietanze del ristorante, aggiungendo o rimuovendo ingredienti & UC25.2 \\ \hline
     RFO27 & Il cliente deve poter annullare un'ordinazione & UC26 \\ \hline
     RFO28 & Il cliente deve poter selezionare la modalità secondo la quale dividere il conto con gli altri clienti afferenti alla stessa prenotazione & UC27 \\ \hline
     RFO29 & Il cliente deve visualizzare un messaggio d'errore se la suddetta modalità è già stata scelta da un altro cliente afferente alla stessa prenotazione & UCE27 \\ \hline
     RFO30 & Il cliente deve poter effettuare il pagamento tramite l'app & UC28 \\ \hline
     RFO31 & Il cliente deve visualizzare un messaggio d'errore nel caso il pagamento non sia andato a buon fine & UCE28 \\ \hline
     RFO32 & Il cliente deve poter rilasciare feedback e una recensione relativi alla sua esperienza in un ristorante & UC29 \\ \hline
     RFO33 & Il cliente deve ricevere una notifica quando una richiesta di prenotazione è accettata o rifiutata & UC30 \\ \hline
     RFO34 & Il cliente e il ristoratore devono ricevere una notifica in concomitanza della della ricezione di un messaggio & UC48 \\ \hline
     RFO35 & Il cliente deve ricevere una notifica quando un cliente da egli invitato a partecipare ad una prenotazione, accetta l'invito & UC32\\ \hline
     RFO36 & Il ristoratore deve poter accettare la richiesta di prenotazione da parte di un cliente & UC33\\ \hline
     RFO37 & Il ristoratore deve poter rifiutare la richiesta di prenotazione da parte di un cliente & UC34\\ \hline
     RFO38 & Il ristoratore deve poter visualizzare le prenotazioni presso il suo ristorante & UC35 \\ \hline
     RFO39 & Il ristoratore deve poter visualizzare i dettagli relativi ad una singola prenotazione & UC36\\ \hline
     RFO40 & Il ristoratore deve poter vedere gli ingredienti necessari per soddisfare gli ordinati afferenti ad una singola prenotazione & UC36.1\\ \hline
     RFO41 & Il ristoratore deve poter vedere le ordinazioni effettuate dai clienti che partecipano alla stessa prenotazione & UC36.2\\ \hline
     RFO42 & Il ristoratore deve poter visualizzare lo stato del pagamento del conto relativo ad una prenotazione cioè se e quante ordinazioni o quote rimangono da pagare & UC36.4\\ \hline
     RFO43 & Il ristoratore deve poter modificare il menù di un suo ristorante aggiungendo, modificando e/o eliminando le pietanze e le sezioni del menù stesso & UC37\\ \hline
     RFO44 & Il ristoratore deve poter modificare la lista degli ingredienti presenti nelle pietanze del menù, aggiungendone di nuovi od eliminandone di già presenti & UC38 \\ \hline
     RFO45 & Il ristoratore deve, in fase di aggiunta di un nuovo ingrediente, poter associare specifici allergeni al suddetto ingrediente & UC38.2.1\\ \hline
     RFO46 & Il ristoratore deve poter visualizzare le recensioni relative al suo ristorante & UC39 \\ \hline
     RFO47 & Il ristorante deve poter gestire manualmente il pagamento del conto relativo ad una prenotazione & UC40\\ \hline
     RFO48 & Il ristoratore deve ricevere una notifica quando un cliente conferma un'ordinazione & UC43 \\ \hline
     RFO49 & Il ristoratore deve ricevere una notifica quando un cliente annulla una prenotazione & UC44 \\ \hline
     RFO50 & Il ristoratore deve ricevere una notifica quando è effettuata una nuova richiesta di prenotazione presso il suo ristorante & UC45\\ \hline
     RFO51 & Il ristoratore deve ricevere una notifica quando un cliente rilascia una nuova recensione relativa ad un suo ristorante & UC46\\ \hline
     RFO52 & Il ristoratore deve ricevere una notifica quando un cliente effettua un pagamento tramite l'app & UC47\\ \hline
     RFO53 & Il ristoratore e il cliente devono poter visualizzare la/le loro chat & UC50\\ \hline
     RFO54 & Il cliente deve poter aprire un canale di comunicazione tramite chat verso un ristoratore & UC49 \\ \hline
    \end{longtblr}
    \end{center}

\subsubsection{Desiderabili}

\begin{center}
    \begin{tblr}{
        colspec={|X[1.5cm]|X[3cm]|X[8cm]|X[2.5cm]|},
        row{odd}={bg=white},
        row{even}={bg=lightgray}
}
        \hline

        \textbf{Codice} & \textbf{Caratteristica} & \textbf{Descrizione} & \textbf{Fonte} \\

         RFD3 & Sicurezza & Le comunicazioni tra il client e il server devono essere crittografate, data la natura sensibile dei dati inseriti dagli utenti (tramite \emph{SSL/TLS}$^{G}$) & Capitolato \\ \hline
         RFD5 & Privacy & Viene richiesto all'utente un esplicito permesso per memorizzare i messaggi delle sue chat; nel caso in cui il permesso venga concesso, i messaggi saranno salvati in forma crittografata end-to-end & Capitolato \\ \hline

        \end{tblr}
\end{center}

\subsection{Requisiti di qualità}

Ogni requisito di qualità presenta un codice identificativo univoco, così definito:

\begin{itemize}
\item \textbf{RQO}: Requisito di Qualità Obbligatorio;
\item \textbf{RQD}: Requisito di Qualità Desiderabile.
\end{itemize}

\begin{center}
    \begin{tblr}{
        colspec={|X[1.5cm]|X[3cm]|X[8cm]|X[2.5cm]|},
        row{odd}={bg=white},
        row{even}={bg=lightgray}
}
        \hline
        \textbf{Codice} & \textbf{Caratteristica} & \textbf{Descrizione} & \textbf{Fonte} \\

        RQO1 & Sviluppo & Il prodotto deve essere sviluppato in modo concorde a quanto stabilito nelle Norme di Progetto & Brainstorming Interno \\ \hline
        RQO2 & Sviluppo & Il progetto deve essere accessibile pubblicamente su \emph{GitHub}$^{G}$ & Brainstorming Interno \\ \hline
        RQO3 & Sviluppo & Devono essere realizzati i test di unità ed integrazione con una copertura minima dell'80\% & Capitolato \\ \hline
        RQO4 & Sviluppo & Deve essere fornita una completa documentazione sulle scelte implementative e progettuali e relative motivazioni & Capitolato \\ \hline
        RQO5 & Sviluppo & Deve essere fornita una completa documentazione sugli eventuali problemi aperti e sulle possibili soluzioni da esplorare & Capitolato \\ \hline
        RQD6 & Sviluppo & Deve essere fornita un’analisi rispetto al carico massimo supportato in numero di dispositivi e dell'eventuale servizio cloud più adatto & Capitolato \\ \hline

    \end{tblr}
\end{center}

\subsection{Requisiti di vincolo}

Ogni requisito di vincolo presenta un codice identificativo univoco, così definito:

\begin{itemize}
\item \textbf{RVO}: Requisito di Vincolo Obbligatorio;
\item \textbf{RVD}: Requisito di Vincolo Desiderabile.
\end{itemize}
\begin{center}
    \begin{tblr}{
        colspec={|X[1.5cm]|X[3cm]|X[8cm]|X[2.5cm]|},
        row{odd}={bg=white},
        row{even}={bg=lightgray}
}
        \hline
        \textbf{Codice} & \textbf{Caratteristica} & \textbf{Descrizione} & \textbf{Fonte} \\

        RVO1 & Sviluppo & Il sistema sarà sviluppato e consegnato tramite piattaforma \emph{Docker}$^{G}$ & Capitolato \\ \hline

        % le versioni sono quelle uscite nel 2021
        RVO2 & Portabilità & Il sistema deve essere compatibile con il browser \emph{Firefox}$^{G}$ dalla versione 95 & Capitolato \\ \hline
        RVO3 & Portabilità & Il sistema deve essere compatibile con il browser \emph{Google Chrome}$^{G}$ dalla versione 90 & Capitolato \\ \hline
        RVO4 & Portabilità & Il sistema deve essere compatibile con il browser \emph{Safari}$^{G}$ dalla versione 15 & Capitolato \\ \hline

        \end{tblr}
\end{center}

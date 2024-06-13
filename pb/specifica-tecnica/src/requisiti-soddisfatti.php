\pagebreak
\section{Requisiti soddisfatti}
\subsection{Requisiti funzionali}

Di seguito la specifica per i requisiti funzionali, i quali descrivono le funzionalità del sistema, le azioni che il sistema può compiere e le informazioni che il sistema può fornire.\\
Ogni requisito presenta un codice identificativo univoco, così definito:
\begin{itemize}
\item \textbf{RFO:} Requisito Funzionale Obbligatorio;
\item \textbf{RFF:} Requisito Funzionale Facoltativo;
\item \textbf{RFD:} Requisito Funzionale Desiderabile.
\end{itemize}


\begin{center}
\begin{longtblr}{
colspec={|X[m,3cm]|X[m,1.5cm]|X[m,11cm]|},
row{odd}={bg=white},
row{even}={bg=lightgray}
}
\hline
\textbf{Stato} & \textbf{Codice} & \textbf{Descrizione} \\ \hline
Soddisfatto & RFO01 & L'utente non riconosciuto deve poter registrare un nuovo account \\ \hline
Soddisfatto & RFO02 & L'utente non riconosciuto deve visualizzare un messaggio d'errore se la registrazione non va a buon fine \\ \hline
Soddisfatto & RFO03 & L'utente non riconosciuto deve poter effettuare il login \\ \hline
Soddisfatto & RFO04 & L'utente non riconosciuto deve visualizzare un messaggio se il login non va a buon fine \\ \hline
Soddisfatto & RFO05 & L'utente autenticato deve poter modificare le informazioni del suo account \\ \hline
Soddisfatto & RFO06 & L'utente non riconosciuto deve poter effettuare il logout \\ \hline
Soddisfatto & RFO07 & L'utente autenticato deve poter creare un profilo di tipo cliente \\ \hline
Soddisfatto & RFO08 & L'utente autenticato deve poter creare un profilo di tipo ristoratore \\ \hline
Soddisfatto & RFO09 & L'utente autenticato deve visualizzare un messaggio d'errore se la creazione del profilo di tipo ristoratore non va a buon fine \\ \hline
Soddisfatto & RFO10 & L'utente autenticato deve poter cancellare un profilo \\ \hline
Soddisfatto & RFO11 & L'utente deve poter selezionare un qualunque profilo afferente al suo account \\ \hline
Soddisfatto & RFO12 & Il cliente deve poter modificare le informazioni relative al suo profilo \\ \hline
Soddisfatto & RFO13 & Il ristoratore deve poter modificare le informazioni relative al suo profilo \\ \hline
Soddisfatto & RFO14 & Il cliente e il ristoratore devono poter uscire dal loro profilo \\ \hline
Soddisfatto & RFO15 & L'utente non riconosciuto e il cliente devono poter visualizzare la lista di ristoranti disponibili \\ \hline
Soddisfatto & RFO16 & L'utente non riconosciuto e il cliente devono poter ricercare un ristorante attraverso il nome \\ \hline
Soddisfatto & RFO17 & L'utente non riconosciuto e il cliente devono poter applicare dei filtri alla ricerca di un ristorante \\ \hline
Soddisfatto & RFO18 & L'utente non riconosciuto e il cliente devono poter visualizzare le informazioni relative ad un particolare ristorante, il suo menù\\ \hline
Soddisfatto & RFO19 & Il cliente deve poter effettuare una prenotazione presso un ristorante \\ \hline
Soddisfatto & RFO20 & Il cliente deve poter consultare la lista delle sue prenotazioni \\ \hline
Non soddisfatto & RFO21 & Il cliente deve poter annullare una sua prenotazione \\ \hline
Soddisfatto & RFO22 & Il cliente deve poter visualizzare le informazioni relative ad una sua prenotazione in particolare \\ \hline
Soddisfatto & RFO23 & Il cliente deve poter invitare altri clienti a partecipare ad una sua prenotazione \\ \hline
Soddisfatto & RFO24 & Il cliente deve poter accettare l'invito ricevuto, a partecipare ad una prenotazione \\ \hline
Soddisfatto & RFO25 & Il cliente deve poter effettuare un'ordinazione nel contesto di una sua prenotazione \\ \hline
Soddisfatto & RFO26 & Nell'effettuare l'ordinazione, il cliente deve poter apportare modifiche alle pietanze del ristorante, modificandone la quantità o rimuovendo ingredienti \\ \hline
Soddisfatto & RFF01 & Nell'effettuare l'ordinazione, il cliente deve poter aggiungere ingredienti da una pietanza \\ \hline
Non soddisfatto & RFO27 & Il cliente deve poter annullare un'ordinazione \\ \hline
Soddisfatto & RFO28 & Il cliente deve poter selezionare la modalità secondo la quale dividere il conto con gli altri clienti afferenti alla stessa prenotazione \\ \hline
Non soddisfatto & RFF02 & Il cliente dopo aver scelto la modalità di divisione "equa" può selezionare altri profili e pagare per loro \\ \hline
Non soddisfatto & RFF03 & Il cliente dopo aver scelto la modalità di divisione "proporzionale" può selezionare pietanze ordinate da altri profili e pagarle \\ \hline
Non soddisfatto & RFF04 & Il cliente deve visualizzare un messaggio d'errore se la suddetta modalità di pagamento è già stata scelta da un altro cliente afferente alla stessa prenotazione \\ \hline
Non soddisfatto & RFF05 & Il cliente deve poter effettuare il pagamento tramite l'app \\ \hline
Soddisfatto & RFO29 & Il cliente deve visualizzare un messaggio d'errore nel caso il pagamento non sia andato a buon fine \\ \hline
Non soddisfatto & RFF06 & Il cliente deve poter rilasciare feedback e una recensione relativi alla sua esperienza in un ristorante \\ \hline
Non soddisfatto & RFO30 & Il cliente deve ricevere una notifica quando una richiesta di prenotazione è accettata o rifiutata \\ \hline
Non soddisfatto & RFF07 & Il cliente e il ristoratore devono ricevere una notifica in concomitanza della ricezione di un messaggio \\ \hline
Non soddisfatto & RFO31 & Il cliente deve ricevere una notifica quando un cliente da egli invitato a partecipare ad una prenotazione, accetta l'invito \\ \hline
Soddisfatto & RFO32 & Il ristoratore deve poter accettare la richiesta di prenotazione da parte di un cliente \\ \hline
Soddisfatto & RFO33 & Il ristoratore deve poter rifiutare la richiesta di prenotazione da parte di un cliente \\ \hline
Soddisfatto & RFO34 & Il ristoratore deve poter visualizzare le prenotazioni presso il suo ristorante \\ \hline
Non soddisfatto & RFF08 & Il ristoratore deve poter visualizzare le prenotazioni presso il suo ristorante implementate come un calendario con le prenotazioni raggruppate per giorno \\ \hline
Non soddisfatto & RFF09 & Il ristoratore deve poter vedere il dettaglio degli ingredienti necessari per ogni giornata \\ \hline
Soddisfatto & RFO35 & Il ristoratore deve poter visualizzare i dettagli relativi ad una singola prenotazione \\ \hline
Soddisfatto & RFO36 & Il ristoratore deve poter vedere gli ingredienti necessari per soddisfare gli ordinati afferenti ad una singola prenotazione \\ \hline
Soddisfatto & RFO37 & Il ristoratore deve poter vedere le ordinazioni effettuate dai clienti che partecipano alla stessa prenotazione \\ \hline
Soddisfatto & RFO38 & Il ristoratore deve poter visualizzare lo stato del pagamento del conto relativo ad una prenotazione cioè se e quante ordinazioni o quote rimangono da pagare \\ \hline
Soddisfatto & RFO39 & Il ristoratore deve poter modificare il menù di un suo ristorante aggiungendo, modificando e/o eliminando le pietanze e le sezioni del menù stesso \\ \hline
Soddisfatto & RFO40 & Il ristoratore deve poter modificare la lista degli ingredienti presenti nelle pietanze del menù, aggiungendone di nuovi od eliminandone di già presenti \\ \hline
Soddisfatto & RFO41 & Il ristoratore deve, in fase di aggiunta di un nuovo ingrediente, poter associare specifici allergeni al suddetto ingrediente \\ \hline
Non soddisfatto & RFF10 & Il ristoratore deve poter visualizzare le recensioni relative al suo ristorante \\ \hline
Soddisfatto & RFO42 & Il ristorante deve poter gestire manualmente il pagamento del conto relativo ad una prenotazione \\ \hline
Non soddisfatto & RFO43 & Il ristoratore deve ricevere una notifica quando un cliente conferma un'ordinazione \\ \hline
Non soddisfatto & RFO44 & Il ristoratore deve ricevere una notifica quando un cliente annulla una prenotazione \\ \hline
Non soddisfatto & RFO45 & Il ristoratore deve ricevere una notifica quando è effettuata una nuova richiesta di prenotazione presso il suo ristorante \\ \hline
Non soddisfatto & RFF11 & Il ristoratore deve ricevere una notifica quando un cliente rilascia una nuova recensione relativa ad un suo ristorante \\ \hline
Non soddisfatto & RFO46 & Il ristoratore deve ricevere una notifica quando un cliente effettua un pagamento tramite l'app \\ \hline
Non soddisfatto & RFF12 & Il ristoratore e il cliente devono poter visualizzare la/le loro chat \\ \hline
Non soddisfatto & RFF13 & Il cliente deve poter aprire un canale di comunicazione tramite chat verso un ristoratore \\ \hline
\end{longtblr}
\end{center}

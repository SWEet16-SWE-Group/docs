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
colspec={|X[m,1.5cm]|X[m,11cm]|X[m,3cm]|},
row{odd}={bg=white},
row{even}={bg=lightgray}
}
\hline
\textbf{Codice} & \textbf{Descrizione} & \textbf{Stato} \\ \hline
Non soddisfatto & RFO1 & L'utente non riconosciuto deve poter registrare un nuovo account \\ \hline
Non soddisfatto & RFO2 & L'utente non riconosciuto deve visualizzare un messaggio d'errore se la registrazione non va a buon fine \\ \hline
Non soddisfatto & RFO3 & L'utente non riconosciuto deve poter effettuare il login \\ \hline
Non soddisfatto & RFO4 & L'utente non riconosciuto deve visualizzare un messaggio se il login non va a buon fine \\ \hline
Non soddisfatto & RFO5 & L'utente autenticato deve poter modificare le informazioni del suo account \\ \hline
Non soddisfatto & RFO6 & L'utente non riconosciuto deve poter effettuare il logout \\ \hline
Non soddisfatto & RFO7 & L'utente autenticato deve poter creare un profilo di tipo cliente \\ \hline
Non soddisfatto & RFO8 & L'utente autenticato deve poter creare un profilo di tipo ristoratore \\ \hline
Non soddisfatto & RFO9 & L'utente autenticato deve visualizzare un messaggio d'errore se la creazione del profilo di tipo ristoratore non va a buon fine \\ \hline
Non soddisfatto & RFO10 & L'utente autenticato deve poter cancellare un profilo \\ \hline
Non soddisfatto & RFO11 & L'utente deve poter selezionare un qualunque profilo afferente al suo account \\ \hline
Non soddisfatto & RFO12 & Il cliente deve poter modificare le informazioni relative al suo profilo \\ \hline
Non soddisfatto & RFO13 & Il ristoratore deve poter modificare le informazioni relative al suo profilo \\ \hline
Non soddisfatto & RFO14 & Il cliente e il ristoratore devono poter uscire dal loro profilo \\ \hline
Non soddisfatto & RFO15 & L'utente non riconosciuto e il cliente devono poter visualizzare la lista di ristoranti disponibili \\ \hline
Non soddisfatto & RFO16 & L'utente non riconosciuto e il cliente devono poter ricercare un ristorante attraverso il nome \\ \hline
Non soddisfatto & RFO17 & L'utente non riconosciuto e il cliente devono poter applicare dei filtri alla ricerca di un ristorante \\ \hline
Non soddisfatto & RFO18 & L'utente non riconosciuto e il cliente devono poter visualizzare le informazioni relative ad un particolare ristorante, il suo menù e le relative recensioni \\ \hline
Non soddisfatto & RFO19 & Il cliente deve poter effettuare una prenotazione presso un ristorante \\ \hline
Non soddisfatto & RFO20 & Il cliente deve poter consultare la lista delle sue prenotazioni \\ \hline
Non soddisfatto & RFO21 & Il cliente deve poter annullare una sua prenotazione \\ \hline
Non soddisfatto & RFO22 & Il cliente deve poter visualizzare le informazioni relative ad una sua prenotazione in particolare \\ \hline
Non soddisfatto & RFO23 & Il cliente deve poter invitare altri clienti a partecipare ad una sua prenotazione \\ \hline
Non soddisfatto & RFO24 & Il cliente deve poter accettare l'invito ricevuto, a partecipare ad una prenotazione \\ \hline
Non soddisfatto & RFO25 & Il cliente deve poter effettuare un'ordinazione nel contesto di una sua prenotazione \\ \hline
Non soddisfatto & RFO26 & Nell'effettuare l'ordinazione, il cliente deve poter apportare modifiche alle pietanze del ristorante, modificandone la quantità o rimuovendo ingredienti \\ \hline
Non soddisfatto & RFF1 & Nell'effettuare l'ordinazione, il cliente deve poter aggiungere ingredienti da una pietanza \\ \hline
Non soddisfatto & RFO27 & Il cliente deve poter annullare un'ordinazione \\ \hline
Non soddisfatto & RFO28 & Il cliente deve poter selezionare la modalità secondo la quale dividere il conto con gli altri clienti afferenti alla stessa prenotazione \\ \hline
Non soddisfatto & RFF2 & Il cliente dopo aver scelto la modalità di divisione "equa" può selezionare altri profili e pagare per loro \\ \hline
Non soddisfatto & RFF3 & Il cliente dopo aver scelto la modalità di divisione "proporzionale" può selezionare pietanze ordinate da altri profili e pagarle \\ \hline
Non soddisfatto & RFF4 & Il cliente deve visualizzare un messaggio d'errore se la suddetta modalità è già stata scelta da un altro cliente afferente alla stessa prenotazione \\ \hline
Non soddisfatto & RFF5 & Il cliente deve poter effettuare il pagamento tramite l'app \\ \hline
Non soddisfatto & RFO29 & Il cliente deve visualizzare un messaggio d'errore nel caso il pagamento non sia andato a buon fine \\ \hline
Non soddisfatto & RFO30 & Il cliente deve poter rilasciare feedback e una recensione relativi alla sua esperienza in un ristorante \\ \hline
Non soddisfatto & RFO31 & Il cliente deve ricevere una notifica quando una richiesta di prenotazione è accettata o rifiutata \\ \hline
Non soddisfatto & RFF6 & Il cliente e il ristoratore devono ricevere una notifica in concomitanza della ricezione di un messaggio \\ \hline
Non soddisfatto & RFO32 & Il cliente deve ricevere una notifica quando un cliente da egli invitato a partecipare ad una prenotazione, accetta l'invito \\ \hline
Non soddisfatto & RFO33 & Il ristoratore deve poter accettare la richiesta di prenotazione da parte di un cliente \\ \hline
Non soddisfatto & RFO34 & Il ristoratore deve poter rifiutare la richiesta di prenotazione da parte di un cliente \\ \hline
Non soddisfatto & RFO35 & Il ristoratore deve poter visualizzare le prenotazioni presso il suo ristorante \\ \hline
Non soddisfatto & RFF7 & Il ristoratore deve poter visualizzare le prenotazioni presso il suo ristorante implementate come un calendario con le prenotazioni raggruppate per giorno \\ \hline
Non soddisfatto & RFF8 & Il ristoratore deve poter vedere il dettaglio degli ingredienti necessari per ogni giornata \\ \hline
Non soddisfatto & RFO36 & Il ristoratore deve poter visualizzare i dettagli relativi ad una singola prenotazione \\ \hline
Non soddisfatto & RFO37 & Il ristoratore deve poter vedere gli ingredienti necessari per soddisfare gli ordinati afferenti ad una singola prenotazione \\ \hline
Non soddisfatto & RFO38 & Il ristoratore deve poter vedere le ordinazioni effettuate dai clienti che partecipano alla stessa prenotazione \\ \hline
Non soddisfatto & RFO39 & Il ristoratore deve poter visualizzare lo stato del pagamento del conto relativo ad una prenotazione cioè se e quante ordinazioni o quote rimangono da pagare \\ \hline
Non soddisfatto & RFO40 & Il ristoratore deve poter modificare il menù di un suo ristorante aggiungendo, modificando e/o eliminando le pietanze e le sezioni del menù stesso \\ \hline
Non soddisfatto & RFO41 & Il ristoratore deve poter modificare la lista degli ingredienti presenti nelle pietanze del menù, aggiungendone di nuovi od eliminandone di già presenti \\ \hline
Non soddisfatto & RFO42 & Il ristoratore deve, in fase di aggiunta di un nuovo ingrediente, poter associare specifici allergeni al suddetto ingrediente \\ \hline
Non soddisfatto & RFO43 & Il ristoratore deve poter visualizzare le recensioni relative al suo ristorante \\ \hline
Non soddisfatto & RFO44 & Il ristorante deve poter gestire manualmente il pagamento del conto relativo ad una prenotazione \\ \hline
Non soddisfatto & RFO45 & Il ristoratore deve ricevere una notifica quando un cliente conferma un'ordinazione \\ \hline
Non soddisfatto & RFO46 & Il ristoratore deve ricevere una notifica quando un cliente annulla una prenotazione \\ \hline
Non soddisfatto & RFO47 & Il ristoratore deve ricevere una notifica quando è effettuata una nuova richiesta di prenotazione presso il suo ristorante \\ \hline
Non soddisfatto & RFO48 & Il ristoratore deve ricevere una notifica quando un cliente rilascia una nuova recensione relativa ad un suo ristorante \\ \hline
Non soddisfatto & RFO49 & Il ristoratore deve ricevere una notifica quando un cliente effettua un pagamento tramite l'app \\ \hline
Non soddisfatto & RFF9 & Il ristoratore e il cliente devono poter visualizzare la/le loro chat \\ \hline
Non soddisfatto & RFF10 & Il cliente deve poter aprire un canale di comunicazione tramite chat verso un ristoratore \\ \hline
\end{longtblr}
\end{center}

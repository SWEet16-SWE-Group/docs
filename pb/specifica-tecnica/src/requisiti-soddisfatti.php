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
        \textbf{Codice} & \textbf{Descrizione}                                                                                                                                          & \textbf{Stato}  \\ \hline
        RFO1            & L'utente non riconosciuto deve poter registrare un nuovo account                                                                                              & Non soddisfatto \\ \hline
        RFO2            & L'utente non riconosciuto deve visualizzare un messaggio d'errore se la registrazione non va a buon fine                                                      & Non soddisfatto \\ \hline
        RFO3            & L'utente non riconosciuto deve poter effettuare il login                                                                                                      & Non soddisfatto \\ \hline
        RFO4            & L'utente non riconosciuto deve visualizzare un messaggio se il login non va a buon fine                                                                       & Non soddisfatto \\ \hline
        RFO5            & L'utente autenticato deve poter modificare le informazioni del suo account                                                                                    & Non soddisfatto \\ \hline
        RFO6            & L'utente non riconosciuto deve poter effettuare il logout                                                                                                     & Non soddisfatto \\ \hline
        RFO7            & L'utente autenticato deve poter creare un profilo di tipo cliente                                                                                             & Non soddisfatto \\ \hline
        RFO8            & L'utente autenticato deve poter creare un profilo di tipo ristoratore                                                                                         & Non soddisfatto \\ \hline
        RFO9            & L'utente autenticato deve visualizzare un messaggio d'errore se la creazione del profilo di tipo ristoratore non va a buon fine                               & Non soddisfatto \\ \hline
        RFO10           & L'utente autenticato deve poter cancellare un profilo                                                                                                         & Non soddisfatto \\ \hline
        RFO11           & L'utente deve poter selezionare un qualunque profilo afferente al suo account                                                                                 & Non soddisfatto \\ \hline
        RFO12           & Il cliente deve poter modificare le informazioni relative al suo profilo                                                                                      & Non soddisfatto \\ \hline
        RFO13           & Il ristoratore deve poter modificare le informazioni relative al suo profilo                                                                                  & Non soddisfatto \\ \hline
        RFO14           & Il cliente e il ristoratore devono poter uscire dal loro profilo                                                                                              & Non soddisfatto \\ \hline
        RFO15           & L'utente non riconosciuto e il cliente devono poter visualizzare la lista di ristoranti disponibili                                                           & Non soddisfatto \\ \hline
        RFO16           & L'utente non riconosciuto e il cliente devono poter ricercare un ristorante attraverso il nome                                                                & Non soddisfatto \\ \hline
        RFO17           & L'utente non riconosciuto e il cliente devono poter applicare dei filtri alla ricerca di un ristorante                                                        & Non soddisfatto \\ \hline
        RFO18           & L'utente non riconosciuto e il cliente devono poter visualizzare le informazioni relative ad un particolare ristorante, il suo menù e le relative recensioni  & Non soddisfatto \\ \hline
        RFO19           & Il cliente deve poter effettuare una prenotazione presso un ristorante                                                                                        & Non soddisfatto \\ \hline
        RFO20           & Il cliente deve poter consultare la lista delle sue prenotazioni                                                                                              & Non soddisfatto \\ \hline
        RFO21           & Il cliente deve poter annullare una sua prenotazione                                                                                                          & Non soddisfatto \\ \hline
        RFO22           & Il cliente deve poter visualizzare le informazioni relative ad una sua prenotazione in particolare                                                            & Non soddisfatto \\ \hline
        RFO23           & Il cliente deve poter invitare altri clienti a partecipare ad una sua prenotazione                                                                            & Non soddisfatto \\ \hline
        RFO24           & Il cliente deve poter accettare l'invito ricevuto, a partecipare ad una prenotazione                                                                          & Non soddisfatto \\ \hline
        RFO25           & Il cliente deve poter effettuare un'ordinazione nel contesto di una sua prenotazione                                                                          & Non soddisfatto \\ \hline
        RFO26           & Nell'effettuare l'ordinazione, il cliente deve poter apportare modifiche alle pietanze del ristorante, modificandone la quantità o rimuovendo ingredienti     & Non soddisfatto \\ \hline
        RFF1            & Nell'effettuare l'ordinazione, il cliente deve poter aggiungere ingredienti da una pietanza                                                                    & Non soddisfatto \\ \hline
        RFO27           & Il cliente deve poter annullare un'ordinazione                                                                                                                & Non soddisfatto \\ \hline
        RFO28           & Il cliente deve poter selezionare la modalità secondo la quale dividere il conto con gli altri clienti afferenti alla stessa prenotazione                     & Non soddisfatto \\ \hline
        RFF2            & Il cliente dopo aver scelto la modalità di divisione "equa" può selezionare altri profili e pagare per loro                                                   & Non soddisfatto \\  \hline
        RFF3            & Il cliente dopo aver scelto la modalità di divisione "proporzionale" può selezionare pietanze ordinate da altri profili e pagarle                             & Non soddisfatto \\  \hline
        RFF4            & Il cliente deve visualizzare un messaggio d'errore se la suddetta modalità è già stata scelta da un altro cliente afferente alla stessa prenotazione          & Non soddisfatto \\ \hline
        RFF5            & Il cliente deve poter effettuare il pagamento tramite l'app                                                                                                   & Non soddisfatto \\ \hline
        RFO29           & Il cliente deve visualizzare un messaggio d'errore nel caso il pagamento non sia andato a buon fine                                                           & Non soddisfatto \\ \hline
        RFO30           & Il cliente deve poter rilasciare feedback e una recensione relativi alla sua esperienza in un ristorante                                                      & Non soddisfatto \\ \hline
        RFO31           & Il cliente deve ricevere una notifica quando una richiesta di prenotazione è accettata o rifiutata                                                            & Non soddisfatto \\ \hline
        RFF6            & Il cliente e il ristoratore devono ricevere una notifica in concomitanza della ricezione di un messaggio                                                & Non soddisfatto \\ \hline
        RFO32           & Il cliente deve ricevere una notifica quando un cliente da egli invitato a partecipare ad una prenotazione, accetta l'invito                                  & Non soddisfatto \\ \hline
        RFO33           & Il ristoratore deve poter accettare la richiesta di prenotazione da parte di un cliente                                                                       & Non soddisfatto \\ \hline
        RFO34           & Il ristoratore deve poter rifiutare la richiesta di prenotazione da parte di un cliente                                                                       & Non soddisfatto \\ \hline
        RFO35           & Il ristoratore deve poter visualizzare le prenotazioni presso il suo ristorante                                                                               & Non soddisfatto \\ \hline
        RFF7            & Il ristoratore deve poter visualizzare le prenotazioni presso il suo ristorante implementate come un calendario con le prenotazioni raggruppate per giorno    & Non soddisfatto \\ \hline
        RFF8            & Il ristoratore deve poter vedere il dettaglio degli ingredienti necessari per ogni giornata                                                                   & Non soddisfatto \\ \hline
        RFO36           & Il ristoratore deve poter visualizzare i dettagli relativi ad una singola prenotazione                                                                        & Non soddisfatto \\ \hline
        RFO37           & Il ristoratore deve poter vedere gli ingredienti necessari per soddisfare gli ordinati afferenti ad una singola prenotazione                                  & Non soddisfatto \\ \hline
        RFO38           & Il ristoratore deve poter vedere le ordinazioni effettuate dai clienti che partecipano alla stessa prenotazione                                               & Non soddisfatto \\ \hline
        RFO39           & Il ristoratore deve poter visualizzare lo stato del pagamento del conto relativo ad una prenotazione cioè se e quante ordinazioni o quote rimangono da pagare & Non soddisfatto \\ \hline
        RFO40           & Il ristoratore deve poter modificare il menù di un suo ristorante aggiungendo, modificando e/o eliminando le pietanze e le sezioni del menù stesso            & Non soddisfatto \\ \hline
        RFO41           & Il ristoratore deve poter modificare la lista degli ingredienti presenti nelle pietanze del menù, aggiungendone di nuovi od eliminandone di già presenti      & Non soddisfatto \\ \hline
        RFO42           & Il ristoratore deve, in fase di aggiunta di un nuovo ingrediente, poter associare specifici allergeni al suddetto ingrediente                                 & Non soddisfatto \\ \hline
        RFO43           & Il ristoratore deve poter visualizzare le recensioni relative al suo ristorante                                                                               & Non soddisfatto \\ \hline
        RFO44           & Il ristorante deve poter gestire manualmente il pagamento del conto relativo ad una prenotazione                                                              & Non soddisfatto \\ \hline
        RFO45           & Il ristoratore deve ricevere una notifica quando un cliente conferma un'ordinazione                                                                           & Non soddisfatto \\ \hline
        RFO46           & Il ristoratore deve ricevere una notifica quando un cliente annulla una prenotazione                                                                          & Non soddisfatto \\ \hline
        RFO47           & Il ristoratore deve ricevere una notifica quando è effettuata una nuova richiesta di prenotazione presso il suo ristorante                                    & Non soddisfatto \\ \hline
        RFO48           & Il ristoratore deve ricevere una notifica quando un cliente rilascia una nuova recensione relativa ad un suo ristorante                                       & Non soddisfatto \\ \hline
        RFO49           & Il ristoratore deve ricevere una notifica quando un cliente effettua un pagamento tramite l'app                                                               & Non soddisfatto \\ \hline
        RFF9            & Il ristoratore e il cliente devono poter visualizzare la/le loro chat                                                                                         & Non soddisfatto \\ \hline
        RFF10           & Il cliente deve poter aprire un canale di comunicazione tramite chat verso un ristoratore                                                                     & Non soddisfatto \\ \hline
    \end{longtblr}
\end{center}
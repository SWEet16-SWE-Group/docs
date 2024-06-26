\nonstopmode

\section{Test}

Nella seguente sezione verranno espresse in maniera dettagliata le varie metodologie di test, gli
obiettivi del testing e i criteri di successo utilizzati durante lo sviluppo del prodotto.
Il gruppo SWEet16, durante lo sviluppo dell' RTB, ha eseguito esclusivamente un'unica tipologia di test sui vari componenti utilizzati nella programmazione del PoC. Per perseguire la correttezza del prodotto e facilitare la fase di validazione, la verifica è stata svolta in parallelo allo sviluppo (\emph{Modello a V}$^{G}$).
I test dovranno essere resi il più automatici possibile, per evitare che la fase di testing rallenti la
produzione.

\begin{center}
\includegraphics[width=12cm]{test_v.png}
\end{center}
\begin{center}
Immagine 1: Modello a V
\end{center}

\subsection{Tipologie di test}

\subsubsection{Test di unità}

I \textit{test di unità} sono un tipo di test che viene utilizzato per verificare il funzionamento di una singola unità di codice all'interno di un software.
Una unità di codice può essere una funzione, una classe o qualsiasi altra porzione di codice che
svolge una specifica attività all'interno del software.
Questa viene definita con l’inizio del processo di progettazione e sviluppo software.

\subsubsection{Test di integrazione}

I \textit{test di integrazione} sono un tipo di test che viene utilizzato per verificare il funzionamento delle diverse componenti di un software quando vengono integrate tra loro e sono particolarmente utili
per identificare e risolvere eventuali problemi di integrazione.
Inoltre, i \textit{test di integrazione} possono essere utilizzati per verificare che il software soddisfi i requisiti prestabiliti in modo completo e che sia pronto per essere messo in produzione.

\subsubsection{Test di sistema}

I \textit{test di sistema} vengono utilizzati per verificare il funzionamento del software come sistema
completo, inclusi tutti i componenti e le interfacce con gli altri sistemi. I test di sistema hanno lo
scopo di verificare che il software soddisfi i requisiti prestabiliti e che sia pronto per essere messo in
produzione. In particolare, questa tipologia di test mira a soddisfare tutti i requisiti funzionali e la maggior parte di quelli non funzionali, compresi aspetti relativi all’usabilità, sicurezza,
performance e vulnerabilità.

\subsubsection{Test di accettazione}

I \textit{test di accettazione} sono un tipo di test che viene utilizzato per verificare che il software soddisfi i requisiti prestabiliti dal capitolato e che sia pronto per essere consegnato al committente o messo in produzione.
Vengono svolti alla presenza del committente e mirano a soddisfare pienamente i requisiti,
accertandosi di avere un prodotto funzionante e soddisfacente le aspettative progettuali iniziali.

\subsubsection{Test di regressione}

I \textit{test di regressione} sono un tipo di test che viene utilizzato per verificare che le modifiche apportate ad un software non influiscano negativamente sulle sue funzionalità esistenti, sono particolarmente utili per garantire che il software continui a funzionare correttamente anche dopo aver apportato modifiche o aggiornamenti.
Consistono nella ripetizione selettiva di \textit{test di unità, integrazione e sistema}, verificando quindi di non perdere funzionalità nella progressiva realizzazione del prodotto software.

\subsection{Specifica dei test}
Al fine di garantire di creare una denominazione uniforme e per facilitare la comprensione, i test sono identificati da un codice come segue:
\begin{center}
\textbf{T[Tipologia][Identificativo]}
\end{center}
Dove:

\begin{itemize}
\item \textbf{Tipologia} indica il tipo del test eseguito:
\begin{itemize}
\item U: Per Test di Unità;
\item I: Per Test di Integrazione;
\item S: Per Test di Sistema;
\item A: Per Test di Accettazione;
\item R: Per Test di Regressione.
\end{itemize}
\item \textbf{Identificativo} del test in oggetto.
\end{itemize}
Ciascuna tipologia di test sarà rappresentata da apposite tabelle, comprensive di identificativo, descrizione e stato. Come riportato precedentemente, al momento sono stati effettuati esclusivamente i \textit{test di unità}.

<?php

function tabella_test_to_string($titolo, $sigla, $tabella, $offset = 0) {
  $a = <<<'EOF'
  
  \subsubsection{TITOLO}

  \begin{longtblr}{
  colspec={|X[2.5cm, halign=c]|X[9cm, halign=c]|X[3.5cm, halign=c]|},
  row{odd}={bg=white},
  row{even}={bg=white},
  row{1}={bg=black, fg=white},
  }
  Identificativo & Descrizione & Stato \\ \hline
  TABELLA

  \end{longtblr}

  EOF;
  $linearizza = fn ($b, $c, $d) => "$c & $d & " . ucfirst(($b ? '' : 'non ') . 'superato' . " \\\\ \\hline \n");
  return str_replace_array([
    'TITOLO' => $titolo,
    'TABELLA' => implode('', array_map(fn ($a, $i) => $linearizza($a[0], $sigla . $i, $a[1]), $tabella, range(1 + $offset, count($tabella) + $offset))),
  ], $a);
}

$a =  tabella_test_to_string('Test di unità', 'TU', $tu = [
  [1, 'DashboardClienti viene renderizzato correttamente'],
  [1, 'DashboardRistoratori viene renderizzato correttamente'],
  [1, 'DettagliPietanza viene renderizzato correttamente'],
  [1, 'DettagliPrenotazione viene renderizzato correttamente'],
  [1, 'FormPrenotazione viene renderizzato correttamente'],
  [1, 'MenuPietanze viene renderizzato correttamente'],
  [1, 'Navbar viene renderizzato correttamente'],
  [1, 'Login viene renderizzato correttamente'],
  [1, 'ListaOrdinazioni viene renderizzato correttamente'],
  [1, 'DashboardClienti visualizza correttamente le prenotazioni del cliente'],
  [1, 'DashboardRistoratori visualizza correttamente le prenotazioni del ristorante e permetta la loro gestione'],
  [1, 'DettagliPietanza visualizza correttamente tutti i dettagli della pietanza'],
  [1, 'DettagliPrenotazione visualizza correttamente i dettagli di ciascuna prenotazione e ne permetta la gestione'],
  [1, 'FormPrenotazione consente correttamente di effettuare una prenotazione'],
  [1, 'Login permette correttamente di effettuare l\'accesso tramite cliente o ristoratore'],
]);

//[1, 'MenuPietanze visualizza correttamente tutto il menù e permette l\'ordinazione di ciascuna pietanza'],
//[1, 'Navbar visualizza correttamente la pagina attuale, le altre pagine e il nome dell\'utente o del ristoratore loggato'],
//[1, 'ListaOrdinazioni visualizza correttamente le ordinazioni confermate e l\'inventario degli ingredienti'],

$a = tabella_test_to_string('Test di unità', 'TU', [
  // frontend
  [1, 'Si verifica il corretto funzionamento di axios-client'],
  [1, 'Si verifica il corretto funzionamento di ClientService'],
  [1, 'Si verifica il corretto funzionamento di ContextProvider'],
  [1, 'Si verifica il corretto funzionamento di CreazioneProfiloCliente'],
  [1, 'Si verifica il corretto funzionamento di CreazioneProfiloRistoratore'],
  [1, 'Si verifica il corretto funzionamento di DashBoardCliente'],
  [1, 'Si verifica il corretto funzionamento di DashboardRistoratore'],
  [1, 'Si verifica il corretto funzionamento di DivisioneContoPagamento'],
  [1, 'Si verifica il corretto funzionamento di FormIngredienti'],
  [1, 'Si verifica il corretto funzionamento di FormOrdinazione'],
  [1, 'Si verifica il corretto funzionamento di FormPietanze'],
  [1, 'Si verifica il corretto funzionamento di FormPrenotazione'],
  [1, 'Si verifica il corretto funzionamento di GestioneIngredienti'],
  [1, 'Si verifica il corretto funzionamento di GestioneMenu'],
  [1, 'Si verifica il corretto funzionamento di IntolleranzeService'],
  [1, 'Si verifica il corretto funzionamento di Layout'],
  [1, 'Si verifica il corretto funzionamento di LinkInvito'],
  [1, 'Si verifica il corretto funzionamento di Login'],
  [1, 'Si verifica il corretto funzionamento di Menu'],
  [1, 'Si verifica il corretto funzionamento di ModificaInfoAccount'],
  [1, 'Si verifica il corretto funzionamento di ModificaProfiloCliente'],
  [1, 'Si verifica il corretto funzionamento di ModificaProfiloRistoratore'],
  [1, 'Si verifica il corretto funzionamento di NotFound'],
  [1, 'Si verifica il corretto funzionamento di Notifiche'],
  [1, 'Si verifica il corretto funzionamento di ResturantCard'],
  [1, 'Si verifica il corretto funzionamento di Ristorante'],
  [1, 'Si verifica il corretto funzionamento di Ristoranti'],
  [1, 'Si verifica il corretto funzionamento di router'],
  [1, 'Si verifica il corretto funzionamento di SearchBar'],
  [1, 'Si verifica il corretto funzionamento di SelezioneProfilo'],
  [1, 'Si verifica il corretto funzionamento di SignUp'],
  [1, 'Si verifica il corretto funzionamento di SingolaPrenotazioneCliente'],
  [1, 'Si verifica il corretto funzionamento di SingolaPrenotazioneRistoratore'],
  // backend
  [1, 'Si verifica il corretto funzionamento di AllergeniControllerTest'],
  [1, 'Si verifica il corretto funzionamento di AuthControllerTest'],
  [1, 'Si verifica il corretto funzionamento di ClientControllerTest'],
  [1, 'Si verifica il corretto funzionamento di ExampleTest'],
  [1, 'Si verifica il corretto funzionamento di IngredienteControllerTest'],
  [1, 'Si verifica il corretto funzionamento di InvitiTest'],
  [1, 'Si verifica il corretto funzionamento di NotificheControllerTest'],
  [1, 'Si verifica il corretto funzionamento di OrdinazioniTest'],
  [1, 'Si verifica il corretto funzionamento di PietanzaControllerTest'],
  [1, 'Si verifica il corretto funzionamento di PrenotazioneControllerTest'],
  [1, 'Si verifica il corretto funzionamento di ProfileControllerTest'],
  [1, 'Si verifica il corretto funzionamento di RistoratoreControllerTest'],
  [1, 'Si verifica il corretto funzionamento di RistoratoreTest'],
  [1, 'Si verifica il corretto funzionamento di UserControllerTest'],
]);

echo "$a";

?>

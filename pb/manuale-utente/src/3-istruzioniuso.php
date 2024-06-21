<?php

$contenuti = [
  'Utente anonimo' =>
  [
    'Esplorazione del sito' => <<<'EOF'

    Come utente anonimo, vale a dire, senza aver eseguito l'accesso, è possibile esplorare il sito.
    L'esplorazione comprende la ricerca e dei ristoranti con annessi i rispettivi menù.

    IMG-RISTORANTI
    IMG-RISTORANTE
    IMG-MENU
    
    EOF,
    'Registrazione e accesso' => <<<'EOF'

    Conclusa l'esplorazione del sito, l'utente può registrarsi tramite l'uso di email e password.
    Oppure può accedere direttamente se già in possesso di un account.

    IMG-SIGNUP
    IMG-LOGIN

    EOF,

  ],
  'Utente autenticato' =>
  [
    'Selezione profili' => <<<'EOF'

    Una volta eseguito l'accesso ci troveremo nella prima dashboard. Questa è la Dashboard Account.
    Da qui è possibile creare nuovi profili Cliente o Ristorare, accedere o modificare quelli già esistenti.

    IMG-SELEZIONE

    Creazione/modifica di un cliente.

    IMG-CREAZIONE-CLIENTE
    IMG-MODIFICA-CLIENTE

    Creazione/modifica di un ristoratore.

    IMG-CREAZIONE-RISTORATORE
    IMG-MODIFICA-RISTORATORE

    EOF,
    'Modifica dell\'account' => <<<'EOF'

    Per la protezione degli account è possibile cambiare la propria mail o password in qualsiasi momento.

    IMG-MODIFICA-ACCOUNT

    EOF,
  ],
  'Cliente' =>
  [
    'Dashboard' => <<<'EOF'

    Selezionato un profilo cliente da utilizzare, ci troviamo nella Dashboard Cliente.
    Qui sono stampate le prenotazioni in ordine di data con delle informazioni base.

    IMG-DASHBOARD-C

    EOF,
    'Prenotazioni' => <<<'EOF'

    Selezionato l'opzione 'prenota' dalla navbar in alto, si torna alla pagina vista prima di ricerca dei ristoranti.
    Ma aprendo un ristorante viene visualizzata l'opzione per prenotare.
    Facendo click su di essa si viene portati al form dove compilare i campi restanti e avviare la prenotazione.

    IMG-PRENOTAZIONE-RISTORANTE
    IMG-PRENOTAZIONE-FORM

    EOF,
    'Partecipazione a prenotazioni già avviate' => <<<'EOF'

    Inserendo il codice invito di una prenotazione (che si ricevuto per mezzi esterni) si viene portati alla pagina di invito.
    Sono illustrati i dettagli della prenotazione ed è possibile prendere parte alla prenotazione o tornare alla dashboard.

    IMG-INVITO

    EOF,
    'Dettagli prenotazione' => <<<'EOF'

    Entrando nei dettagli di una prenotazione sono mostrati i dettagli maggiori di essa:
    \begin{itemize}
      \item Codice di invito
      \item Stato di accettazione
      \item Data e orario
    \end{itemize}

    Poi seguono i link per la gestione dei pagamenti e la navigazione del menu per effettuare ordinazioni.

    IMG-DETTAGLI-C

    EOF,
    'Ordinazioni' => <<<'EOF'

    Selezionato l'opzione 'ordina' sotto ai dettagli della prenotazione si viene portati al menù del ristorante.
    N.B.: l'opzione 'ordina' è disponibile solo dopo che il ristoratore ha accettato la prenotazione.
    Ogni pietanza sarà accompagnata dai propri ingredienti e un pulsante di ordinazione.
    Facendo click su di esso si viene portati al form dove poter scegliere gli ingredienti da togliere o aggiungere,
    e il numero di ordinazioni da effettuare con quelle personalizzazioni.

    IMG-ORDINAZIONE-MENU
    IMG-ORDINAZIONE-FORM

    EOF,
    'Divisione del conto e pagamenti' => <<<'EOF'

    Tornando alla dashboard e selezionando 'Esamina pagamento', se non è già stato selezionato, viene chiesto un modo di dividere il conto.
    In base alla modalità scelta saranno poi illustrati i clienti partecipanti (modo equo) e ognuno dovrà pagare uguale, oppure saranno illustrate le pietanze con il proprio cliente ordinante (modo proporzionale).
    In entrambi i casi ognuno può pagare solo la propria parte di conto.

    IMG-DIVISIONECONTO
    IMG-PAGAMENTOEQUO
    IMG-PAGAMENTOPROPORZIONALE

    EOF,
  ],
  'Ristoratore' =>
  [
    'Dashboard' => <<<'EOF'

    Tornando alla selezione dei profili e selezionato un profilo ristoratore da utilizzare, ci troviamo nella Dashboard Ristoratore.
    Qui sono stampate:
    \begin{itemize}
    \item Le informazioni del ristorante
    \item Le prenotazioni in ordine di data con delle informazioni base
    \item I link alle pagine di gestione del menù
    \end{itemize}

    Le prenotazioni sono accompagnate anche dai tasti di accettazione, rifiuto, esaminazione dei pagamenti ed esaminazione dettagli aggiuntivi.

    IMG-DASHBOARD-R

    EOF,
    'Dettagli' => <<<'EOF'

    Nei dettagli si mostrano prima i dettagli base della prenotazione.
    Di seguito ci sono le quantità di ingredienti grezzi necessari a soddisfare la prenotazione con le ordinazioni di ogni cliente.
    Le ordinazioni possono essere cancellate in via eccezionale.

    IMG-DETTAGLI-R

    EOF,
    'Gestione del menù' => <<<'EOF'

    Il menù di un ristorante è gestito in due sezioni differenti.
    Assumendo che gli ingredienti di un ristorante cambino molto poco nel tempo,
    un ristoratore aggiunge prima tutti i propri ingredienti e poi tutte le pietanze.
    La prima pagina, per ingredienti o pietanze, è una lista di tutti gli elementi presenti accompagnati da un bottone di eliminazione.
    Sopra alle liste sono presenti i tasti per aggiungere un nuovo elemento o tornare alla dashboard.
    Le pagine per l'aggiunta di un nuovo elemento chiedono il nome del nuovo elemento e l'associazione con:
    \begin{itemize}
    \item Gli allergeni, nel caso di aggiunta di un ingrediente
    \item Gli ingredienti, nel caso di aggiunta di una pietanza
    \end{itemize}

    IMG-MODIFICA-INGREDIENTI
    IMG-CREAZIONE-INGREDIENTE
    IMG-MODIFICA-PIETANZE
    IMG-CREAZIONE-PIETANZA

    EOF,
    'Divisione del conto e pagamenti' => <<<'EOF'

    Il ristoratore non può scegliere il modo di divisione del conto.
    Quando questo viene scelto, egli può smarcare le quote del conto che vengono pagate esternamente all'app, per esempio alla cassa.

    IMG-PAGAMENTO-RISTORATORE

    EOF,
  ],
  'Notifiche' => <<<'EOF'

  Clienti e ristoratori ricevono notifiche riguardo le prenotazioni, le ordinazioni e chi vi partecipa.
  Queste notifiche sono consultabili in qualsiasi momento nelle rispettive pagine, accessibili tramite il link nella navbar in alto.

  IMG-NOTIFICHE-C
  IMG-NOTIFICHE-R

  EOF,
];

function _stampaimmaginiistruzioniduso($tex) {
  $img = <<<'EOF'
  \begin{figure}[h] \includegraphics[scale=1]{IMG} \end{figure}
  EOF;
  $imgreplace = fn ($a, $b, $tex) => str_replace_array([$a => str_replace_array(['IMG' => $b], $img)], $tex);
  $tex = $imgreplace('IMG-RISTORANTI','anonimo_ristoranti.png',$tex);
  $tex = $imgreplace('IMG-RISTORANTE','anonimo_ristorante.png',$tex);
  $tex = $imgreplace('IMG-MENU','anonimo_menu.png',$tex);
  $tex = $imgreplace('IMG-SIGNUP','anonimo_signup.png',$tex);
  $tex = $imgreplace('IMG-LOGIN','anonimo_login.png',$tex);

  $tex = $imgreplace('IMG-SELEZIONE','autenticato_selezioneprofilo.png',$tex);
  $tex = $imgreplace('IMG-MODIFICA','autenticato_modificaaccount.png',$tex);
  $tex = $imgreplace('IMG-MODIFICA-CLIENTE','autenticato_modificacliente.png',$tex);
  $tex = $imgreplace('IMG-MODIFICA-RISTORATORE','autenticato_modificaristoratore.png',$tex);
  $tex = $imgreplace('IMG-CREAZIONE-CLIENTE','autenticato_nuovocliente.png',$tex);
  $tex = $imgreplace('IMG-CREAZIONE-RISTORATORE','autenticato_nuovoristoratore.png',$tex);

  $tex = $imgreplace('IMG-DASHBOARD-C','cliente_dashboard.png',$tex);
  $tex = $imgreplace('IMG-DASHBOARD-R','ristoratore_dashboard.png',$tex);

  $tex = $imgreplace('IMG-NOTIFICHE-C','cliente_notifiche.png',$tex);
  $tex = $imgreplace('IMG-NOTIFICHE-R','ristoratore_notifiche.png',$tex);
  $tex = $imgreplace('IMG-DETTAGLI-C','cliente_dettagli.png',$tex);
  $tex = $imgreplace('IMG-DETTAGLI-R','ristoratore_dettagli.png',$tex);

  $tex = $imgreplace('IMG-PAGAMENTO-RISTORATORE','ristoratore_pagamenti.png',$tex);

  $tex = $imgreplace('IMG-DIVISIONECONTO','cliente_selezionedivisione.png',$tex);
  $tex = $imgreplace('IMG-PAGAMENTOEQUO','cliente_pagamento_equo.png',$tex);
  $tex = $imgreplace('IMG-PAGAMENTOPROPORZIONALE','cliente_pagamento_proporzionale.png',$tex);


  $tex = $imgreplace('IMG-PRENOTAZIONE-RISTORANTE','cliente_prenotazione_ristorante.png',$tex);
  $tex = $imgreplace('IMG-PRENOTAZIONE-FORM','cliente_formprenotazione.png',$tex);

  $tex = $imgreplace('IMG-INVITO','cliente_invito.png',$tex);
  $tex = $imgreplace('IMG-ORDINAZIONE-MENU','cliente_menu.png',$tex);
  $tex = $imgreplace('IMG-ORDINAZIONE-FORM','cliente_formordinazione.png',$tex);

  $tex = $imgreplace('IMG-MODIFICA-INGREDIENTI','ristoratore_modificaingredienti.png',$tex);
  $tex = $imgreplace('IMG-MODIFICA-PIETANZA','ristoratore_modificamenu.png',$tex);
  $tex = $imgreplace('IMG-CREAZIONE-INGREDIENTE','ristoratore_crea_ingrediente.png',$tex);
  $tex = $imgreplace('IMG-CREAZIONE-PIETANZA','ristoratore_crea_pietanza.png',$tex);
  if ($mancati = preg('/IMG-[A-Z\-]*/', $tex)[0]) {
    echo "Mancata sostituzione delle seguenti immagini\n";
    echo implode('', array_map(fn ($a) => "\t$a\n", $mancati));
    die(6);
  }
  return $tex;
}

$tex = _stampatex($contenuti, 'Istruzioni d\'uso', 'section');

$tex = _stampaimmaginiistruzioniduso($tex);

echo $tex;

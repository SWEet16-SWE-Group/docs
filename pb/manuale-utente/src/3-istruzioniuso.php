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

    IMG-REGISTRAZIONE
    IMG-ACCESSO

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
    'Navbar' =>
    [
      'Selezione profili' => null,
      'Impostazioni profilo' => null,
      'Dashboard' => null,
      'Ricerca dei ristoranti' =>
      [
        'Elenco dei ristoranti' => null,
        'Homepage del ristorante' => null,
        'Menù del ristorante' => null,
        'Form di prenotazione' => null,
      ],
      'Notifiche' => null,
    ],
    'Dashboard' =>
    [
      'Lista di prenotazioni' =>
      [
        'Attive' => null,
        'Scadute' => null,
      ],
      'Prenotazione' =>
      [
        'Ordinazioni collaborative' => null,
        'Manipolare un\'ordinazione' => null,
        'Effettuare pagamenti' => null,
        // 'Lasciare una recensione' => null,
      ],
    ],
  ],
  'Ristoratore' =>
  [
    'Navbar' =>
    [
      'Selezione profili' => null,
      'Impostazioni profilo' => null,
      'Dashboard' => null,
      'Impostazioni menù' =>
      [
        'Manipolazione pietanze' => null,
      ],
      'Notifiche' => null,
    ],
    'Dashboard' =>
    [
      'Lista di prenotazioni' => null,
      'Prenotazione' =>
      [
        'Ordinazioni collaborative' => null,
        'Dettagli ordinazioni' => null,
        'Segna il pagamento di pietanze/clienti come effettuati' => null,
      ],
    ],
  ],
];

echo _stampatex($contenuti, 'Istruzioni d\'uso', 'section');

?>

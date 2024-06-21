<?php

$contenuti = [
  'Utente anonimo' =>
  [
    'Ricerca dei ristoranti' =>
    [
      'Elenco dei ristoranti' => null,
      'Homepage del ristorante' => null,
      'Menù del ristorante' => null,
      'Form di prenotazione' => null,
    ],
  ],
  'Utente autenticato' =>
  [
    'Navbar' =>
    [
      'Impostazioni account' => null,
      'Nuovo profilo cliente' => null,
      'Nuovo profilo ristoratore' => null,
    ],
    'Selezione profili' => null,
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

echo _stampatex($contenuti, 'Manuale utente', 'section');

?>

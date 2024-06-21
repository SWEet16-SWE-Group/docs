<?php

require_once __DIR__ . '/../../../../.libphp/Utils.php';
require_once __DIR__ . '/../../../../.libphp/Membri.php';
require_once __DIR__ . '/../../../../.libphp/Gantt.php';

const preventivo = -1;
const consuntivo = -2;

function indicizza_tabella($a) {
  return [
    alberto_c()->nome => $a[alberto_c()->nome],
    bilal_em()->nome => $a[bilal_em()->nome],
    alberto_m()->nome => $a[alberto_m()->nome],
    alex_s()->nome => $a[alex_s()->nome],
    iulius_s()->nome => $a[iulius_s()->nome],
    giovanni_z()->nome => $a[giovanni_z()->nome],
  ];
}

function tabella_to_string($a) {
  return implode('', array_map(fn ($a) => implode(" & ", $a) . " \\\\ \\hline\n", $a));
}

function formatta_tabella($a) {
  return array_map(fn ($a) => array_map(fn ($a) => $a ? $a : '-', $a), $a);
}

function formatta_tabella_soldi($a) {
  return array_map(
    fn ($a) => array_map(
      fn ($k, $a) => (is_numeric($a) and ($k == 1 or $k == 3)) ? number_format($a, 2, ',', '.') : $a,
      array_keys($a),
      $a
    ),
    $a
  );
}

function tabella_ore($a) {
  return [
    ['Nominativo', 'Re', 'Am', 'An', 'Pg', 'Pr', 'Vf', 'Ore totali'],
    ...($colonne = array_map(fn ($a, $b) => array_merge([$b], $a, [array_sum($a)]), $a, array_keys($a))),
    ['Totale', ...array_map(fn ($a) => array_sum(array_column($colonne, $a)), range(1, 7))],
  ];
}

function tabella_soldi($a) {
  $ruoli = [
    'Responsabile'    => 30,
    'Amministratore'  => 20,
    'Analista'        => 25,
    'Progettista'     => 25,
    'Programmatore'   => 15,
    'Verificatore'    => 15,
  ];
  $a = array_combine(
    $k = array_keys($ruoli),
    array_map(fn ($k) => array_column($a, $k), range(0, 5))
  );
  return [
    ['Ruolo', 'Costo orario (€/h)', 'N. Ore', 'Costo totale (€)'],
    ...($colonne = array_map(fn ($k, $b) => [$k, $b, $o = array_sum($a[$k]), $o * $b], $k, $ruoli)),
    ['\\SetCell[c=3]{l} Totale', null, null, array_sum(array_column($colonne, 3))]
  ];
}

function rischio($rischio, $pianocontingenza, $impatto) {
  return str_replace_array(
    [
      'RISCHIO' => $rischio,
      'CONTINGENZA' => $pianocontingenza,
      'IMPATTO' => $impatto,
    ],
    <<<'EOF'
    \textbf{RISCHIO}
    \begin{itemize}
      \item \textbf{Esito Piano di Contingenza}: CONTINGENZA
      \item \textbf{Impatto}: IMPATTO
    \end{itemize}
    EOF
  );
}

const tabella_ore = <<<'EOF'
    \begin{tblr}{
        colspec={|X[5cm]|X[.5cm]|X[.5cm]|X[.5cm]|X[.5cm]|X[.5cm]|X[.5cm]|X[3.5cm]},
        row{odd}={bg=white},
        row{even}={bg=lightgray},
        row{1}={bg=black, fg=white},
        row{8}={bg=black, fg=white}
    }

    ORE

    \end{tblr}
  EOF;

function tabella_ore_to_string($tabella) {
  return str_replace_array(
    ['ORE' => tabella_to_string(formatta_tabella(tabella_ore($tabella)))],
    tabella_ore
  );
}

const tabella_soldi = <<<'EOF'
    \begin{tblr}{
        colspec={|X[5cm]|X[3.5cm]|X[1.5cm]|X[3.5cm]},
        row{odd}={bg=white},
        row{even}={bg=lightgray},
        row{1}={bg=black, fg=white},
        row{8}={bg=black, fg=white}
    }

    SOLDI

    \end{tblr}
  EOF;

function tabella_soldi_to_string($tabella) {
  return str_replace_array(
    ['SOLDI' => tabella_to_string(formatta_tabella_soldi(formatta_tabella(tabella_soldi($tabella))))],
    tabella_soldi
  );
}

function periodo(
  $titolo,
  $inizio,
  $fine,
  $attivita,
  $gantt,
  $preventivo,
  $consuntivo,
  $gestioneruoli,
  $rischi,
  $retrospettiva,
  $raggiunti,
  $mancati
) {
  $latex = <<<'EOF'
    \subsubsection{TITOLO}

    Inizio: INIZIO \\
    Fine: FINE \\

    \subsubsubsection{Preventivo orario}

    PREVENTIVO_ORE

    \subsubsubsection{Preventivo economico}

    PREVENTIVO_SOLDI

    \subsubsubsection{Attività svolte}

    \begin{itemize}
    ATTIVITA
    \end{itemize}

    \begin{center}
    GANTT
    \end{center}

    \subsubsubsection{Consuntivo orario}
  
    CONSUNTIVO_ORE
  
    \subsubsubsection{Consuntivo economico}

    CONSUNTIVO_SOLDI

    %\paragraph{Gestione dei ruoli}

    %RUOLI

    %\paragraph{Gestione dei rischi}

    %RISCHI
    % \b %egin{itemize}
    % \e %nd{itemize}

    RETROSPETTIVA

    \paragraph{Obbiettivi raggiunti}

    \begin{itemize}
    RAGGIUNTI
    \end{itemize}

    \paragraph{Obbiettivi mancati}

    \begin{itemize}
    MANCATI
    \end{itemize}

  EOF;

  $itemize = fn ($a) => implode('', array_map(fn ($a) => "\\item " . str_replace_array(["\n" => ""], $a) . "\n", $a));
  return str_replace_array(
    [
      'TITOLO' => $titolo,
      'INIZIO' => (DateTime::createFromFormat('Y/m/d', $inizio))->format('Y/m/d'),
      'FINE'   => (DateTime::createFromFormat('Y/m/d', $fine))->format('Y/m/d'),
      'ATTIVITA' => $attivita ? $itemize($attivita) : '\\item Nessuna attività svolta',
      'PREVENTIVO_ORE'    => tabella_ore_to_string($preventivo),
      'PREVENTIVO_SOLDI'  => tabella_soldi_to_string($preventivo),
      'CONSUNTIVO_ORE'    => tabella_ore_to_string($consuntivo),
      'CONSUNTIVO_SOLDI'  => tabella_soldi_to_string($consuntivo),
      //'RUOLI' => $gestioneruoli,
      //'RISCHI' => $rischi ? $itemize($rischi) : '\\item Nessun rischio incontrato',
      'RETROSPETTIVA' => $retrospettiva ? "  \\paragraph{Retrospettiva}\n\n$retrospettiva\n\n" : '',
      'RAGGIUNTI' => $raggiunti ? $itemize($raggiunti) : '\\item Nessun obbiettivo raggiunto',
      'MANCATI' => $mancati ? $itemize($mancati) : '\\item Nessun obbiettivo mancato',
      'GANTT' => $gantt == null ? '' : gantt_latex(...$gantt),
    ],
    $latex
  );
}

$periodi_rtb = [
  // ===========================================================================================================================
  // RTB 1
  [
    preventivo => [
      'Alberto C.'  => [0, 0, 0, 4, 0, 1],
      'Bilal El M.' => [0, 0, 4, 0, 0, 1],
      'Alberto M.'  => [3, 2, 0, 0, 0, 0],
      'Alex S.'     => [2, 3, 0, 0, 0, 0],
      'Iulius S.'   => [0, 0, 4, 0, 0, 1],
      'Giovanni Z.' => [0, 0, 0, 4, 0, 1],
    ],
    consuntivo => [
      'Alberto C.'  => [0, 0, 0, 4, 0, 1],
      'Bilal El M.' => [0, 0, 4, 0, 0, 1],
      'Alberto M.'  => [3, 2, 0, 0, 0, 0],
      'Alex S.'     => [2, 3, 0, 0, 0, 0],
      'Iulius S.'   => [0, 0, 4, 0, 0, 1],
      'Giovanni Z.' => [0, 0, 0, 4, 0, 1],
    ],
  ],
  // ===========================================================================================================================
  // RTB 2
  [
    preventivo => [
      'Alberto C.'  => [0, 0, 0, 0, 15, 2],
      'Bilal El M.' => [2, 3, 0, 4,  0, 2],
      'Alberto M.'  => [5, 0, 5, 0,  0, 0],
      'Alex S.'     => [0, 0, 0, 5,  5, 5],
      'Iulius S.'   => [0, 0, 7, 0,  0, 2],
      'Giovanni Z.' => [0, 0, 0, 0, 10, 0],
    ],
    consuntivo => [
      'Alberto C.'  => [0, 0, 0, 0, 20, 5],
      'Bilal El M.' => [0, 0, 0, 4,  0, 2],
      'Alberto M.'  => [2, 3, 5, 0,  0, 0],
      'Alex S.'     => [0, 0, 0, 5,  5, 5],
      'Iulius S.'   => [0, 0, 3, 4,  0, 2],
      'Giovanni Z.' => [0, 0, 0, 0, 15, 0],
    ],
  ],
  // ===========================================================================================================================
  // RTB 3
  [
    preventivo => [
      'Alberto C.'  =>  [0, 0,  5, 0, 0, 0],
      'Bilal El M.' =>  [0, 0,  5, 0, 0, 7],
      'Alberto M.'  =>  [0, 0, 10, 0, 0, 2],
      'Alex S.'     =>  [0, 5,  5, 0, 0, 0],
      'Iulius S.'   =>  [0, 0, 10, 0, 0, 2],
      'Giovanni Z.' =>  [5, 0,  0, 0, 0, 0],
    ],
    consuntivo => [
      'Alberto C.'  => [0, 2,  3, 0, 0, 0],
      'Bilal El M.' => [0, 0,  2, 0, 0, 3],
      'Alberto M.'  => [0, 0, 12, 0, 0, 5],
      'Alex S.'     => [0, 5, 10, 0, 0, 5],
      'Iulius S.'   => [0, 0, 12, 0, 0, 5],
      'Giovanni Z.' => [5, 0,  3, 0, 0, 2],
    ],
  ],
  // ===========================================================================================================================
  // RTB 4
  [
    preventivo => [
      'Alberto C.'  =>  [0, 0, 0, 2, 0, 3],
      'Bilal El M.' =>  [2, 2, 4, 2, 0, 5],
      'Alberto M.'  =>  [0, 0, 4, 0, 0, 5],
      'Alex S.'     =>  [2, 3, 0, 0, 0, 0],
      'Iulius S.'   =>  [0, 0, 4, 0, 0, 5],
      'Giovanni Z.' =>  [0, 0, 0, 5, 0, 5],
    ],
    consuntivo => [
      'Alberto C.'  => [0, 0, 0, 2, 0, 3],
      'Bilal El M.' => [2, 0, 4, 2, 0, 5],
      'Alberto M.'  => [0, 0, 4, 0, 0, 5],
      'Alex S.'     => [5, 5, 0, 0, 0, 0],
      'Iulius S.'   => [0, 0, 4, 0, 0, 5],
      'Giovanni Z.' => [0, 0, 0, 5, 0, 5],
    ],
  ],
  // ===========================================================================================================================
];

$periodi_pb = [
  // ===========================================================================================================================
  // PB 1
  [
    'Periodo 1',
    '2025/04/22',
    '2024/05/03',
    [],
    null,
    preventivo => [
      'Alberto C.'  => [0, 0, 0, 0, 0, 0],
      'Bilal El M.' => [0, 0, 0, 0, 0, 0],
      'Alberto M.'  => [0, 0, 0, 0, 0, 0],
      'Alex S.'     => [0, 0, 0, 0, 0, 0],
      'Iulius S.'   => [0, 0, 0, 0, 0, 0],
      'Giovanni Z.' => [0, 0, 0, 0, 0, 0],
    ],
    consuntivo => [
      'Alberto C.'  => [0, 0, 0, 0, 0, 0],
      'Bilal El M.' => [0, 0, 0, 0, 0, 0],
      'Alberto M.'  => [0, 0, 0, 0, 0, 0],
      'Alex S.'     => [0, 0, 0, 0, 0, 0],
      'Iulius S.'   => [0, 0, 0, 0, 0, 0],
      'Giovanni Z.' => [0, 0, 0, 0, 0, 0],
    ],
    '',
    [],
    <<<'EOF'
    Causa la lunga durata del progetto e l'accumulo di ritardi, sono nati forti attriti all'interno del gruppo in merito come procedere in fase di PB. Questi attriti si sono aggravati in veri e propri conflitti tra i membri del gruppo. In queste due settimane non è stato svolto nulla di rilevante.
    EOF,
    [],
    [],
  ],
  // ===========================================================================================================================
  // PB 2
  [
    'Periodo 2',
    '2025/05/06',
    '2024/05/18',
    [
      'Studio nuove delle tecnologie',
      'Studio delle librerie di testing',
      'Studio dei design pattern',
      'Implementazione della CI',
    ],
    [
      'pbg2.png',
      '640,400',
      [
        Attivita::Macro('Progettazione', '2024/05/06', [
          Attivita::Micro('Studio delle tecnologie', '2024/05/10', [
            Attivita::Micro('Studio delle librerie di testing', '2024/05/16', []),
            Attivita::Micro('Studio dei desgnin pattern',  '2024/05/14', []),
          ]),
        ]),
        Attivita::Macro('CI con Github Actions', '2024/05/10', [
          Attivita::Micro('Laravel', '2024/05/18', []),
          Attivita::Micro('React',  '2024/05/18', []),
          Attivita::Micro('Baseline di sviluppo',  '2024/05/18', []),
        ]),
      ],
    ],
    preventivo => [
      'Alberto C.'  => [0, 0, 0, 0, 0, 0],
      'Bilal El M.' => [0, 0, 0, 0, 0, 0],
      'Alberto M.'  => [0, 0, 0, 0, 0, 0],
      'Alex S.'     => [0, 0, 0, 0, 0, 0],
      'Iulius S.'   => [0, 0, 0, 0, 0, 0],
      'Giovanni Z.' => [0, 0, 0, 0, 0, 0],
    ],
    consuntivo => [
      'Alberto C.'  => [0, 0, 0, 0, 0, 0],
      'Bilal El M.' => [0, 0, 0, 0, 0, 0],
      'Alberto M.'  => [0, 0, 0, 0, 0, 0],
      'Alex S.'     => [0, 0, 6, 6, 0, 0],
      'Iulius S.'   => [0, 0, 0, 0, 0, 0],
      'Giovanni Z.' => [0, 0, 0, 0, 0, 0],
    ],
    '',
    [],
    <<<'EOF'
    I conflitti interni al gruppo sono stati risolti. \\
    Le questioni trattate principalmente sono state il ripristino di un contatto con il proponente e una seconda valutazione delle tecnologie scelte. A votazione si è deciso di adottare il framework di Laravel per lo sviluppo del backend. Successivamente il gruppo si è diviso in due sottogruppi da tre e tre, uno con lo scopo di riprendere contatto con il proponente e aggiornarlo sulla situazione, l'altro si è occupato di stabilire una baseline per l'inizio della fase di codifica. La baseline consisteva nella creazione un progetto "vuoto" dove fosse possibile utilizzare tutte le tecnologie scelte e averle interconnesse tra di loro, pronte per la codifica. Questa baseline non è stata raggiunta vista la complessità reale delle tecnologie scelte molto superiore a quella preventivata.
    EOF,
    [
      'Risoluzione degli attriti tra colleghi',
      'Ripreso una comunicazione costante con il proponente',
    ],
    [
      'Baseline MVP',
      'Consegna finale del progetto',
    ],
  ],
  // ===========================================================================================================================
  // PB 3
  [
    'Periodo 3',
    '2025/05/20',
    '2024/05/24',
    [],
    [
      'pbg3.png',
      '640,600',
      [
        Attivita::Macro('MVP 0', '2024/05/20', [
          Attivita::Micro('Registrazione',  '2024/05/21', []),
          Attivita::Micro('Creazione cliente',  '2024/05/21', []),
          Attivita::Micro('Creazione ristoratore',  '2024/05/21', []),
          Attivita::Micro('Selezione profilo',  '2024/05/22', []),
        ]),
        Attivita::Macro('MVP 1', '2024/05/21', [
          Attivita::Micro('Login',  '2024/05/22', []),
          Attivita::Micro('Logout',  '2024/05/22', []),
          Attivita::Micro('Modifica info account',  '2024/05/23', []),
          Attivita::Micro('Modifica info cliente',  '2024/05/23', []),
          Attivita::Micro('Modifica info ristoratore',  '2024/05/22', []),
        ]),
        Attivita::Macro('MVP 2', '2024/05/23', [
          Attivita::Micro('Dashboard cliente',  '2024/05/24', []),
          Attivita::Micro('Dashboard ristoratore',  '2024/05/24', []),
          Attivita::Micro('Form di prenotazione',  '2024/05/23', []),
          Attivita::Micro('Singola prenotazione cliente',  '2024/05/24', []),
        ]),
      ],
    ],
    preventivo => [
      'Alberto C.'  => [0, 0, 0, 0, 0, 0],
      'Bilal El M.' => [0, 0, 0, 0, 0, 0],
      'Alberto M.'  => [0, 0, 0, 0, 0, 0],
      'Alex S.'     => [0, 0, 0, 0, 0, 0],
      'Iulius S.'   => [0, 0, 0, 0, 0, 0],
      'Giovanni Z.' => [0, 0, 0, 0, 0, 0],
    ],
    consuntivo => [
      'Alberto C.'  => [0, 0, 0, 0, 0, 0],
      'Bilal El M.' => [0, 0, 0, 0, 0, 0],
      'Alberto M.'  => [0, 0, 0, 0, 0, 0],
      'Alex S.'     => [0, 12, 0, 0, 0, 0],
      'Iulius S.'   => [0, 0, 0, 0, 0, 0],
      'Giovanni Z.' => [0, 0, 0, 0, 0, 0],
    ],
    '',
    [],
    <<<'EOF'
    Sono state create le diverse task per la fase di codifica dell'MVP sotto forma di issue su GitHub. Ad ogni task è stata assegnata una priorità decrescente (più basso il numero, più è imperativo il suo completamento), issue con priorità uguale possono essere svolte in parallelo. Molto tempo è stato dedicato allo studio di Laravel, in quanto vi sono state molte difficoltà solo nella creazione di un docker che lo eseguisse e nel stabilire una connessione anche parziale tra esso e il database. È stato stimato che la codifica dell'MVP sia ciò che richieda maggiori risorse, il gruppo dunque si è diviso in due sottogruppi rispettivamente da cinque persone per la codifica e una per la stesura della documentazione.
    EOF,
    [
      'Suddivisione delle task in issue di GitHub con conseguente assegnazione ai membri',
      'Creazione della base docker dove si andrà a fare la codifica del progetto',
      'Creazione del database per l\'MVP',
      'Aggiunto PHP sopra \\LaTeX per maggiore automazione della stesura dei documenti',
    ],
    [
      'Consegna finale del progetto',
    ],
  ],
  // ===========================================================================================================================
  // PB 4
  [
    'Periodo 4',
    '2025/05/27',
    '2024/06/07',
    [
      'Sviluppo fase 3 dell\'MVP',
      'Sviluppo fase 4 dell\'MVP',
      'Sviluppo fase 5 dell\'MVP',
      'Sviluppo fase 6 dell\'MVP',
    ],
    [
      'pbg4.png',
      '640,530',
      [
        Attivita::Macro('MVP 3', '2024/05/27', [
          Attivita::Micro('Nuova pietanza',  '2024/05/28', [
            Attivita::Micro('Gestione pietanze',  '2024/05/29', []),
          ]),
          Attivita::Micro('Navigazione del menù',  '2024/05/29', []),
        ]),
        Attivita::Macro('MVP 4', '2024/05/30', [
          Attivita::Micro('Ristoratore: Dettagli prenotazione',  '2024/05/31', []),
          Attivita::Micro('Cliente: Dettagli pietanza',  '2024/05/31', []),
        ]),
        Attivita::Macro('MVP 5', '2024/05/31', [
          Attivita::Micro('Divisione del conto',  '2024/05/31', []),
          Attivita::Micro('Cliente: Pagamento',  '2024/06/01', []),
          Attivita::Micro('Ristoratore: Pagamento',  '2024/06/01', []),
        ]),
        Attivita::Macro('MVP 6', '2024/06/02', [
          Attivita::Micro('Test di integrazione',  '2024/06/03', []),
        ]),
      ]
    ],
    preventivo => [
      'Alberto C.'  => [0, 0, 0, 0, 0, 0],
      'Bilal El M.' => [0, 0, 0, 0, 0, 0],
      'Alberto M.'  => [0, 0, 0, 0, 0, 0],
      'Alex S.'     => [0, 0, 0, 0, 0, 0],
      'Iulius S.'   => [0, 0, 0, 0, 0, 0],
      'Giovanni Z.' => [0, 0, 0, 0, 0, 0],
    ],
    consuntivo => [
      'Alberto C.'  => [0, 0, 0, 0, 0, 0],
      'Bilal El M.' => [0, 0, 0, 0, 0, 0],
      'Alberto M.'  => [0, 0, 0, 0, 0, 0],
      'Alex S.'     => [0, 10, 0, 0, 26, 0],
      'Iulius S.'   => [0, 0, 0, 0, 0, 0],
      'Giovanni Z.' => [0, 0, 0, 0, 0, 0],
    ],
    '',
    [],
    <<<'EOF'
    Analizzando i progressi rasenti il nulla dei periodi precedenti.
    5 membri al pieno delle loro capacità messi a lavorare sull'MVP non erano sufficienti.
    Le decisione prese allora sono state di congelare la documentazione e coinvolgere tutti e 6 i membri.
    Il risultato di queste scelte è stato un avanzamento considerevole.
    EOF,
    [
      'Costruzione dei test',
      'Recupero del tempo perso nei periodi precedenti',
      'Avanzamento non più nullo',
    ],
    [
      'Consegna finale del progetto',
    ],
  ],
  // ===========================================================================================================================
  // PB 5
  [
    'Periodo 5',
    '2025/06/08',
    '2024/06/21',
    [
      'Stesura del manuale utente',
      'Stesura della specifica tecnica',
      'Sviluppo fase  7 dell\'MVP',
      'Sviluppo fase  8 dell\'MVP',
      'Sviluppo fase  9 dell\'MVP',
      'Sviluppo fase 10 dell\'MVP',
    ],
    [
      'pbg5.png',
      '640,900',
      [
        Attivita::Macro('MVP 7', '2024/06/08', [
          Attivita::Micro('Link ingredienti con gli allergeni',  '2024/06/08', []),
          Attivita::Micro('Link pietanze con gli ingredienti',  '2024/06/09', []),
        ]),
        Attivita::Macro('MVP 8', '2024/06/10', [
          Attivita::Micro('Divisione delle ordinazioni per cliente',  '2024/06/10', []),
          Attivita::Micro('Nella FormPietanza possibilità di selezionare gli ingredienti',  '2024/06/11', []),
          Attivita::Micro('Controllo che nel periodo dato il ristorante abbia abbastanza posti',  '2024/06/11', []),
        ]),
        Attivita::Macro('MVP 9', '2024/06/12', [
          Attivita::Micro('Link di invito prenotazione',  '2024/06/12', []),
          Attivita::Micro('Ricerca ristoranti',  '2024/06/12', []),
        ]),
        Attivita::Macro('MVP 10', '2024/06/13', [
          Attivita::Micro('Test funzionali',  '2024/06/13', [
            Attivita::Micro('Correzioni errori post test funzionali',  '2024/06/15', []),
            Attivita::Micro('Creazione dati DB',  '2024/06/16', []),
          ]),
        ]),
        Attivita::Macro('Documentazione', '2024/06/08', [
          Attivita::Micro('Manuale utente',  '2024/06/21', []),
          Attivita::Micro('Specifica tecnica',  '2024/06/21', []),
          Attivita::Micro('Piano di Progetto',  '2024/06/21', []),
          Attivita::Micro('Piano di Qualifica',  '2024/06/21', []),
        ]),
      ]
    ],
    preventivo => [
      'Alberto C.'  => [0, 0, 0, 0, 0, 0],
      'Bilal El M.' => [0, 0, 0, 0, 0, 0],
      'Alberto M.'  => [0, 0, 0, 0, 0, 0],
      'Alex S.'     => [0, 0, 0, 0, 0, 0],
      'Iulius S.'   => [0, 0, 0, 0, 0, 0],
      'Giovanni Z.' => [0, 0, 0, 0, 0, 0],
    ],
    consuntivo => [
      'Alberto C.'  => [0, 0, 0, 0, 0, 0],
      'Bilal El M.' => [0, 0, 0, 0, 0, 0],
      'Alberto M.'  => [0, 0, 0, 0, 0, 0],
      'Alex S.'     => [0, 3, 0, 0, 16, 0],
      'Iulius S.'   => [0, 0, 0, 0, 0, 0],
      'Giovanni Z.' => [0, 0, 0, 0, 0, 0],
    ],
    '', // gestione dei rischi
    [], // rischi
    <<<'EOF'
    Si è concluso lo sviluppo dell'MVP con tanto di approvazione da parte del proponente.
    La documentazione è stata aggiornata allo stato reale del progetto.
    EOF, // retrospettiva
    [
      'Approvazione del prodotto da parte del proponente',
      'Semaforo verde per la PB',
      'Consegna finale del progetto'
    ], // obbiettivi raggiunti
    [
    ], // obbiettivi mancati
  ],
  // ===========================================================================================================================
];

// CODICE DI VALIDAZIONE DELLE TABELLE
// NON TOCCARE
$_ = array_map(
  'indicizza_tabella',
  array_merge(
    array_column($periodi_rtb, preventivo),
    array_column($periodi_rtb, preventivo),
    array_column($periodi_pb,  consuntivo),
    array_column($periodi_pb,  consuntivo),
  )
);

function periodi_tostring($a) {
  return implode("\n", array_map(fn ($a) => periodo(...$a), $a));
}

function tabelle_ore_soldi_tostring($tabella, $periodo, $colonna) {
  $titolo = [
    preventivo => [
      '\textbf{Preventivo orario}',
      '\textbf{Preventivo economico}',
    ],
    consuntivo => [
      '\textbf{Consuntivo orario}',
      '\textbf{Consuntivo economico}',
    ],
  ];
  return ''
    . "\n\n{$titolo[$colonna][0]}\n\n"
    . tabella_ore_to_string($tabella[$periodo][$colonna])
    . "\n\n{$titolo[$colonna][1]}\n\n"
    . tabella_soldi_to_string($tabella[$periodo][$colonna]);
}

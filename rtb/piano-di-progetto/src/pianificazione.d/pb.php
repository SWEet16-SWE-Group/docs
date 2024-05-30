<?php

require_once __DIR__ . '/../../../../.libphp/Utils.php';
require_once __DIR__ . '/../../../../.libphp/Membri.php';
require_once __DIR__ . '/../../../../.libphp/Gantt.php';

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

    GANTT

    \begin{itemize}
    ATTIVITA
    \end{itemize}

    \subsubsubsection{Consuntivo orario}
  
    CONSUNTIVO_ORE
  
    \subsubsubsection{Consuntivo economico}

    CONSUNTIVO_SOLDI

    \paragraph{Gestione dei ruoli}

    RUOLI

    \paragraph{Gestione dei rischi}

    \begin{itemize}
    RISCHI
    \end{itemize}

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
      'RUOLI' => $gestioneruoli,
      'RISCHI' => $rischi ? $itemize($rischi) : '\\item Nessun rischio incontrato',
      'RETROSPETTIVA' => $retrospettiva ? "  \\paragraph{Retrospettiva}\n\n$retrospettiva\n\n" : '',
      'RAGGIUNTI' => $raggiunti ? $itemize($raggiunti) : '\\item Nessun obbiettivo raggiunto',
      'MANCATI' => $mancati ? $itemize($mancati) : '\\item Nessun obbiettivo mancato',
      'GANTT' => gantt_latex(__DIR__ . '/../Gantt/g1.png', [Attivita::Macro('M1', '2024-05-01', [Attivita::Micro('m1', '2024-05-02', [])])]),
    ],
    $latex
  );
}

$periodi_rtb = [
  // ===========================================================================================================================
  // RTB 1
  [
    4 => [
      'Alberto C.'  => [0, 0, 0, 4, 0, 1],
      'Bilal El M.' => [0, 0, 4, 0, 0, 1],
      'Alberto M.'  => [3, 2, 0, 0, 0, 0],
      'Alex S.'     => [2, 3, 0, 0, 0, 0],
      'Iulius S.'   => [0, 0, 4, 0, 0, 1],
      'Giovanni Z.' => [0, 0, 0, 4, 0, 1],
    ],
    5 => [
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
    4 => [
      'Alberto C.'  => [0, 0, 0, 0, 15, 2],
      'Bilal El M.' => [2, 3, 0, 4,  0, 2],
      'Alberto M.'  => [5, 0, 5, 0,  0, 0],
      'Alex S.'     => [0, 0, 0, 5,  5, 5],
      'Iulius S.'   => [0, 0, 7, 0,  0, 2],
      'Giovanni Z.' => [0, 0, 0, 0, 10, 0],
    ],
    5 => [
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
    4 => [
      'Alberto C.'  =>  [0, 0,  5, 0, 0, 0],
      'Bilal El M.' =>  [0, 0,  5, 0, 0, 7],
      'Alberto M.'  =>  [0, 0, 10, 0, 0, 2],
      'Alex S.'     =>  [0, 5,  5, 0, 0, 0],
      'Iulius S.'   =>  [0, 0, 10, 0, 0, 2],
      'Giovanni Z.' =>  [5, 0,  0, 0, 0, 0],
    ],
    5 => [
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
    4 => [
      'Alberto C.'  =>  [0, 0, 0, 2, 0, 3],
      'Bilal El M.' =>  [2, 2, 4, 2, 0, 5],
      'Alberto M.'  =>  [0, 0, 4, 0, 0, 5],
      'Alex S.'     =>  [2, 3, 0, 0, 0, 0],
      'Iulius S.'   =>  [0, 0, 4, 0, 0, 5],
      'Giovanni Z.' =>  [0, 0, 0, 5, 0, 5],
    ],
    5 => [
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
    [
      'Alberto C.'  => [0, 0, 0, 0, 0, 0],
      'Bilal El M.' => [0, 0, 0, 0, 0, 0],
      'Alberto M.'  => [0, 0, 0, 0, 0, 0],
      'Alex S.'     => [0, 0, 0, 0, 0, 0],
      'Iulius S.'   => [0, 0, 0, 0, 0, 0],
      'Giovanni Z.' => [0, 0, 0, 0, 0, 0],
    ],
    [
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
    '???',
    '2025/05/06',
    '2024/05/18',
    [],
    [
      'Alberto C.'  => [0, 0, 0, 0, 0, 0],
      'Bilal El M.' => [0, 0, 0, 0, 0, 0],
      'Alberto M.'  => [0, 0, 0, 0, 0, 0],
      'Alex S.'     => [0, 0, 0, 0, 0, 0],
      'Iulius S.'   => [0, 0, 0, 0, 0, 0],
      'Giovanni Z.' => [0, 0, 0, 0, 0, 0],
    ],
    [
      'Alberto C.'  => [0, 0, 0, 0, 0, 0],
      'Bilal El M.' => [0, 0, 0, 0, 0, 0],
      'Alberto M.'  => [0, 0, 0, 0, 0, 0],
      'Alex S.'     => [0, 0, 0, 0, 0, 0],
      'Iulius S.'   => [0, 0, 0, 0, 0, 0],
      'Giovanni Z.' => [0, 0, 0, 0, 0, 0],
    ],
    '',
    [],
    '',
    [],
    [],
  ],
  // ===========================================================================================================================
  // PB 3
  [
    'cose di progettazione',
    '2025/05/20',
    '2024/05/24',
    [
      'Suddivisione delle task in issue di GitHub con conseguente assegnazione ai membri',
      'Creazione della base docker dove si andrà a fare la codifica del progetto',
      'Creazione del database per l\'MVP',
      'Aggiunto PHP sopra \\LaTeX per maggiore automazione della stesura dei documenti',
    ],
    [
      'Alberto C.'  => [0, 0, 0, 0, 0, 0],
      'Bilal El M.' => [0, 0, 0, 0, 0, 0],
      'Alberto M.'  => [0, 0, 0, 0, 0, 0],
      'Alex S.'     => [0, 0, 0, 0, 0, 0],
      'Iulius S.'   => [0, 0, 0, 0, 0, 0],
      'Giovanni Z.' => [0, 0, 0, 0, 0, 0],
    ],
    [
      'Alberto C.'  => [0, 0, 0, 0, 0, 0],
      'Bilal El M.' => [0, 0, 0, 0, 0, 0],
      'Alberto M.'  => [0, 0, 0, 0, 0, 0],
      'Alex S.'     => [0, 0, 0, 0, 0, 0],
      'Iulius S.'   => [0, 0, 0, 0, 0, 0],
      'Giovanni Z.' => [0, 0, 0, 0, 0, 0],
    ],
    '',
    [],
    '',
    [],
    [],
  ],
  // ===========================================================================================================================
  // PB 4
  [
    'sviluppo effettivo',
    '2025/05/27',
    '2024/05/31',
    [],
    [
      'Alberto C.'  => [0, 0, 0, 0, 0, 0],
      'Bilal El M.' => [0, 0, 0, 0, 0, 0],
      'Alberto M.'  => [0, 0, 0, 0, 0, 0],
      'Alex S.'     => [0, 0, 0, 0, 0, 0],
      'Iulius S.'   => [0, 0, 0, 0, 0, 0],
      'Giovanni Z.' => [0, 0, 0, 0, 0, 0],
    ],
    [
      'Alberto C.'  => [0, 0, 0, 0, 0, 0],
      'Bilal El M.' => [0, 0, 0, 0, 0, 0],
      'Alberto M.'  => [0, 0, 0, 0, 0, 0],
      'Alex S.'     => [0, 0, 0, 0, 0, 0],
      'Iulius S.'   => [0, 0, 0, 0, 0, 0],
      'Giovanni Z.' => [0, 0, 0, 0, 0, 0],
    ],
    '',
    [],
    '',
    [],
    [],
  ]
  // ===========================================================================================================================
];

// CODICE DI VALIDAZIONE DELLE TABELLE
// NON TOCCARE
$_ = array_map(
  'indicizza_tabella',
  array_merge(
    array_column($periodi_rtb, 5),
    array_column($periodi_rtb, 5),
    array_column($periodi_pb,  4),
    array_column($periodi_pb,  5),
  )
);

function periodi_tostring($a) {
  return implode("\n", array_map(fn ($a) => periodo(...$a), $a));
}

const preventivo = 4;
const consuntivo = 5;

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

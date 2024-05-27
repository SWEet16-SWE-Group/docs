<?php

require_once __DIR__ . '/../../../../.libphp/Utils.php';

function tabella_to_string($a) {
  return implode('', array_map(fn ($a) => implode(" & ", $a) . " \\\\ \\hline\n", $a));
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
    'Responsabile'    => 0,
    'Amministratore'  => 1,
    'Analista'        => 2,
    'Progettista'     => 3,
    'Programmatore'   => 4,
    'Verificatore'    => 5,
  ];
  $a = array_combine(
    $k = array_keys($ruoli),
    array_map(fn ($k) => array_column($a, $k), range(0, 5))
  );
  return [
    ['Ruolo', 'Costo orario (€/h)', 'N. Ore', 'Costo totale (€)'],
    ...($colonne = array_map(fn ($k, $b) => [$k, $b, $o = array_sum($a[$k]), $o * $b], $k, $ruoli)),
    ['Totale', null, null, array_sum(array_column($colonne, 3))]
  ];
}

function periodo($titolo, $inizio, $fine, $attivita, $preventivo, $consuntivo, $gestioneruoli, $rischi) {
  $tabella_ore = <<<'EOF'
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

  $tabella_soldi = <<<'EOF'
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

  $latex = <<<'EOF'
    \subsection{TITOLO}

    Inizio: INIZIO \\
    Fine: FINE \\

    \subsubsection{Preventivo orario}

    PREVENTIVO_ORE

    \subsubsection{Preventivo economico}

    PREVENTIVO_SOLDI

    \subsubsection{Attività svolte}

    \begin{itemize}
    ATTIVITA
    \end{itemize}

    \subsubsection{Consuntivo orario}
  
    CONSUNTIVO_ORE
  
    \textbf{Consuntivo economico}

    CONSUNTIVO_SOLDI

  EOF;

  return str_replace_array(
    [
      'TITOLO' => $titolo,
      'INIZIO' => (DateTime::createFromFormat('Y/m/d', $inizio))->format('Y/m/d'),
      'FINE'   => (DateTime::createFromFormat('Y/m/d', $fine))->format('Y/m/d'),
      'ATTIVITA' => $attivita ? implode('', array_map(fn ($a) => "\\item $a\n", $attivita)) : '\\item Nessuna attività svolta',
      'PREVENTIVO_ORE'    => str_replace_array(['ORE'   => tabella_to_string(tabella_ore($preventivo))],    $tabella_ore),
      'PREVENTIVO_SOLDI'  => str_replace_array(['SOLDI' => tabella_to_string(tabella_soldi($preventivo))],  $tabella_soldi),
      'CONSUNTIVO_ORE'    => str_replace_array(['ORE'   => tabella_to_string(tabella_ore($consuntivo))],    $tabella_ore),
      'CONSUNTIVO_SOLDI'  => str_replace_array(['SOLDI' => tabella_to_string(tabella_soldi($consuntivo))],  $tabella_soldi),
    ],
    $latex
  );
}

$periodi = [
  [
    'periodo buio',
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
    '',
  ],
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
    '',
  ],
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
    '',
  ],
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
    '',
  ]
];

echo implode("\n", array_map(fn ($a) => periodo(...$a), $periodi));

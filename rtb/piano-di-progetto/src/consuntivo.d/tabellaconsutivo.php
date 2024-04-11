<?php

function multireplace($args, $txt) {
  return str_replace(array_keys($args), $args, $txt);
}

function trasponi($a) {
  $b = [[]];
  foreach ($a as $i => $v) {
    foreach ($v as $j => $u) {
      $b[$j][$i] = $u;
    }
  }
  return $b;
}

function ruolo($ruolo, $costo) {
  return fn ($preventivo, $consuntivo) => [
    'Ruolo' => $ruolo,
    'Ore preventivate (h)' => $preventivo,
    'Ore effettive (h)' => $consuntivo,
    'Costi preventivati (€)' => $p = $preventivo * $costo,
    'Costi effettivi (€)' => $c = $consuntivo * $costo,
    'Differenze' => $c - $p,
  ];
}

function tabella($titolo, $data) {
  $data[] = [
    'Ruolo' => 'Totale',
    'Ore preventivate (h)'   => array_sum(array_column($data, 'Ore preventivate (h)')),
    'Ore effettive (h)'      => array_sum(array_column($data, 'Ore effettive (h)')),
    'Costi preventivati (€)' => array_sum(array_column($data, 'Costi preventivati (€)')),
    'Costi effettivi (€)'    => array_sum(array_column($data, 'Costi effettivi (€)')),
    'Differenze'             => array_sum(array_column($data, 'Differenze')),
  ];

  foreach ($data as $_ => &$v) {
    $v['Costi preventivati (€)'] = sprintf('%.2f', $v['Costi preventivati (€)']);
    $v['Costi effettivi (€)'] = sprintf('%.2f', $v['Costi effettivi (€)']);
    $v['Differenze'] = sprintf('%.2f', $v['Differenze']);
  }

  $data = array_merge([array_keys($data[0])], $data);
  foreach ($data as $_ => &$v) {
    foreach ($v as $_ => &$u) {
      $u = sprintf('%15s', (string)$u);
    }
    $v = implode(' & ', $v) . ' \\\\ \\hline';
  }
  $data = implode("\n", $data);

  return multireplace(
    [
      '<TABELLA>' => $data,
      '<TITOLO>' => $titolo,
    ],
    <<<EOF

\\subsection{<TITOLO>}

\\subsubsection{Costi}

\\begin{tblr}{
colspec={|X[3.5cm]|X[2.5cm]|X[1.5cm]|X[1.5cm]|X[1.5cm]},
row{odd}={bg=white},
row{even}={bg=lightgray},
row{1}={bg=black,fg=white},
row{8}={bg=black,fg=white}
}

<TABELLA>
  
\\end{tblr}


EOF
  );
}

$ruoli = [
  ruolo('Responsabile',     30),
  ruolo('Amministratore',   20),
  ruolo('Analista',         25),
  ruolo('Progettista',      25),
  ruolo('Programmatore',    15),
  ruolo('Verificatore',     15),
];

$dati = [
  'Analisi e RTB' => [
    'Preventivo' => [21, 18, 67, 26, 30, 49],
    'Consuntivo' => [19, 20, 70, 30, 40, 61],
  ],
  'PB' => [
    'Preventivo' => [00, 00, 00, 00, 00, 00],
    'Consuntivo' => [00, 00, 00, 00, 00, 00],
  ],
  'CA' => [
    'Preventivo' => [00, 00, 00, 00, 00, 00],
    'Consuntivo' => [00, 00, 00, 00, 00, 00],
  ],
];
$dati['Riepilogo'] = [
  'Preventivo' => array_map(fn ($d) => array_sum($d), trasponi(array_column($dati, 'Preventivo'))),
  'Consuntivo' => array_map(fn ($d) => array_sum($d), trasponi(array_column($dati, 'Consuntivo'))),
];

$txt = implode(
  "\n",
  array_map(
    fn ($val, $key) => tabella(
      $key,
      array_map(
        fn ($r, $c, $p) => $r($p, $c),
        $ruoli,
        $val['Preventivo'],
        $val['Consuntivo']
      )
    ),
    $dati,
    array_keys($dati)
  )
);

echo $txt;

file_put_contents('out.tex', $txt);

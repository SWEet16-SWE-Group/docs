<?php

require_once __DIR__ . '/../pianificazione.d/pb.php';
require_once __DIR__ . '/../pianificazione.d/rtb.php';

$rtb_somma_preventivi = somma3d(array_column($periodi_rtb, preventivo), $membri, range(0, 5));
$rtb_somma_consuntivi = somma3d(array_column($periodi_rtb, consuntivo), $membri, range(0, 5));

$pb_somma_preventivi = somma3d(array_column($periodi_pb, preventivo), $membri, range(0, 5));
$pb_somma_consuntivi = somma3d(array_column($periodi_pb, consuntivo), $membri, range(0, 5));

function formatta_tabella_differenza_soldi($a) {
  return formatta_tabella_soldi_colonne($a, [3, 4, 5]);
}

function differenze_soldi($p, $c) {
  // AAAA YEEEEEEEES
  // finisci la funzione per stampare i consuntivi di godimento che poi tutta sta merda va a fanculo
  $somma_verticale = fn ($a, $i) => array_map(fn ($i) => array_sum(array_column($a, $i)), $i);;
  $ore_p = $somma_verticale($p, range(0, 5));
  $ore_c = $somma_verticale($c, range(0, 5));
  $corpo = array_map(
    fn ($p, $c, $r) => [$r->nome, $p, $c, $pp = $p * $r->soldi, $cc = $c * $r->soldi, $cc - $pp],
    $ore_p,
    $ore_c,
    [
      (object)['soldi' => 30, 'nome' => 'Responsabile'],
      (object)['soldi' => 20, 'nome' => 'Amministratore'],
      (object)['soldi' => 25, 'nome' => 'Analista'],
      (object)['soldi' => 25, 'nome' => 'Progettista'],
      (object)['soldi' => 15, 'nome' => 'Programmatore'],
      (object)['soldi' => 15, 'nome' => 'Verificatore'],
    ],
  );
  $tabella = [
    ['Ruolo', 'Ore preventivate', 'Ore effettive', 'Costi preventivati (€)', 'Costi effettivi (€)', 'Differenze'],
    ...$corpo,
    ['Totale', ...array_map(fn ($i) => array_sum(array_column($corpo, $i)), range(1, 5))],
  ];
  return $tabella;
}

$rtb = tabella_to_string(formatta_tabella_differenza_soldi(formatta_tabella(differenze_soldi($rtb_somma_preventivi, $rtb_somma_consuntivi))));

//print_r($rtb);

//die();

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
    $v['Differenze'] = sprintf(($v['Differenze'] > 0 ? '+' : '') . '%.2f', $v['Differenze']);
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
colspec={X[3cm]|X[2.5cm]|X[2.5cm]|X[1.5cm]|X[1.5cm]|X[2cm]},
row{odd}={bg=white},
row{even}={bg=lightgray},
row{1}={bg=black,fg=white},
row{8}={bg=black,fg=white}
}

<TABELLA>
  
\\end{tblr}

\\subsubsection{Resoconto}

Si veda la retrospettiva nella sezione di Pianificazione.


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
  'RTB' => [
    'Preventivo' => [21, 18, 67, 26, 30, 49],
    'Consuntivo' => [19, 20, 70, 30, 40, 61],
  ],
  //'PB' => [
  //  'Preventivo' => [10, 10, 10, 10, 10, 10],
  //  'Consuntivo' => [10, 10, 10, 10, 10, 10],
  //],
  //'CA' => [
  //  'Preventivo' => [00, 00, 00, 00, 00, 00],
  //  'Consuntivo' => [00, 00, 00, 00, 00, 00],
  //],
];
//$dati['Riepilogo'] = [
//  'Preventivo' => array_map(fn ($d) => array_sum($d), trasponi(array_column($dati, 'Preventivo'))),
//  'Consuntivo' => array_map(fn ($d) => array_sum($d), trasponi(array_column($dati, 'Consuntivo'))),
//];

$txt = implode(
  "\n",
  array_map(
    fn ($val, $key) => tabella(
      $key,
      array_map(
        fn ($r, $c, $p) => $r($p, $c),
        $ruoli,
        $val['Consuntivo'],
        $val['Preventivo'],
      )
    ),
    $dati,
    array_keys($dati)
  )
);

//echo 'PHP: preprocessing del consuntivo' . "\n";
//file_put_contents('out.tex', $txt);
echo $txt;

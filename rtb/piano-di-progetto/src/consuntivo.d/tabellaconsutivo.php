<?php

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

function tabella($data) {
  $data[] = [
    'Ruolo' => 'Totale',
    'Ore preventivate (h)'   => array_sum(array_column($data, 'Ore preventivate (h)')),
    'Ore effettive (h)'      => array_sum(array_column($data, 'Ore effettive (h)')),
    'Costi preventivati (€)' => array_sum(array_column($data, 'Costi preventivati (€)')),
    'Costi effettivi (€)'    => array_sum(array_column($data, 'Costi effettivi (€)')),
    'Differenze'             => array_sum(array_column($data, 'Differenze')),
  ];

  foreach ($data as $i => &$v) {
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

  return str_replace('<TABELLA>', $data, <<<EOF

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


EOF);
}


echo tabella([
  ($responsabile   = ruolo('Responsabile',     30))(21, 19),
  ($amministratore = ruolo('Amministratore',   20))(18, 20),
  ($analista       = ruolo('Analista',         25))(67, 70),
  ($progettista    = ruolo('Progettista',      25))(26, 30),
  ($programmatore  = ruolo('Programmatore',    15))(30, 40),
  ($verificatore   = ruolo('Verificatore',     15))(49, 61),
]);

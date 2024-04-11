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

function multireplace($args, $txt) {
  return str_replace(array_keys($args), $args, $txt);
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


// \subsection{Analisi e RTB}
// \input{src/consuntivo.d/1-rtb.tex}
$txt =
  tabella('Analisi e RTB', [
    ($responsabile   = ruolo('Responsabile',     30))(21, 19),
    ($amministratore = ruolo('Amministratore',   20))(18, 20),
    ($analista       = ruolo('Analista',         25))(67, 70),
    ($progettista    = ruolo('Progettista',      25))(26, 30),
    ($programmatore  = ruolo('Programmatore',    15))(30, 40),
    ($verificatore   = ruolo('Verificatore',     15))(49, 61),
  ]);

// % \subsection{PB}
// % \input{src/consuntivo.d/2-pb.tex}
$txt .=
  tabella('PB', [
    $responsabile(0, 0),
    $amministratore(0, 0),
    $analista(0, 0),
    $progettista(0, 0),
    $programmatore(0, 0),
    $verificatore(0, 0),
  ]);

// % \subsection{CA}
// % \input{src/consuntivo.d/3-ca.tex}
$txt .=
  tabella('CA', [
    $responsabile(0, 0),
    $amministratore(0, 0),
    $analista(0, 0),
    $progettista(0, 0),
    $programmatore(0, 0),
    $verificatore(0, 0),
  ]);

// % \subsection{Riepilogo}
// % \input{src/consuntivo.d/4-riepilogo.tex}
$txt .=
  tabella('Riepilogo', [
    $responsabile(0, 0),
    $amministratore(0, 0),
    $analista(0, 0),
    $progettista(0, 0),
    $programmatore(0, 0),
    $verificatore(0, 0),
  ]);

echo $txt;

file_put_contents('out.tex', $txt);

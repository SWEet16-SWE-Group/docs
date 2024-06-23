<?php

require_once __DIR__ . '/../pianificazione.d/pb.php';
require_once __DIR__ . '/../pianificazione.d/rtb.php';

$rtb_somma_preventivi = somma3d(array_column($periodi_rtb, preventivo), membri(), range(0, 5));
$rtb_somma_consuntivi = somma3d(array_column($periodi_rtb, consuntivo), membri(), range(0, 5));

$pb_somma_preventivi = somma3d(array_column($periodi_pb, preventivo), membri(), range(0, 5));
$pb_somma_consuntivi = somma3d(array_column($periodi_pb, consuntivo), membri(), range(0, 5));

function differenze_soldi($p, $c) {
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

function consuntivo_latex($t, $a) {

  return str_replace_array(
    [
      '<TITOLO>' => $t,
      '<TABELLA>' => $a,
    ],
    <<<'EOF'

    \subsection{<TITOLO>}

    \subsubsection{Costi}

    \begin{tblr}{
    colspec={X[3cm]|X[2.5cm]|X[2.5cm]|X[1.5cm]|X[1.5cm]|X[2cm]},
    row{odd}={bg=white},
    row{even}={bg=lightgray},
    row{1}={bg=black,fg=white},
    row{8}={bg=black,fg=white}
    }

    <TABELLA>
      
    \end{tblr}

    \subsubsection{Resoconto}

    Si veda la retrospettiva nella sezione di Pianificazione.

    EOF
  );
}

function calcola_somme_to_string($a, $b) {
  return tabella_to_string(formatta_tabella_soldi_colonne(formatta_tabella(differenze_soldi($a, $b)), [3, 4, 5]));
}

echo consuntivo_latex('RTB', calcola_somme_to_string($rtb_somma_preventivi, $rtb_somma_consuntivi));
echo consuntivo_latex( 'PB', calcola_somme_to_string( $pb_somma_preventivi,  $pb_somma_consuntivi));

return;

ob_end_clean();

function ts($a){
  $a = explode("\n", $a);
  $a = array_map(fn ($a) => explode(" & ", $a), $a);
  $a = array_map(fn ($a) => array_map(fn ($a) => sprintf('%10s',$a),$a),$a);
  foreach($a as &$b){$b[0] = sprintf('%20s',$b[0]);}
  $a = array_map(fn ($a) => implode(" & ", $a), $a);
  $a = implode("\n", $a);
  return $a;
}

$b = tabella_to_string(formatta_tabella(tabella_ore(somma3d([$rtb_somma_consuntivi, $pb_somma_consuntivi],membri(), range(0, 5)))));
$b = ts($b);

echo "\n\n\nsomma totale:\n\n$b\n\n";
die();

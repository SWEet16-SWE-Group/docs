<?php

class Attivita {
  private function __construct(public $nome, public $inizio, public $fine, public $class, public $tag) {
  }
  public static function Macro($nome, $inizio, $figli) {
    $figli = array_merge(...array_map(fn ($a) => $a($inizio), $figli));
    return [
      new Attivita(
        $nome,
        $inizio,
        DateTime::createFromFormat('Y-m-d', max(array_map(fn ($a) => $a->fine->format('Y-m-d'), $figli))),
        'macro',
        'th',
      ),
      ...$figli
    ];
  }
  public static function Micro($nome, $fine, $figli) {
    return fn ($inizio) => array_merge(
      [new Attivita($nome, $inizio, $fine, 'micro', 'td')],
      ...array_map(fn ($micro) => $micro($fine->add(new DateInterval('P1D'))), $figli),
    );
  }
}

function array_group($f, $a) {
  $b = [];
  foreach ($a as $v) {
    $k = $f($v);
    if (!array_key_exists($k, $b)) {
      $b[$k] = [];
    }
    $b[$k][] = $v;
  }
  return $b;
}

function stampablocco($a, $d) {
  $tag = "td";
  return match (true) {
    $a->inizio->format('Y-m-d') == $d->format('Y-m-d') and
      $a->fine->format('Y-m-d') == $d->format('Y-m-d') => "<$tag class='singolo {$a->class}'></$tag>",
    $a->inizio->format('Y-m-d') == $d->format('Y-m-d') => "<$tag class='inizio  {$a->class}'></$tag>",
    $a->fine->format('Y-m-d') == $d->format('Y-m-d')   => "<$tag class='fine    {$a->class}'></$tag>",
    $a->inizio < $d and $d < $a->fine                  => "<$tag class='centro  {$a->class}'></$tag>",
    default                                            => "<$tag class='vuoto'></$tag>",
  };
}

function colonna0($a) {
  return "<{$a->tag} class='attivita'>{$a->nome}</{$a->tag}>";
}

function gantt($attivita) {
  $attivita = array_merge(...$attivita);
  $inizio = DateTime::createFromFormat('Y-m-d', min(array_map(fn ($a) => $a->inizio->format('Y-m-d'), $attivita)));
  $fine   = DateTime::createFromFormat('Y-m-d', max(array_map(fn ($a) =>   $a->fine->format('Y-m-d'), $attivita)));

  $datarange = array_map(
    fn ($a) => (new DateTime())->add(new DateInterval("P{$a}D")),
    range(0, $inizio->diff($fine)->format('%a'))
  );

  $ndate = count($datarange);

  $anni = array_group(fn ($d) => $d->format('Y'), $datarange);
  $anni = array_map(fn ($a) => sprintf('<th colspan="%d">%s</th>', count($anni[$a]), $a), array_keys($anni));
  $anni = implode('', $anni);

  $mesi = array_group(fn ($d) => $d->format('Y-m'), $datarange);
  $mesi = array_map(fn ($a) => sprintf('<th colspan="%d">%s</th>', count($mesi[$a]), DateTime::createFromFormat('Y-m', $a)->format('m')), array_keys($mesi));
  $mesi = implode('', $mesi);

  $giorni = implode('', array_map(fn ($d) => "<th>{$d->format('d')}</th>", $datarange));
  $tbody = implode("\n", array_map(fn ($a) => '<tr>' . colonna0($a) . implode('', array_map(fn ($d) => stampablocco($a, $d), $datarange)) . '</tr>', $attivita));

  return <<<EOF
    <table>
      <thead>
        <tr>
          <th rowspan="4" style="width: 180px">Attività</th>
          <th colspan="{$ndate}">Tempo</th>
        </tr>
        <tr>
          {$anni}
        </tr>
        <tr>
          {$mesi}
        </tr>
        <tr>
          {$giorni}
        </tr>
      </thead>
      <tbody>
        {$tbody}
      </tbody>
    </table>
  EOF;
}

function now() {
  return new DateTimeImmutable();
}

$gantt = gantt([
  Attivita::Macro('s', now(), [
    Attivita::Micro('s1', (now())->add(new DateInterval('P0D')), [
      Attivita::Micro('s11', (now())->add(new DateInterval('P2D')), []),
      Attivita::Micro('s12', (now())->add(new DateInterval('P2D')), [
        Attivita::Micro('s121', (now())->add(new DateInterval('P3D')), []),
        Attivita::Micro('s122', (now())->add(new DateInterval('P3D')), []),
        Attivita::Micro('s123', (now())->add(new DateInterval('P3D')), []),
      ]),
      Attivita::Micro('s2', (now())->add(new DateInterval('P1D')), []),
    ])
  ]),
  Attivita::Macro('y', now(), [
    Attivita::Micro('y1', now()->add(new DateInterval('P4D')), [])
  ])
]);

?>
<!DOCTYPE html>
<html>

<head>
  <style>
    table {
      width: 100%;
      height: 100%;
      border-spacing: 0px;
      border-right: solid 1px black;
    }

    th,
    td.attivita {
      border: solid 1px black;
    }

    td.attivita {
      text-align: right;
      padding-right: 10px;
    }

    td.vuoto,
    td.singolo,
    td.inizio {
      border-left: solid 1px black;
    }

    td.vuoto,
    td.singolo,
    td.fine {
      border-right: solid 1px black;
    }

    td.macro,
    td.micro {
      border-top: solid 1px black;
      border-bottom: solid 1px black;
    }

    td.macro {
      background-color: lightblue;
    }

    td.micro {
      background-color: lightcyan;
    }
  </style>
</head>

<body>

  <?php echo $gantt; ?>

</body>

</html>

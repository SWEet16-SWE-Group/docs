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

  $html = [
    'tbody' => array_map(fn ($a) => '<tr>' . colonna0($a) . implode(array_map(fn ($d) => stampablocco($a, $d), $datarange)) . '</tr>', $attivita),
  ];

  return implode("\n", $html['tbody']);
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
    ])
  ]),
]);

?>
<!DOCTYPE html>
<html>

<head>
  <style>
    table {
      width: 100%;
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

  <table>
    <thead>
      <tr>
        <th rowspan="4" style="width: 180px;">
          Attività
        </th>
        <th colspan="14">
          Tempo
        </th>
      </tr>
      <tr>
        <th colspan="14">2024</th>
      </tr>
      <th colspan="3">05</th>
      <th colspan="11">06</th>
      <tr>
        <?php echo implode('', array_map(fn ($a) => "<th>$a</th>", [...range(29, 31), 1]));
        ?>
      </tr>
    </thead>

    <tbody>
      <?php echo $gantt; ?>
    </tbody>
  </table>

</body>

</html>

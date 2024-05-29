<?php

class Attivita {
  private function __construct(public $nome, public $inizio, public $fine, public $class) {
  }
  public static function Macro($nome, $inizio, $figli) {
    $figli = array_merge(...array_map(fn ($a) => $a($inizio), $figli));
    return [
      new Attivita(
        $nome,
        $inizio,
        DateTime::createFromFormat('Y-m-d', max(array_map(fn ($a) => $a->fine->format('Y-m-d'), $figli))),
        'macro',
      ),
      ...$figli
    ];
  }
  public static function Micro($nome, $fine, $figli) {
    return fn ($inizio) => array_merge(
      [new Attivita($nome, $inizio, $fine, 'micro')],
      ...array_map(fn ($micro) => $micro($fine), $figli),
    );
  }
}


function stampablocco($a, $d) {
  return match (true) {
    $a->inizio->format('Y-m-d') == $d->format('Y-m-d') => "<td class='inizio {$a->class}'></td>",
    $a->fine->format('Y-m-d') == $d->format('Y-m-d')   => "<td class='fine   {$a->class}'></td>",
    $a->inizio < $d and $d < $a->fine                  => "<td class='centro {$a->class}'></td>",
    default                                            => "<td></td>",
  };
}

function gantt($attivita) {
  $attivita = array_merge(...$attivita);
  $inizio = DateTime::createFromFormat('Y-m-d', min(array_map(fn ($a) => $a->inizio->format('Y-m-d'), $attivita)));
  $fine   = DateTime::createFromFormat('Y-m-d', max(array_map(fn ($a) =>   $a->fine->format('Y-m-d'), $attivita)));

  $datarange = array_map(
    fn ($a) => (new DateTime())->add(new DateInterval("P{$a}D")),
    range(0, $inizio->diff($fine)->format('%a'))
  );
  //$attivita = array_merge(
  //  array_map(
  //    fn ($a) => [new Attivita()],
  //    $attivita
  //  )
  //);

  return [
    $datarange,
    array_map(fn ($a) => array_map(fn ($d) => stampablocco($a, $d),  $datarange), $attivita)
  ];
}


print_r(
  gantt(
    [
      Attivita::Macro('s', new DateTime(), [
        Attivita::Micro('s1', (new DateTime())->add(new DateInterval('P1D')), [
          Attivita::Micro('s11', (new DateTime())->add(new DateInterval('P2D')), []),
          Attivita::Micro('s12', (new DateTime())->add(new DateInterval('P2D')), [
            Attivita::Micro('s121', (new DateTime())->add(new DateInterval('P3D')), []),
            Attivita::Micro('s122', (new DateTime())->add(new DateInterval('P3D')), []),
            Attivita::Micro('s123', (new DateTime())->add(new DateInterval('P3D')), []),
          ]),
        ])
      ])
    ]
  )
);

die();

?>
<hmtl>

  <head>
    <style>
      .gantt_time {
        display: flex;
        flex-direction: row;
        gap: 10px;
      }

      .gantt_time p {
        border: solid 1px red;
      }

      table {
        width: 100%;
      }

      th,
      td {
        border: solid 1px black;
      }


      th.h {
        margin-top: 6px;
      }

      td.subact {
        text-align: right;
      }

      table {
        border-spacing: 0px;
      }
    </style>
  </head>

  <body>

    <table>
      <thead>
        <tr>
          <th rowspan="4">
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
          <?php //echo gantt_time(); 
          ?>
        </tr>
      </thead>
      <tbody>
        <?php //echo gantt_attivita(attivita); 
        ?>
      </tbody>
    </table>

    <div class="gantt">
      <div class="gantt_attivita">
      </div>
    </div>

  </body>

</hmtl>

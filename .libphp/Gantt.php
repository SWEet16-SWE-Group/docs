<?php

require_once __DIR__ . '/Utils.php';

const dateformat = 'Y/m/d';

class Attivita {
  private function __construct(public $nome, public $inizio, public $fine, public $class, public $tag) {
  }
  public static function Macro($nome, $inizio, $figli) {
    $inizio = DateTimeImmutable::createFromFormat(dateformat, $inizio);
    $figli = array_merge(...array_map(fn ($a) => $a($inizio), $figli));
    return [
      new Attivita(
        $nome,
        $inizio,
        DateTime::createFromFormat(dateformat, max(array_map(fn ($a) => $a->fine->format(dateformat), $figli))),
        'macro',
        'th',
      ),
      ...$figli
    ];
  }
  public static function Micro($nome, $fine, $figli) {
    $fine = DateTimeImmutable::createFromFormat(dateformat, $fine);
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
    $a->inizio->format(dateformat) == $d->format(dateformat) and
      $a->fine->format(dateformat) == $d->format(dateformat) => "<$tag class='singolo {$a->class}'></$tag>",
    $a->inizio->format(dateformat) == $d->format(dateformat) => "<$tag class='inizio  {$a->class}'></$tag>",
    $a->fine->format(dateformat) == $d->format(dateformat)   => "<$tag class='fine    {$a->class}'></$tag>",
    $a->inizio < $d and $d < $a->fine                  => "<$tag class='centro  {$a->class}'></$tag>",
    default                                            => "<$tag class='vuoto'></$tag>",
  };
}

function colonna0($a) {
  return "<{$a->tag} class='attivita'>{$a->nome}</{$a->tag}>";
}

function gantt($attivita) {
  $attivita = array_merge(...$attivita);
  $inizio = DateTimeImmutable::createFromFormat(dateformat, min(array_map(fn ($a) => $a->inizio->format(dateformat), $attivita)));
  $fine   = DateTimeImmutable::createFromFormat(dateformat, max(array_map(fn ($a) =>   $a->fine->format(dateformat), $attivita)));

  $datarange = array_map(
    fn ($a) => $inizio->add(new DateInterval("P{$a}D")),
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
          <th rowspan="4" class="altosinistra">Attività</th>
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

function gantt_html($ganttstruct) {
  try {
    ob_start();
?>
    <!DOCTYPE html>
    <html>

    <head>
      <style>
        html,
        body {
          width: 100%;
          height: 100%;
          margin: 0px;
          padding: 0px;
        }

        table {
          width: 100%;
          height: 100%;
          border-spacing: 0px;
          border: solid 1px black;
        }

        th.altosinistra,
        th.attivita {
          width: 180px;
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

      <?php echo gantt($ganttstruct); ?>

    </body>

    </html>

<?php

    return ob_get_contents();
  } finally {
    ob_end_clean();
  }
}

function gantt_test() {

  $ganttstruct = [
    Attivita::Macro('s',            '2024/05/16', [
      Attivita::Micro('s1',         '2024/05/17', [
        Attivita::Micro('s11',      '2024/05/18', []),
        Attivita::Micro('s12',      '2024/05/18', [
          Attivita::Micro('s121',   '2024/05/19', []),
          Attivita::Micro('s122',   '2024/05/22', []),
          Attivita::Micro('s123',   '2024/05/21', []),
        ]),
        Attivita::Micro('s2',       '2024/05/28', []),
      ])
    ]),
    Attivita::Macro('y',            '2024/05/27', [
      Attivita::Micro('y1',         '2024/06/03', []),
      Attivita::Micro('y1',         '2024/06/03', []),
      Attivita::Micro('y1',         '2024/06/03', []),
      Attivita::Micro('y1',         '2024/06/07', []),
      Attivita::Micro('y1',         '2024/06/07', []),
      Attivita::Micro('y1',         '2024/06/07', []),
    ])
  ];

  $gantt = gantt_html($ganttstruct);

  // print_r($ganttstruct);

  // print_r($gantt);

  //echo gantt_html($ganttstruct);

  print_r($gantt);

  die();
}
gantt_test();

function gantt_latex($img, $ganttstruct, $size) {
  if (!_compile()) {
    return '';
  }
  $htmlfile = mediapath() . '/gantt.html';
  file_put_contents($htmlfile, gantt_html($ganttstruct));
  passthru(sprintf("firefox --headless --screenshot --window-size %s 'file://%s'", $size, $htmlfile));
  is_dir($dir = dirname($img)) or mkdir($dir, recursive: true);
  rename('screenshot.png', mediapath() . "/$img");
  unlink($htmlfile);
  return "\\begin{figure}[h!] \\includegraphics[scale=.7]{{$img}} \\end{figure}";
}

<?php

require_once __DIR__ . '/Utils.php';

const DX = [0, 0, 1];
const CE = [0, 1, 0];
const SX = [1, 0, 0];

class RegistroModifiche {
  private $tabella = [];
  private function log($incremento, $data, $autore, $verificatore, $descrizione) {
    $this->tabella[] = [$incremento, $data, $autore, $verificatore, $descrizione];
    return $this;
  }

  public function logArray($a) {
    return _reduce(fn ($t, $a) => $t->log(...$a), $this)($a);
  }

  public function __toString() {
    return array_reduce(
      $this->tabella,
      function ($t, $a) {
        $t->versione = match ($a[0]) {
          [0, 0, 1] => [$t->versione[0], $t->versione[1], $t->versione[2] + 1],
          [0, 1, 0] => [$t->versione[0], $t->versione[1] + 1, 0],
          [1, 0, 0] => [$t->versione[0] + 1, 0, 0],
        };
        $a[0] = implode('.', $t->versione);
        $a = array_map('trim', $a);
        $t->testo = implode(" & ", $a) . " \\\\ \\hline\n" . $t->testo;
        return $t;
      },
      (object)['versione' => [0, 0, 0], 'testo' => '']
    )->testo;
  }
  public function latex() {
    return str_replace_array([
      'REGISTRO' => (string) $this,
    ], <<<'EOF'
    \begin{huge}
    \textbf{Registro delle modifiche}
    \end{huge}
    \vspace{5pt}

    \begin{tblr}{
    colspec={|X[1.5cm]|X[2cm]|X[2.5cm]|X[2.5cm]|X[5cm]|},
    row{odd}={bg=white},
    row{even}={bg=lightgray},
    row{1}={bg=black,fg=white}
    }

    Versione & Data & Autore & Verificatore & Descrizione \\ \hline
    REGISTRO
    \end{tblr}
    EOF);
  }
  public function versione() {
    $c = array_column($this->tabella, 0);
    $c = array_reduce($c, fn ($a, $b) => match ($b) {
      [0, 0, 1] => [$a[0], $a[1], $a[2] + 1],
      [0, 1, 0] => [$a[0], $a[1] + 1, 0],
      [1, 0, 0] => [$a[0] + 1, 0, 0],
    }, [0, 0, 0]);
    return vsprintf('%d.%d.%d', $c);
  }

  private function select_column($key) {
    $a = array_column($this->tabella, $key);
    $a = array_map('trim', $a);
    $a = array_filter($a, fn ($a) => strlen($a) > 0);
    sort($a);
    return implode(", ", array_unique($a));
  }
  public function autori() {
    return $this->select_column(2);
  }
  public function verificatori() {
    return $this->select_column(3);
  }
};

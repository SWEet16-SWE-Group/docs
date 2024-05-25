<?php

function str_replace_array($a, $s) {
  return str_replace(array_keys($a), $a, $s);
}

class RegistroModifiche {
  private $tabella = [];
  private function log($incremento, $data, $autore, $verificatore, $descrizione) {
    $this->tabella[] = [$incremento, $data, $autore, $verificatore, $descrizione];
    return $this;
  }
  public function dlog($data, $autore, $verificatore, $descrizione) {
    return $this->log([0, 0, 1], $data, $autore, $verificatore, $descrizione);
  }
 public function clog($data, $autore, $verificatore, $descrizione) {
    return $this->log([0, 1, 0], $data, $autore, $verificatore, $descrizione);
  }
  public function slog($data, $autore, $verificatore, $descrizione) {
    return $this->log([1, 0, 0], $data, $autore, $verificatore, $descrizione);
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
        $t->testo .= implode(" & ", $a) . " \\\\ \\hline\n";
        return $t;
      },
      (object)['versione' => [0, 0, 0], 'testo' => '']
    )->testo;
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

  public function autori() {
    $a = array_column($this->tabella, 2);
    sort($a);
    return implode(", ", array_unique($a));
  }

  public function verificatori() {
    $a = array_column($this->tabella, 3);
    sort($a);
    return implode(", ", array_unique($a));
  }
};


$titolo = 'TITOLO';
$pathsimmagini = [
  '../media/',
];

$registro = (new RegistroModifiche())
  ->dlog('', '', '', '')
  ->dlog('', '', '', '')
  ->dlog('', '', '', '')
  ->dlog('', '', '', '')
  ->clog('', '', '', '')
  ->dlog('', '', '', '')
  ->dlog('', '', '', '')
  ->dlog('', '', '', '')
  ->dlog('', '', '', '')
  ->clog('', '', '', '')
  ->slog('', '', '', '');

ob_start();
ob_start(function ($tex) use ($registro) {
  return $tex;
});
?>
\nonstopmode
\documentclass[a4paper, 11pt]{article}
\usepackage{graphicx} % Required for inserting images
\usepackage{amsmath}
\usepackage{geometry}
\usepackage{hyperref}
\usepackage{setspace}
\usepackage{array}
\usepackage[usenames,dvipsnames]{xcolor}
\usepackage{colortbl}
\usepackage{tabularray}
\usepackage[italian]{babel}

\geometry{
a4paper,
left=25mm,
right=25mm,
top=20mm,
bottom=20mm,
}

\setlength{\parskip}{1em}
\setlength{\parindent}{0pt}
\graphicspath{<?php echo implode('', array_map(fn ($a) => "\{$a\}", $pathsimmagini)); ?>}

\begin{document}

\begin{minipage}{0.35\linewidth}
\includegraphics[width=\linewidth]{Logo_Università_Padova.svg.png}
\end{minipage}\hfil
\begin{minipage}{0.55\linewidth}
\textbf{Università degli Studi di Padova} \\
Laurea in Informatica \\
Corso di Ingegneria del Software \\
Anno Accademico 2023/2024
\end{minipage}

\vspace{5mm}

\begin{minipage}{0.35\linewidth}
\includegraphics[width=\linewidth]{logo rotondo.jpg}
\end{minipage}\hfil
\begin{minipage}{0.55\linewidth}
\textbf{Gruppo:} SWEet16 \\
\textbf{Email:}
\href{mailto:sweet16.unipd@gmail.com}{\nolinkurl{sweet16.unipd@gmail.com}}
\end{minipage}

\vspace{15mm}

\begin{center}
\begin{Huge}
\textbf{<?php echo $titolo; ?>} \\
\vspace{4mm}

\end{Huge}

\vspace{20mm}

\begin{large}
\begin{spacing}{1.4}
\begin{tabular}{c c c}
Redattori: & <?php echo $registro->autori(); ?> & \\
Verificatori: & <?php echo $registro->verificatori(); ?> & \\
Amministratore: & AMMINISTRATORI & \\
Destinatari: & T. Vardanega & R. Cardin \\
Versione: & <?php echo $registro->versione(); ?> &
\end{tabular}
\end{spacing}
\end{large}
\end{center}

\pagebreak

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

Versione & Data & Autore & Verificatore & Descrizione \\
<?php echo $registro; ?>

\end{tblr}

\pagebreak
\tableofcontents
\pagebreak

\end{document}
<?php
ob_end_flush();
$tex = ob_get_contents();
ob_end_clean();

$opts = getopt('p');
if (array_key_exists('p', $opts)) {
  echo $tex;
} else {
  chdir(__DIR__);
  file_put_contents('main.tex', $tex);
}

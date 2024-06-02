<?php
set_include_path(__DIR__ . '/../../.libphp/');
require_once 'Utils.php';
require_once 'RegistroModifiche.php';
require_once 'Vocaboli.php';
require_once 'Validatore.php';
require_once 'Membri.php';

$error_flag = 0;
$titolo = 'Manuale utente';
$registro = (new RegistroModifiche())->logArray([
  [DX, '2024/06/01', alex_s(), '', 'Stesura scheletro'],
  //[SX, '2024/06/00', alex_s(), '', 'Approvazione per il rilascio'],
]);
$nome = "Manuale_utente_v{$registro->versione()}.pdf";

ob_start();
ob_start(function ($tex) use ($titolo, &$error_flag) {
  $errormsg = racatta_errori($titolo, $tex);
  if (strlen($errormsg) > 0) {
    $error_flag = 11;
    return $errormsg;
  }
  $tex = _valida_testo($tex);
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
\usepackage[usenames, dvipsnames]{xcolor}
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
\graphicspath{<?php echo includegraphics(); ?>}

\begin{document}

\begin{minipage}{0.35\linewidth}
\includegraphics[width=\linewidth]{logo_unipd.png}
\end{minipage}\hfil
\begin{minipage}{0.55\linewidth}
\textbf{Università degli Studi di Padova} \\
Laurea in Informatica \\
Corso di Ingegneria del Software \\
Anno Accademico 2023/2024
\end{minipage}

\vspace{5mm}

\begin{minipage}{0.35\linewidth}
\includegraphics[width=\linewidth]{logo_rotondo.jpg}
\end{minipage}\hfil
\begin{minipage}{0.55\linewidth}
\textbf{Gruppo}: SWEet16 \\
\textbf{Email}:
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
Amministratore: & <?php echo alberto_m(); ?> & \\
Destinatari: & T. Vardanega & R. Cardin \\
Versione: & <?php echo $registro->versione(); ?> &
\end{tabular}
\end{spacing}
\end{large}
\end{center}

\pagebreak

<?php echo $registro->latex(); ?>

\pagebreak
\tableofcontents
\pagebreak


<?php

$contenuti = [
  'Utente anonimo' => null,
  'Utente autenticato' => null,
  'Cliente' =>
  [
    'Navbar' =>
    [
      'Impostazioni account' => null,
      'Dashboard' => null,
      'Selezione allergeni' => null,
      'Ricerca dei ristoranti' =>
      [
        'Elenco dei ristoranti' => null,
        'Homepage del ristorante' => null,
        'Menù del ristorante' => null,
        'Form di prenotazione' => null,
      ],
      'Notifiche' => null,
    ],
    'Dashboard' =>
    [
      'Lista di prenotazioni' =>
      [
        'Attive' => null,
        'Scadute' => null,
      ],
      'Prenotazione' =>
      [
        'Ordinazioni collaborative' => null,
        'Manipolare un\'ordinazione' => null,
        'Effettuare pagamenti' => null,
        // 'Lasciare una recensione' => null,
      ],
    ],
  ],
  'Ristoratore' =>
  [
    'Navbar' =>
    [
      'Impostazioni account' => null,
      'Dashboard' => null,
      'Impostazioni menù' =>
      [
        'Manipolazione pietanze' => null,
      ],
      'Notifiche' => null,
    ],
    'Dashboard' =>
    [
      'Lista di prenotazioni' => null,
      'Prenotazione' =>
      [
        'Ordinazioni collaborative' => null,
        'Dettagli ordinazioni' => null,
        'Segna il pagamento di pietanze/clienti come effettuati' => null,
      ],
    ],
  ],
];

?>

\end{document}
<?php
ob_end_flush();
$tex = ob_get_contents();
ob_end_clean();

$opts = getopt('p');
if (array_key_exists('p', $opts) || $error_flag > 0) {
  echo $tex;
} else {
  chdir(__DIR__);
  file_put_contents('main.tex', $tex);
}
return $error_flag;

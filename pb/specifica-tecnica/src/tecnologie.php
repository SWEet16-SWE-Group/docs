<?php

function tabelle_tecnologie($subsubsection, $tabella) {
  return str_replace_array(
    [
      'SUB' => $subsubsection,
      'DATI' => implode('', array_map(fn ($a) => implode(" & ", $a) . '\\\\ \\hline' . "\n", $tabella)),
    ],
    <<<'EOF'
    \subsubsection{SUB}

    \begin{center}
    \begin{longtblr}{
    colspec={|X[c,2cm]|X[c,12cm]|X[c,2cm]|},
    row{odd}={bg=white},
    row{even}={bg=lightgray}
    }

    \hline
    \textbf{Tecnologia} & \textbf{Descrizione} & \textbf{Versione} \\ \hline

    DATI

    \end{longtblr}
    \end{center}
    
    EOF
  );
}

?>

\pagebreak

\section{Tecnologie}

In questa sezione viene fornita una panoramica generale delle tecnologie utilizzate per la
realizzazione del prodotto in questione. \\
Vengono infatti descritte le procedure, gli strumenti e le librerie necessari per lo sviluppo, il test e la distribuzione del prodotto.\\
In particolare, verranno trattate le tecnologie impiegate per la realizzazione del front-end e del back-end, per la gestione del
database e per l'integrazione con i servizi previsti.


\subsection{Tecnologie per la codifica}

<?php

echo tabelle_tecnologie(
  'Linguaggi',
  [
    ['HTML', 'Linguaggio di annotazione (markup) utilizzato per impostare la struttura delle singole pagine e definire gli elementi dell’interfaccia', '5'],
    ['CSS', 'Linguaggio utilizzato per la formattazione e la gestione dello stile degli elementi HTML', '3'],
    ['JavaScript', 'Linguaggio utilizzato per la gestione di eventi invocati dall\'utente', 'ECMAScript 2023'],
    ['PHP', 'Linguaggio per la codifica di applicazioni web lato server, utilizzato per la creazione di \emph{API Rest}$^{G}$', '8.x'],
  ]
);

echo  tabelle_tecnologie(
  'Librerie e framework',
  [
    ['ReactJs', 'Libreria grafica per facilitare lo sviluppo front-end gestendo modularmente le componenti grafiche, permettendo performance buone grazie all\'efficacia della sua renderizzazione', '18.2.x'],
    ['Laravel', 'Framework PHP utilizzato per facilitare la creazione di API Rest', '11'],
    ['Axios', 'Libreria JavaScript che viene utilizzata per effettuare richieste HTTP sia negli ambienti browser che Node.js', '11.x'],
  ]
);

echo tabelle_tecnologie(
  'Strumenti e servizi',
  [
    ['Node.js', 'Runtime system per esecuzione di codice Javascript', '20.11.0'],
    ['NPM', 'Gestore di pacchetti per il linguaggio JavaScript e l\'ambiente di esecuzione Node.js', '9.6.x'],
    ['Docker', 'Piattaforma di sviluppo e gestione di applicazioni che permette di creare, distribuire e eseguire in software in container virtualizzati', '24.0.7'],
    ['Git', 'Sistema di controllo di versione distribuito utilizzato per la gestione del codice sorgente dal parte del gruppo di progetto', '/'],
    ['Bootstrap', 'Libreria di strumenti liberi per la creazione di siti e applicazioni per il Web che contiene modelli di progettazione basati su HTML e CSS', '5.3.3'],
  ]
);

?>

\subsection{Tecnologie per l'analisi del codice}

<?php

echo tabelle_tecnologie(
  'Analisi statica',
  [
    ['Jest', 'Framework di test basato su JavaScript con funzionalità di creazione di mock e il testing del codice in modo asincrono.', '5.17'],
  ]
);

echo  tabelle_tecnologie(
  'Analisi dinamica',
  [
    ['React Testing Library', 'Libreria di test integrata nativamente che consente di testare il comportamento dei componenti React da una prospettiva degli utenti finali.', '13.4.0'],
    ['GitHub Actions', 'Servizio di CI/CD per automatizzare il processo di build, test e deploy del progetto software', '/'],
  ]
);

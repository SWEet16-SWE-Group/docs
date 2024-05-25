<?php

require_once __DIR__ . '/Stream.php';
require_once __DIR__ . '/Utils.php';

function _findoutliers($text) {
  return stream(
    preg('/.*?[^}]\$\^{G}\$.*?/', $text)[0],
    _filter(fn ($a) => !str_contains($a, 'La presenza di un termine all’interno del glossario viene indicata applicando una')),
  );
}

function findoutliers_file($file) {
  return stream(
    _findoutliers(file_get_contents($file))[0],
    _map(fn ($a) => ['file' => $file, 'context' => $a]),
  );
}

function findoutliers($files) {
  return stream(
    findoutliers_file($files),
    _filter(fn ($a) => count($a) > 0),
    _map(fn ($a) => $a[0]),
  );
}

function _findvocaboli($text) {
  return preg('/\\\\emph{(.*?)}\$\^{G}\$/', $text)[1];
}

function findvocaboli_file($file) {
  return _findvocaboli(file_get_contents($file))[1];
}

function findvocaboli($files) {
  return stream(
    findvocaboli_file($files),
    _filter(fn ($a) => count($a) > 0),
    _reduce(fn ($a, $b) => array_merge($a, $b), []),
    _map('ucfirst'),
    _sort(),
    _unique(),
  );
}

function _parse() {
  $parse = [
    'Ristoratori' => 'Ristoratore',
    'Clienti' => 'Cliente',
    'Coperti' => 'Coperto',
    'Ristoratori' => 'Ristoratore',
    'Prenotazioni' => 'Prenotazione',
    'Requisiti' => 'Requisito',
    'Requisiti funzionali' => 'Requisito funzionale',
    'Profili' => 'Profilo',
    'NextJs' => 'NextJS',
    'PoC' => 'PoC (Proof of Concept)',
    'Proof of Concept' => 'PoC (Proof of Concept)',
    'ITS' => 'ITS (Issue Tracking System)',
    'Express' => 'ExpressJS',
    '\\LaTeX' => 'LaTeX',
    'Capitolato d’appalto' => '',
    '' => '',
  ];
  return fn ($a) =>
  _filter(fn ($a) => strlen($a) > 0)(
    preg_replace(
      _map(fn ($a) => '/^' . preg_quote($a) . '$/')(array_keys($parse)),
      $parse,
      $a
    )
  );
}

const definizioni_glossario = [
  'Account' => "Insieme di credenziali e dati associati a un singolo utente che consente loro di accedere e interagire con i servizi offerti dalla piattaforma online.",
  'Back-end' => "Parte di un'applicazione o di un sistema informatico che gestisce e elabora i dati e le operazioni logiche lato server.",
  'Best practices' => "Approcci, metodologie o procedure che sono riconosciute come le più efficaci e efficienti per raggiungere un determinato obiettivo o risultato desiderato in un determinato contesto o settore. Queste pratiche sono solitamente identificate attraverso l'esperienza, la ricerca, l'analisi dei dati e l'osservazione delle prestazioni passate.",
  'Capitolato' => "Documento redatto dal proponente in cui vengono specificati i vincoli utente e vincoli tecnologici per lo sviluppo esplorativo di un determinato prodotto software. Serve ad esporre un problema, per cercare di trovarvi una soluzione.",
  'Carrello' => "Funzionalità che consente agli utenti di raccogliere e gestire i prodotti che desiderano acquistare durante la loro esperienza di ordinazione online.Le caratteristiche tipiche di un carrello virtuale sono l'aggiunta e rimozione di un prodotto, la modifica delle quantità, il calcolo del totale e il salvataggio temporaneo dei prodotti.",
  'Casi d’uso' => "Tecnica utilizzata nell'ambito dell'analisi dei requisiti del software per descrivere interazioni o scenari specifici tra gli utenti (attori) e un sistema software. I casi d'uso sono spesso documentati tramite diagrammi UML (Unified Modeling Language), che forniscono una rappresentazione visuale delle interazioni tra attori e sistema.",
  'Chat' => "Interazione testuale o multimediale in tempo reale tra due o più persone attraverso un'applicazione o una piattaforma online dedicata. Facilita la comunicazione immediata e sincrona, indipendentemente dalla distanza geografica.",
  'Cliente' => "Individuo o entità che utilizza un sito web, un'applicazione mobile o una piattaforma digitale per effettuare acquisti di beni o servizi forniti da un'azienda o un'organizzazione tramite il canale online.",
  'Consuntivo' => "Bilancio dei risultati ottenuti a rendiconto di un certo periodo temporale di attività, in termini di tempo e risorse.",
  'Continous delivery' => "Approccio di ingegneria del software in cui i team producono software in cicli brevi, assicurando che il software possa essere rilasciato in modo affidabile in qualsiasi momento in modo automatico.",
  'Conto' => "Documento cartaceo o elettronico che riepiloga i costi relativi ai pasti consumati e ai servizi forniti in un ristorante o in un locale simile.",
  'Coperto' => "Tariffa o al costo aggiuntivo che un ristorante può addebitare ai suoi clienti per l'uso del tavolo e dei servizi generali offerti. Questo costo può variare da un locale all'altro e può essere incluso nel prezzo del cibo o aggiunto separatamente al conto finale.",
  'Deployment' => "Processo di trasferimento di un'applicazione o di un sistema software da un ambiente di sviluppo o di test a un ambiente di produzione, in modo che sia disponibile per l'uso da parte degli utenti finali.",
  'Design' => "Processo di creazione, pianificazione e organizzazione di elementi in modo da raggiungere uno scopo specifico.",
  'Desktop' => "Area principale dell'interfaccia grafica del sistema operativo dove vengono visualizzate icone, file e altre risorse del computer. Fornisce un'organizzazione visiva degli elementi presenti sul computer e facilita l'accesso rapido alle risorse utili.",
  'Discord' => "Applicazione multipiattaforma di messaggistica istantanea basata su cloud che permette una facile comunicazione tra più individui tipicamente tramite chat di gruppo, in gergo chiamate server. Nei server è possibile creare e separare più canali testuali e vocali.",
  'Docker' => "Piattaforma open-source che facilita la creazione, la distribuzione e l'esecuzione di applicazioni all'interno di contenitori software. I contenitori Docker consentono di impacchettare un'applicazione e tutte le sue dipendenze in un'unica unità standardizzata, che include il codice, le librerie, le configurazioni e altre risorse necessarie per l'esecuzione dell'applicazione.",
  'ExpressJS' => "Framework web leggero, flessibile e minimalista per Node.js, un runtime JavaScript lato server. È ampiamente utilizzato per la creazione di applicazioni web e API (Application Programming Interface) utilizzando JavaScript sia lato server che lato client.",
  'Firefox' => "Browser web open-source sviluppato dalla Mozilla Corporation e da un vasto e globale team di volontari.",
  'Front-end' => "Parte di un'applicazione informatica, di un sito web o di un'applicazione mobile che interagisce direttamente con gli utenti e che è visibile e accessibile attraverso l'interfaccia utente.",
  'GitHub' => "Piattaforma di hosting di codice sorgente basata su Git, un sistema di controllo delle versioni distribuito. È ampiamente utilizzato dagli sviluppatori di software per collaborare, gestire progetti e condividere codice.",
  'Git' => "Sistema di controllo delle versioni distribuito (DVCS) creato da Linus Torvalds nel 2005 per gestire lo sviluppo del kernel Linux. Essenziale per gli sviluppatori software in quanto fornisce un modo efficace per gestire la storia del codice, collaborare con altri sviluppatori e tenere traccia delle modifiche nel tempo.",
  'Google Chrome' => "Browser web sviluppato da Google.",
  'Google Drive' => "Servizio web in ambiente cloud computing di memorizzazione e sincronizzazione online introdotto da Google.",
  'IDE' => "Software che offre agli sviluppatori un insieme completo di strumenti per scrivere, testare, debuggare e distribuire applicazioni software. Fornisce un ambiente di lavoro unificato che integra diversi strumenti e funzionalità utili per lo sviluppo di software, consentendo agli sviluppatori di lavorare più efficientemente e produttivamente.",
  'ITS (Issue Tracking System)' => "Software o applicazione utilizzata per registrare, gestire e monitorare le issue, i problemi e i compiti all'interno di un progetto. Fornisce un'infrastruttura organizzativa per tenere traccia delle richieste di funzionalità, dei bug, delle richieste di supporto e dei compiti assegnati, consentendo ai membri del team di sviluppo di collaborare in modo efficace e gestire il lavoro in corso.",
  'Ingredienti' => "Sostanze o componenti di origine naturale o sintetica utilizzate nella preparazione di cibo o di altre sostanze chimiche o composti.",
  'Issue' => "Registrazione di un problema, una richiesta di funzionalità o un compito specifico che deve essere affrontato durante il ciclo di sviluppo di un progetto.",
  'LaTeX' => "Linguaggio di markup e sistema di preparazione di documenti potente e flessibile, ampiamente utilizzato per la produzione di documenti tecnici e scientifici di alta qualità.",
  'Label' => "Feature offerta da GitHub per organizzare e cercare più facilmente un insieme di più issue.",
  'Mobile' => "Dispositivi informatici che sono progettati per essere portatili e utilizzati in movimento, quali smartphone, tablet e altri dispositivi simili che consentono agli utenti di accedere a internet, utilizzare applicazioni e svolgere una vasta gamma di attività digitali ovunque si trovino.",
  'Modello a V' => "Modello di sviluppo software che prende il nome dalla sua forma a 'V' quando viene visualizzato graficamente. Questo modello è una rappresentazione del processo di sviluppo del software che mostra le fasi di sviluppo e i test correlati, organizzati in una struttura a forma di V. Utilizzato in progetti software in cui è richiesta una pianificazione dettagliata e una forte enfasi sulla verifica e sulla validazione del software.",
  'NextJS' => "Framework open-source di React per lo sviluppo di applicazioni web front-end e full-stack. È progettato per semplificare e velocizzare il processo di creazione di applicazioni web moderne, fornendo strumenti e funzionalità avanzate integrate.",
  'Ordinazione' => "Processo di richiesta e acquisizione di beni o servizi da un'organizzazione, un'azienda o un fornitore. Questo processo coinvolge solitamente un cliente che seleziona i prodotti o i servizi desiderati e li richiede al fornitore o al venditore, specificando eventuali dettagli aggiuntivi come quantità, varianti o preferenze.",
  'Pietanze' => "Porzioni di cibo preparate per essere consumate come pasto o come parte di un pasto.",
  'PoC (Proof of Concept)' => "Realizzazione incompleta o abbozzata di un determinato progetto, per provare la fattibilità di idee costituite e tecnologie presenti nel progetto, sulla base di principi/concetti usati come fondamento. Si intende l’idea di prototipo, usato come oggetto di studio.",
  'Prenotazione' => "Processo attraverso il quale i clienti fissano in anticipo un tavolo per consumare un pasto presso un ristorante in una data e un'ora specifiche. Le prenotazioni sono comunemente utilizzate nei ristoranti per garantire ai clienti un posto al momento desiderato e per consentire al ristorante di pianificare e organizzare il servizio in modo efficace. La prenotazione si compone delle seguenti fasi: richiesta di prenotazione, verifica della disponibilità, conferma della prenotazione, arrivo e assegnazione del tavolo.",
  'Profilo' => "Insieme delle informazioni relative a un singolo utente che vengono memorizzate e gestite da un'applicazione o da un servizio. Queste informazioni possono includere dati personali, preferenze, cronologia degli acquisti, attività passate e altro ancora.",
  'Proponente' => "Azienda o ente che propone il capitolato d’appalto per il progetto didattico.",
  'Pull request' => "Funzionalità comune nei sistemi di controllo delle versioni, come Git e GitHub, utilizzata per richiedere la revisione e l'integrazione delle modifiche apportate a un repository di codice sorgente.",
  'RTB' => "Insieme di documenti e informazioni chiave che stabiliscono i requisiti e le basi tecnologiche per un progetto specifico, fornendo una chiara base di partenza e una guida per tutto lo sviluppo.",
  'Requisito funzionale' => "Specifica di ciò che un sistema software deve fare o delle funzionalità che deve possedere per soddisfare le esigenze degli utenti, dei clienti o degli stakeholder.",
  'Requisito' => "Specifica, istanza di un servizio o caratteristica che è necessaria o desiderata per soddisfare un obiettivo o risolvere un problema.",
  'Ristoratore' => "Individuo o un imprenditore che gestisce un ristorante o un'attività di ristorazione.",
  'SSL/TLS' => "Protocolli crittografici utilizzati per garantire la sicurezza delle comunicazioni su Internet, in particolare durante lo scambio di dati sensibili tra un client e un server. Forniscono un'infrastruttura crittografica per la protezione della privacy e dell'integrità dei dati durante la trasmissione su una rete, come ad esempio la navigazione web o l'invio di email.",
  'SaaS (Software as a Service)' => "Modello di distribuzione del software in cui le applicazioni sono ospitate su cloud da un provider di servizi e rese disponibili agli utenti attraverso Internet. Gli utenti possono accedere al software tramite un browser web o un'interfaccia utente, senza dover installare o mantenere l'applicazione sul proprio dispositivo.",
  'Safari' => "Browser web sviluppato da Apple Inc.",
  'Telegram' => "Applicazione multipiattaforma di messaggistica istantanea basata su cloud che permette una facile comunicazione con gruppi e canali, organizzando la comunicazione sulla base di strumenti e funzionalità automatiche offerte (bot), condividendo facilmente file e messaggi in un canale unico di comunicazione.",
  'UML' => "UML è l'acronimo di Unified Modeling Language (Linguaggio di Modellazione Unificato). Si tratta di un linguaggio standardizzato per la modellazione e la documentazione dei sistemi software. Fornisce un insieme di notazioni grafiche e simboli che consentono agli sviluppatori di visualizzare, progettare e comunicare le diverse aspetti di un sistema software in modo chiaro e conciso.",
  'Way of Working' => "Terminologia che indica il modo di lavorare adottato, da un punto di vista di strumenti, attività e tecnologie, determinato in modo quantificabile e misurato.",
  'Webapp' => "Programma applicativo memorizzato su un server remoto e distribuito su Internet attraverso un'interfaccia browser.",
  'Webinar' => "Sessione educativa o informativa la cui partecipazione avviene in forma remota tramite una connessione a internet.",
  'WhatsApp' => "Applicazione multipiattaforma di messaggistica istantanea basata su cloud che che consente agli utenti di inviare messaggi di testo, immagini, video, documenti e messaggi vocali a singoli o a gruppi tramite Internet.",
];

function print_vocaboli() {
  return stream(
    array_keys(definizioni_glossario),
    _map(fn ($a) => '\\subsection{' . $a . '}' . definizioni_glossario[$a] . "\n"),
    _sort(),
    _implode(""),
  );
}

function die_if_outliers($text) {
  if (count($outliers = _findoutliers($text)) > 0) {
    echo "\n\nQuesti vocaboli devono essere definiti con \\empf{VOCABOLO}$^{G}$\n";
    echo stream(
      $outliers,
      _map(fn ($a) => "\t$a\n"),
      _implode(''),
    );
    die(12);
  }
}

function die_if_vocaboli_non_definiti($text) {
  $missing = stream(
    _findvocaboli($text),
    _filter(fn ($a) => !array_key_exists($a, definizioni_glossario)),
    _map(fn ($a) => "\t$a\n"),
    _implode(''),
  );
  if (strlen($missing) > 0) {
    echo "\n\nMancano le definizioni dei sequenti vocaboli:\n";
    echo $missing;
    die(11);
  }
}

\subsubsection{Primo periodo}
Inizio: 2023/11/08 \\
Fine: 2023/11/24 \\

<?php

require_once __DIR__ . '/pb.php';

echo tabelle_ore_soldi_tostring($periodi_rtb, 0, preventivo);

?>

\paragraph{Attività svolte}
\subparagraph{}
Le attività svolte dai membri del gruppo nel primo periodo sono state:

\begin{itemize}
\item Concepimento della prima versione del \emph{Way of Working}$^{G}$;
\item Ricerca bibliografica finalizzata a costruire il body of knowledge necessario alla comprensione della documentazione che dovrà essere prodotta nella fase di RTB;
\item Studio dei seguenti documenti:
\begin{itemize}
\item ISO/IEC 12207: Processi del ciclo di vita del software;
\item ISO/IEC TR 19759: Software Engineering - Guide to the Software Engineering Body of Knowledge;
\item IEEE 830: Pratiche raccomandate per la specifica dei requisiti software.
\end{itemize}
\item Ricerca delle tecnologie potenzialmente adatte ad essere incluse nello stack tecnologico e loro studio;
\item Individuazione delle tecnologie di supporto nella produzione di documenti;
\item Individuazione delle tecnologie di supporto nel versionamento dei documenti e del codice prodotto successivamente durante la codifica del \emph{PoC}$^{G}$.
\end{itemize}

\begin{figure}[H] \includegraphics[scale=.6]{GanttPrimoPeriodo.png} \end{figure}

<?php

echo tabelle_ore_soldi_tostring($periodi_rtb, 0, consuntivo);

?>

\pagebreak

\paragraph{Gestione dei ruoli}
\paragraph{}
In questo primo periodo, il 26\% delle ore di lavoro sono state dedicate alla fase di analisi,
data la necessità di effettuare uno studio preliminare dei documenti che dovranno essere prodotti durante
l'arco del progetto (in particolare le Norme di Progetto e il Piano di Progetto) e quindi dei relativi Standard internazionali di riferimento. \\
Un'eguale percentuale di risorse orarie è stata spesa per il ruolo di Progettista, per ricercare, individuare e studiare le tecnologie
potenzialmente adatte al prodotto da sviluppare; il 16\% delle ore è stato dedicato al ruolo del Responsabile, in cui si sono mossi i primi
passi nell'ambito della gestione ed organizzazione del carico di lavoro tra i vari membri; un'eguale percentuale di ore
è stata spesa per il ruolo di Amministratore il quale si è occupato dell'organizzazione della repository sulla piattaforma \emph{GitHub}$^{G}$.\\
Infine il 12\% delle ore è stato dedicato al ruolo di Verificatore,
durante le quali i membri hanno preso dimestichezza con l'operazione di verifica e validazione dei primi documenti prodotti.

\paragraph{Gestione dei rischi}

\begin{itemize}
\item \textbf{Rischio verificatosi}: Scarsa esperienza tecnologica:
\begin{itemize}
\item \textbf{Esito Piano di Contingenza}: Tramite lo studio individuale e soprattutto tramite la trasmissione di conoscenza dai membri maggiormente esperti nel linguaggio \LaTeX e nei comandi Git a quelli meno esperti, il gruppo è riuscito efficacemente a mettere in pratica il piano di contingenza previsto per il suddetto rischio, ottenendo un allineamento delle conoscenze tra i veri membri;
\item \textbf{Impatto}: L'impatto della scarsa esperienza tecnologica è stato nullo in questo primo periodo, avendo il gruppo preventivato la necessità di dedicare innanzitutto risorse all'individuazione, allo studio e all'apprendimento delle tecnologie di supporto, così come di quelle che andranno a far parte dello stack tecnologico del prodotto.
\end{itemize}
\end{itemize}

\paragraph{}
\textbf{Retrospettiva}:
In questo primo periodo, il gruppo ha speso la maggior parte delle proprie ore svolgendo un lavoro di ricerca ed analisi
su due fronti, ovvero quello della documentazione e del \emph{Proof of Concept}$^{G}$ (da cui in poi \emph{PoC}): Per quanto concerne la prima, sono stati studiati gli standard internazionali di riferimento
con lo scopo di disegnare una mappa concettuale dei documenti che dovranno essere prodotti, in particolare delle Norme ed del Piano di Progetto; per quanto
riguarda il PoC invece sono state individuate e studiate tecnologie potenzialmente adatte allo sviluppo del prodotto, e successivamente selezionate quelle utilizzate per il PoC stesso. \\
Inoltre, grande attenzione si è spesa per la definizione di norme che regolino il \emph{Way of Working}$^{G}$, data la presenza di studenti lavoratori (con
specifiche esigenze legate agli impegni extra-universitari) fra i membri del gruppo, e quindi la necessità di un'efficace ed efficiente gestione delle ore, della ripartizione dei ruoli
e della suddivisione dei task fra i membri stessi. Nonostante una buona definizione dei ruoli, il gruppo non è riuscito ancora ad individuare la modalità secondo la quale
ruotare in futuro i ruoli stessi.

\begin{itemize}
\item \textbf{Obbiettivi raggiunti}:
\begin{itemize}
\item Allineamento da parte del gruppo, delle conoscenze del linguaggio \LaTeX e dei comandi Git;
\item Scelta delle tecnologie da includere nello stack tecnologico;
\item Inizio dell'analisi dei requisiti funzionali del prodotto.
\end{itemize}\pagebreak
\item \textbf{Obiettivi mancati}:
\begin{itemize}
\item Definizione della modalità di rotazione dei ruoli.
\end{itemize}
\end{itemize}

\subsubsection{Secondo periodo}
Inizio: 2023/11/25 \\
Fine: 2024/01/26 \\

<?php

require_once __DIR__ . '/pb.php';

echo tabelle_ore_soldi_tostring($periodi_rtb, 1, preventivo);

?>

\paragraph{Attività svolte}

\paragraph{} Le attività svolte dal gruppo nel secondo periodo sono state:

\begin{itemize}
\item Analisi dei rischi che possono verificarsi durante lo svolgimento dei processi che compongono il progetto, e delle relative possibili strategie di mitigazione;
\item In seguito all'individuazione delle tecnologie, progettazione e codifica del PoC;
\item Colloquio con il prof. Cardin per ottenere delucidazioni riguardo lo studio dei requisiti funzionali;
\item Prima stesura dei requisiti funzionali del prodotto da sviluppare;
\item Prosieguo della stesura delle Norme di Progetto;
\item Studio delle metriche da adottare al fine di misurare la qualità di prodotto e dei processi (particolare attenzione spesa per quest'ultimi);
\item \emph{Webinar}$^{G}$ organizzato dall'azienda proponente sull'utilizzo di \emph{Docker}$^{G}$.
\end{itemize}

\begin{figure}[H] \includegraphics[scale=.6]{GanttSecondoPeriodo.png} \end{figure}

<?php

echo tabelle_ore_soldi_tostring($periodi_rtb, 1, consuntivo);

?>

\paragraph{Gestione dei ruoli}

\paragraph{}
Nel secondo periodo, il ruolo per il quale è stata spesa la fetta più consistente di ore (50\%),
è stato quello di Programmatore, data la volontà del gruppo di completare entro la fine del periodo
la codifica del PoC e la relativa fase di test (alla quale è stato dedicato il 17\% delle ore). \\
Il 16\% delle risorse è stato dedicato alla figura del Progettista per supportare e guidare i Programmatori nel lavoro di codifica; nonostante la necessità
di proseguire con la stesura della documentazione e con l'analisi dei requisiti funzionali, solo il 10\% delle ore è stato
dedicato al ruolo di Analista; il 3\% delle ore è stato dedicato alla figura del Responsabile e il 3\%
dell'Amministratore.

\pagebreak

\paragraph{Gestione dei rischi}

\begin{itemize}
\item \textbf{Rischio verificatosi}: Conflitti decisionali:
\begin{itemize}
\item \textbf{Esito Piano di Contingenza}: Essendosi presentati punti di vista differenti riguardo le tecnologie da includere nello stack, sia per quanto riguarda la parte di Front-end che quella di Back-end, i membri del gruppo hanno avviato una discussione nella quale considerare i pro e i contro delle differenti proposte; si è deciso di affidare la scelta definitiva ai membri con la maggior expertise nell'ambito dei linguaggi di programmazione;
\item \textbf{Impatto}: L'impatto è stato nullo, grazie alla disponibilità e alla maturità dimostrata da tutti i membri del gruppo nell'affrontare un conflitto decisionale e soprattutto nell'accettarne la risoluzione.
\end{itemize}
\item \textbf{Rischio verificatosi}: Tecnologie da usare:
\begin{itemize}
\item \textbf{Esito Piano di Contingenza}: L'azienda proponente ha offerto al gruppo la possibilità di partecipare ad un Webinar su Docker, permettendo così un avanzamento importante nella codifica del PoC e, soprattutto, un allineamento tra tutti i membri della conoscenza della sopracitata tecnologia. L'utilizzo invece della libreria React si è rivelato più complesso del previsto, richiedendo ore supplementari di studio della documentazione relativa da parte dei programmatori;
\item \textbf{Impatto}: Importante è stato l'impatto del rischio legato alle tecnologie utilizzate per la parte Front-End del PoC, avendo richiesto in totale 10 ore in più nel ruolo di Programmatore rispetto a quelle preventivate inizialmente dal gruppo.
\end{itemize}
\item \textbf{Rischio verificatosi}: Calcolo delle tempistiche:
\begin{itemize}
\item \textbf{Esito Piano di Contingenza}: Precedentemente all'inizio della pausa natalizia, i membri del gruppo hanno preventivato il fatto che sarebbe potuto avvenire un rallentamento dei lavori, in particolare per quanto concerneva la stesura della documentazione ed in misura minore della codifica del PoC; il rallentamento si è però tradotto in un'interruzione quasi totale della stesura stessa e in generale dell'impegno profuso dai membri e della comunicazione fra gli stessi;
\item \textbf{Impatto}: L'impatto dell'errato calcolo delle tempistiche è stato notevole, non nella misura di un maggior numero di risorse allocate quanto in uno slittamento di 14 giorni delle scadenze fissate precedentemente dal gruppo al termine del primo periodo, entro le quali era stato prefissato terminare le prime versioni rispettivamente, delle Norme di Progetto e dell'Analisi dei Requisiti.
\end{itemize}
\end{itemize}

\paragraph{}
\textbf{Retrospettiva}:

Nel secondo periodo, il gruppo ha portato avanti diverse attività: Codifica del PoC, prosieguo della stesura della documentazione ed analisi dei requisiti funzionali; nello svolgimento delle ultime due, si sono verificate
le prime criticità importanti che il gruppo ha dovuto affrontare.\\
Innanzitutto, si è manifestata la necessità di implementare un piano di contingenza per la gestione e mitigazione dei rischi; inoltre i membri del gruppo deputati
all'analisi dei requisiti funzionali, hanno realizzato tardivamente il fatto, da una parte di non aver maturato ancora una piena padronanza della sintassi del linguaggio UML e dall'altra, di non aver eseguito fino a quel
momento un'analisi sufficientemente approfondita degli scenari d'uso e di conseguenza dei requisiti stessi; a questa immaturità, si è aggiunta la volontà da parte del gruppo di ultimare
entro la fine del periodo il PoC, riallocando quindi risorse dal ruolo dell'Analista a quello del Progettista. \\
Infine, nonostante fosse stato preventivato, il rallentamento del ritmo di lavoro da parte dei membri
dovuto alla pausa natalizia, si è trasformato in uno stop totale dei lavori stessi, comportando quindi probabilmente un ritardo nella tabella di marcia del gruppo verso il completamento dell'RTB.

\begin{itemize}
\item \textbf{Obbiettivi raggiunti}:
\begin{itemize}
\item Termine della codifica della parte di Front-end del PoC;
\item Termine della codifica della parte di back-end del PoC;
\item
\end{itemize}
\item \textbf{Obiettivi mancati}:
\begin{itemize}
\item Completamento della prima versione delle Norme di Progetto;
\item Stesura della bozza del Piano di Qualifica;
\item Completamento della prima versione dell'Analisi dei Requisiti.
\end{itemize}
\end{itemize}

\subsubsection{Terzo periodo}
Inizio: 2024/01/27 \\
Fine: 2024/03/11 \\

<?php

require_once __DIR__ . '/pb.php';

echo tabelle_ore_soldi_tostring($periodi_rtb, 2, preventivo);

?>

\paragraph{Attività svolte}

\paragraph{}
Le attività svolte dal gruppo nel terzo periodo sono state:

\begin{itemize}
\item Stesura della prima versione dell'Analisi dei Requisiti;
\item Inizio della stesura del Piano di Qualifica;
\item Creazione di una script per la verifica automatica dell'aderenza dei documenti alle norme tipografiche indicate nelle Norme di Progetto;
\item Prosieguo della stesura delle Norme di Progetto;
\item Migrazione di tutta la documentazione dalla cartella presente su \emph{Google Drive}$^{G}$, alla repository su \emph{GitHub}$^{G}$;
\item Adozione di nuovi metodi per la gestione della configurazione dei documenti all'interno della repository, per una produzione più efficiente degli stessi da parte dei membri del gruppo;
\item Incontro con il prof. Cardin nel quale è stato presentato il PoC e il documento di Analisi dei Requisiti.
\end{itemize}

\begin{figure}[H] \includegraphics[scale=.6]{GanttTerzoPeriodo.png} \end{figure}

<?php

echo tabelle_ore_soldi_tostring($periodi_rtb, 2, consuntivo);

?>

\paragraph{Gestione dei ruoli}

\paragraph{}
Nel terzo periodo, il 56\% delle risorse temporali del gruppo è stato speso nel ruolo dell'Analista, data la necessità
di portare a compimento la stesura della prima versione dell'Analisi dei Requisiti in vista della prima fase della revisione
RTB; di conseguenza il gruppo ha utilizzato il 27\% delle ore per i processi di verifica e validazione del documento sopra citato, processi che
sono stati visionati dai membri con particolare attenzione, vista l'importanza del documento stesso; inoltre il 9\% delle ore sono state dedicate alla figura dell'Amministratore
migrazione di tutta la documentazione sulla repository in GitHub e alla messa a punto della relativa gestione di configurazione, operazioni alle quali ha partecipato anche il Responsabile.

\paragraph{Gestione dei rischi}

\begin{itemize}
\item \textbf{Rischio verificatosi}: Analisi incompleta/carente dei requisiti:
\begin{itemize}
\item \textbf{Esito Piano di Contingenza}: I membri del gruppo deputati alla stesura dell'Analisi dei Requisiti hanno constatato tardivamente che i requisiti funzionali individuati prima del terzo periodo fossero insufficienti, in termini di numero e di profondità dell'analisi stessa; si è deciso quindi di destinare un maggior numero di ore a quest'ultima e di incrementare da 2 a 3 il numero di componenti deputati ad essa;
\item \textbf{Impatto}: Significativo è stato l'impatto del suddetto rischio, avendo comportato la necessità da parte del gruppo, di riallocare parte delle risorse orarie, dedicando 7 ore in più alla fase di analisi senza però aumentare il monte orario complessivo preventivato all'inizio del terzo periodo; sono state quindi tolte risorse alla stesura degli altri documenti.
\end{itemize}
\item \textbf{Rischio verificatosi}: Calcolo delle tempistiche:
\begin{itemize}
\item \textbf{Esito Piano di Contingenza}: In seguito al verificarsi del rischio legato ad una carente analisi dei requisiti, il Responsabile ha realizzato che sarebbe stato necessario aumentare non solo le ore da dedicare all'analisi stessa, ma anche alla verifica e validazione delle sezioni del relativo documento, che venivano iterativamente prodotte e corrette; il gruppo è riuscito a non aumentare il monte orario preventivato all'inizio del terzo periodo;
\item \textbf{Impatto}: L'impatto è stato significativo; nonostante non direttamente misurabile in un aumento del monte orario preventivato, si è tradotto in un'importante riallocazione di ore, tolte dal prosieguo della stesura della restante documentazione (in particolare del Piano di Qualifica).
\end{itemize}\pagebreak
\item \textbf{Rischio verificatosi}: Disponibilità dei membri:
\begin{itemize}
\item \textbf{Esito Piano di Contingenza}: In concomitanza dell'inizio della sessione d'esami, non è stato possibile una redistribuzione dei compiti dai membri con un numero maggiore di esami da sostenere a quelli meno impegnati; di comune accordo si è deciso quindi di interrompere fino al termine della sessione le attività del gruppo;
\item \textbf{Impatto}: L'impatto è stato importante in quanto vi è stato un rallentamento eccessivo da parte di tutti i membri del gruppo, nonostante esso fosse stato preventivato; tale impatto è misurabile in un ritardo di 14 giorni rispetto alla tabella di marcia.
\end{itemize}
\end{itemize}

\paragraph{}
\textbf{Retrospettiva}: \\
Nel terzo periodo, essendo stata completata la codifica del PoC, il gruppo ha speso la maggior parte delle proprie risorse per proseguire la stesura dei documenti, con attenzione
particolare nei confronti dell'Analisi dei Requisiti data la volontà di recuperare parte del ritardo accumulato sulla tabella di marcia e di voler effettuare la prima parte dell'RTB.\\
Purtroppo, come avvenuto nel secondo periodo, il ritmo di lavoro ha subito un nuovo rallentamento a causa della sessione invernale di esami, rendendo evidente da parte del gruppo una
parziale incapacità di mettere in atto un efficiente piano di contingenza con i rischi di una scarsa comunicazione e di una fallace pianificazione; data l'importanza dell'Analisi
dei Requisiti, si è reso necessario concentrare in essa buona parte delle risorse orarie, rallentando così la stesura degli altri documenti.

\begin{itemize}
\item \textbf{Obbiettivi raggiunti}:
\begin{itemize}
\item Stesura della prima versione dell'Analisi dei Requisiti;
\item Inizio della stesura del Piano di Qualifica;
\item Inizio della stesura del Glossario;
\item Prosieguo della stesura delle Norme e del Piano di Progetto;
\item Creazione di uno script per la verifica automatica dei documenti.
\end{itemize}
\item \textbf{Obiettivi mancati}:
\begin{itemize}
\item Stesura della prima versione delle Norme di Progetto;
\item Stesura della prima versione del Piano di Progetto.
\end{itemize}
\end{itemize}

\subsubsection{Quarto periodo}
Inizio: 2024/03/12 \\
Fine: 2024/04/18 \\

<?php

require_once __DIR__ . '/pb.php';

echo tabelle_ore_soldi_tostring($periodi_rtb, 3, preventivo);

?>

\paragraph{Attività svolte}

\paragraph{}
Le attività svolte dal gruppo nel quarto periodo sono state:

\begin{itemize}
\item Modifica dell'Analisi dei Requisiti e correzione degli errori come indicato dal prof. Cardin;
\item Completamento della sezione "Pianificazione" del Piano di Progetto;
\item Completamento della stesura del Piano di Qualifica;
\item Completamento delle Norme di Progetto;
\item Creazione di uno script per automatizzare l'operazione di individuazione dei termini presenti nei vari documenti, da inserire nel Glossario;
\item Stesura della prima versione del Glossario;
\item Consuntivo finale della fase RTB;
\item Preparazione della presentazione per la seconda fase della RTB.
\end{itemize}

\begin{figure}[H] \includegraphics[scale=.5]{GanttQuartoPeriodo.png} \end{figure}

<?php

echo tabelle_ore_soldi_tostring($periodi_rtb, 3, consuntivo);

?>

\paragraph{Gestione dei ruoli}

\paragraph{}
Come si può vedere dalla suddetta tabella, in questo quarto periodo il gruppo ha concentrato buona parte del monte-ore nello svolgimento
del ruolo di Analista e soprattutto di Verificatore: Per quanto concerne il primo, i membri hanno speso il 21\% delle risorse al fine di completare la stesura di tutta la documentazione e di effettuare le correzioni all'Analisi dei Requisiti
in seguito alla revisione del prof. Cardin; in previsione della seconda fase della RTB, una parte cospicua di risorse (\%50) è stata utilizzata per la fase di verifica
e validazione della documentazione sopracitata; il gruppo ha inoltre riservato il 12\% delle ore al ruolo del Responsabile, data l'importanza di un efficace
ed efficiente orchestrazione delle attività del gruppo in vista della seconda parte della RTB, e il 9\% di ore alla figura dell'Amministratore, al fine
di evitare potenziali conflitti negli item di versionamento prodotti dai differenti membri; infine, il 16\% delle risorse è stato dedicato al Progettista.

\paragraph{Gestione dei rischi}

\begin{itemize}
\item \textbf{Rischio verificatosi}: Conflitti decisionali:
\begin{itemize}
\item \textbf{Esito Piano di Contingenza}: In seguito alla revisione della Technology Baseline effettuate dal prof. Cardin, sono emerse criticità nella progettazione del PoC e in particolare nella scelta dello stack tecnologico; è stata quindi avviata una discussione tra i membri del gruppo su come risolvere tali criticità, consci della tabella di marcia da seguire rigorosamente al fine di completare la revisione PB evitando ulteriore ritardo a quello già accumulato. Data la natura sensibile dell'oggetto della discussione, i membri hanno faticato più del previsto a trovare una soluzione condivisa da tutti;
\item \textbf{Impatto}: L'impatto dei conflitti decisionali riguardanti eventuali modifiche dello stack tecnologico non è ancora misurabile, poiché non è prevedibile allo stato attuale se avverrà una modifica dello stack, e in caso quest'ultima avvenga, una misura quantitativa delle risorse che il gruppo dovrà forzatamente riallocare.
\end{itemize}
\end{itemize}

\textbf{Retrospettiva}: \\
Come si evince dalla tabella del consuntivo orario, in questo quarto periodo il gruppo si è prodigato nel terminare la stesura di tutta la documentazione restante,
e nelle successive operazioni di verifica e validazione; in seguito alla revisione TB effettuata dal prof. Cardin, sono state apportate le necessario modifiche all'Analisi
dei Requisiti.\\
Inoltre, a seguito delle perplessità espresse dal prof. Cardin riguardo le scelte riguardo lo stack tecnologico, il gruppo si è visto costretto a dedicare parte delle risorse ad
un nuovo lavoro di studio e ricerca per capire se includere nuovi framework o linguaggi nello stack tecnologico, soprattutto in previsione della progettazione dell'MVP.

\begin{itemize}
\item \textbf{Obbiettivi raggiunti}:
\begin{itemize}
\item Stesura della prima versione delle Norme di Progetto;
\item Stesura della prima versione del Piano di Progetto;
\item Stesura della prima versione del Piano di Qualifica;
\item Creazione di uno script per l'individuazione di tutti i termini facenti parte del Glossario;
\item Stesura della prima versione del Glossario;
\item Candidatura per la seconda parte dell'RTB;
\item Stesura della seconda versione dell'Analisi dei Requisiti.
\end{itemize}
\item \textbf{Obiettivi mancati}:
\begin{itemize}
\item Nessuno.
\end{itemize}
\end{itemize}

\subsubsection{Riepilogo finale}

<?php

require_once __DIR__ . '/pb.php';

function somma3d($a, $rows, $cols) {
  return array_combine($rows, array_map(fn ($r) => array_map(fn ($c) => array_sum(array_column(array_column($a, $r), $c)), $cols), $rows));
}

$membri = [
  (string)alberto_c(),
  (string)bilal_em(),
  (string)alberto_m(),
  (string)alex_s(),
  (string)iulius_s(),
  (string)giovanni_z(),
];

$rtb_somma_preventivi = somma3d(array_column($periodi_rtb, preventivo), $membri, range(0, 5));
$rtb_somma_consuntivi = somma3d(array_column($periodi_rtb, consuntivo), $membri, range(0, 5));


?>

\subsubsubsection{Preventivo economico totale}

<?php echo str_replace_array(['SOLDI' => tabella_to_string(tabella_soldi($rtb_somma_preventivi))],  tabella_soldi); ?>

\subsubsubsection{Consuntivo economico finale}

<?php echo str_replace_array(['SOLDI' => tabella_to_string(tabella_soldi($rtb_somma_consuntivi))],  tabella_soldi); ?>

\subsubsubsection{Preventivo orario totale}

<?php echo str_replace_array(['ORE'   => tabella_to_string(tabella_ore($rtb_somma_preventivi))],    tabella_ore); ?>

\subsubsubsection{Consuntivo orario finale}

<?php echo str_replace_array(['ORE'   => tabella_to_string(tabella_ore($rtb_somma_consuntivi))],    tabella_ore); ?>

\paragraph{Gestione dei ruoli}
Durante la fase di RTB, il 29\% delle risorse orario è stato dedicato al ruolo di Analista, il 17\% a quello di Programmatore, il 25\% a quello di Verificatore, mentre
solo l'8 \% per le figure rispettivamente del Responsabile e dell'Amministratore; il 13\% per la figura del Progettista.\\

\paragraph{Retrospettiva finale}
Analizzando le gestione da parte del gruppo dei ruoli, salta subito all'occhio un forte sbilanciamento, in parte abbastanza naturale nella fase di RTB, a favore di alcuni ruoli a discapito di altri: Abbondanti risorse sono state spese
per la figura dell'Analista in quanto la produzione dei documenti in generale, e dell'Analisi dei Requisiti in particolare, si è dimostrata un compito assai più oneroso di quanto si fosse preventivato
inizialmente; di questo fatto, è considerata una diretta conseguenza la quantità di risorse dedicate alla verifica e alla validazione della documentazione e del codice del PoC. \\
Il gruppo riconosce retrospettivamente che troppe poche risorse sono state dedicate in primis alla figura del Responsabile: Un'attenzione evidentemente non sufficiente ai compiti di gestione del gruppo (soprattutto per quanto riguarda la comunicazione), di assegnazione
dei compiti (che ha comportato una differenza importante nella quantità di lavoro profuso da alcuni membri) e
di coordinamento delle risorse impiegate, è considerata dai membri una delle cause principali delle molteplici criticità emerse durante tutta la RTB.

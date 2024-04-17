#!/bin/bash

# stampa i file di latex
function texfiles(){
  find .. -type f -name '*.tex'
}

# stampa le posizioni dove $^{G}$ viene usato senza un \emph associato
function findoutliers(){
  OUTLIERS="$(
  texfiles | while IFS= read line ; do
    MATCHES="$(grep -ne '\$\^{G}\$' $line)"
    [[ -n "$MATCHES" ]] &&
      { echo "$MATCHES" | awk -F 'ç' -v file="$line"  '{printf("%s @ %s\n",file,$1)}' ; }
  done |
    grep -vP '\\emph{.*?}\$\^{G}\$' |
    grep -vP 'La presenza di un termine all.interno del glossario viene indicata applicando una'
  )"
  printf '%s\n' "$OUTLIERS"
  [[ -z "$OUTLIERS" ]]
}

# stampa le enties valide per il glossario
function findentries(){
  cat $(texfiles) | grep -Po '\\emph{.*?}\$\^{G}\$'
}

VOC=src/vocaboli.tex

# formatta vocaboli
function formattavocaboli(){
   sed -zi 's/\n//g;s/\(\\subsection{\)/\n\1/g;s/$/\n/' "$VOC"
}

# stampa e scrivi il template latex dove aggiungere le definizioni
function makelatex(){
  function parsione(){
    sed '
    # rinomine
    ; s/^Clienti$/Cliente/
    ; s/^Coperti$/Coperto/
    ; s/^Ristoratori$/Ristoratore/
    ; s/^Prenotazioni$/Prenotazione/
    ; s/^Requisiti$/Requisito/
    ; s/^Requisiti funzionali$/Requisito funzionale/
    ; s/^Profili$/Profilo/
    ; s/^NextJs$/NextJS/
    ; s/^PoC$/PoC (Proof of Concept)/
    ; s/^Proof of Concept$/PoC (Proof of Concept)/
    ; s/^ITS$/ITS (Issue Tracking System)/
    ; s/^Express$/ExpressJS/

    # eliminazioni
    ; /^Capitolato d.appalto$/d
    ; /^$/d
    '
  }
  findentries | sed 's/\\emph{\(.\)/\U\1/;s/}\$\^{G}\$//' | parsione | sort | uniq |
    while IFS= read line ; do
      CNT="$(grep '\\subsection{'"$line"'}' "$VOC")"
      if [[ -n "$CNT" ]] ; then
        printf '%s\n' "$CNT"
      else
        printf '\\subsection{%s} (INSERIRE DEFINIZIONE QUI)\n' "$line"
      fi
    done | sort > "$VOC".tmp
    mv "$VOC"{.tmp,}
    echo "$VOC è stato aggiornato, controlla per vocaboli da definire"
}

formattavocaboli && findoutliers && makelatex

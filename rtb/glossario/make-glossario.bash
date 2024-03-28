#!/bin/bash

# stampa i file di latex
function texfiles(){
  find .. -type f -name '*.tex'
}

# stampa le posizioni dove $^{G}$ viene usato senza un \emph associato
function findoutliers(){
  texfiles | while IFS= read line ; do
    MATCHES="$(grep -ne '\$\^{G}\$' $line)"
    [[ -n "$MATCHES" ]] &&
      { echo "$MATCHES" | awk -F 'ç' -v file="$line"  '{printf("%s @ %s\n",file,$1)}' ; } | grep -vP '\\emph{.*?}\$\^{G}\$'
  done
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
  function escludi(){
    grep -v 'Clienti' |
    grep -v 'Ristoratori' |
    cat
  }
  findentries | sed 's/\\emph{\(.\)/\U\1/;s/}\$\^{G}\$//' | escludi  | sort | uniq |
    while IFS= read line ; do
      CNT="$(grep '\\subsection{'"$line"'}' "$VOC")"
      if [[ -n "$CNT" ]] ; then
        printf '%s\n' "$CNT"
      else
        printf '\\subsection{%s} DA DEFINIRE\n' "$line"
      fi
    done | tee "$VOC".tmp
    mv "$VOC"{.tmp,}
}

if [[ -z "$*" ]] ; then
  echo Funzioni disponibili
  echo
  cat "$0" | grep -P '^# ' -A 1 | sed 's/--//;s/^/\t/' | sed 's/function \(.*\)(){/come usare : sh make-glossario.sh \1/'
  echo
else
  $*
fi

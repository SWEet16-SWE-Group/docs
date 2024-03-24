#!/bin/bash

function texfiles(){
  find .. -type f -name '*.tex'
}

function findoutliers(){
  texfiles | while IFS= read line ; do
    MATCHES="$(grep -ne '\$\^{G}\$' $line)"
    [[ -n "$MATCHES" ]] &&
      { echo "$MATCHES" | awk -F 'ç' -v file="$line"  '{printf("%s @ %s\n",file,$1)}' ; } | grep -vP '\\emph{.*?}\$\^{G}\$'
  done
}

function findentries(){
  cat $(texfiles) | grep -Po '\\emph{.*?}\$\^{G}\$'
}

function makelatex(){
  findentries | sed 's/\\emph{\(.\)/\U\1/;s/}\$\^{G}\$//' | sort | uniq |
    while IFS= read line ; do
      cnt="DA DEFINIRE"
      printf '\section{%s}: %s;\n' "$line" "$cnt"
    done | tee src/vocaboli.tex.tmp
    mv src/vocaboli.tex{.tmp,}
}

$*

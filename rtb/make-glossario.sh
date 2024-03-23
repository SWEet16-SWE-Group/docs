#!/bin/bash

function texfiles(){
  find . -type f -name *.tex
}

function contains(){
  [[ -n "$(grep -e $* )" ]]
}

function linenumber(){
  SEGNAPOSTO="$1"
  FILE="$2"
  printf "\n$SEGNAPOSTO\n\t$FILE\n"
  function p(){
    printf "\t\t$*\n"
  }
  export -f p
  grep -ne "$SEGNAPOSTO" "$FILE" | sed 's/:.*$//g' | xargs -I ç sh -c 'p ç'
}

function findsegnaposti(){
  cat $( texfiles ) |
    sed -z 's/\s/\n/g' |
    grep -e '\$....\$' |
    sed 's/\$....\$//;s/[;:,.)]*$//' |
    sort |
    uniq
}

function findcontainssegnaposto(){
  SEGNAPOSTO="$*"
  texfiles | xargs -I ç sh -c "contains $SEGNAPOSTO ç && linenumber $SEGNAPOSTO ç"
}

export -f texfiles
export -f contains
export -f linenumber
export -f findcontainssegnaposto

findsegnaposti | xargs -I ç sh -c "findcontainssegnaposto ç"

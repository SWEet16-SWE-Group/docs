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
  function printline(){
    printf "\t\t$*\n"
  }
  export -f printline
  grep -ne "$SEGNAPOSTO" "$FILE" | sed 's/:.*$//g' | xargs -I ç sh -c 'printline ç'
}

function findcontainssegnaposto(){
  SEGNAPOSTO="$*"
  printf "\n$SEGNAPOSTO\n"
  function printfile(){
    printf "\t$*\n"
  }
  export -f printfile
  texfiles | xargs -I ç sh -c "contains $SEGNAPOSTO ç && printfile ç && linenumber $SEGNAPOSTO ç"
}

export -f texfiles
export -f contains
export -f linenumber
export -f findcontainssegnaposto

function findsegnaposti(){
  cat $( texfiles ) |
    sed -z 's/\s/\n/g' |
    grep -e '\$....\$' |
    sed 's/\$....\$//;s/[;:,.)]*$//' |
    sort |
    uniq
}

findsegnaposti | xargs -I ç sh -c "findcontainssegnaposto ç"
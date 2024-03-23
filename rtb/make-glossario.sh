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
  printf '\n%s\n\t%s\n' "$SEGNAPOSTO" "$FILE"
  grep -ne "$SEGNAPOSTO" "$FILE" | sed 's/\([0-9]*\):/\1/g' | xargs -I ç printf "\t\t%06d\n" ç
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

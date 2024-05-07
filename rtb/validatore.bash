#!/bin/bash

function texfiles(){
  find . -type f -name '*.tex' ! -name 'vocaboli.tex' ! -name 'registro-modifiche.tex' | grep -v 'verbali'
}

# findreplace le correzzioni
function findreplace(){
  echo "Attenzione pericolo sostituzione regex inplace"
  texfiles | while IFS= read line ; do
    printf 'Operando su: %s\n' "$line"
    perl -i -0pe '
    # rimozione del rumore
    ; s/\r\n/\n/g           # carriage return
    ; s/\t/  /g             # tab in 2 spazi
    ; s/(\S) +/\1 /g        # compressione di tanti spazi in uno esclusa indentazione iniziale
    ; s/ *\n/\n/g           # testo bianco a fine riga
    ; s/ *}/}/g          # rimozione spazi tra : e }
    ; s/}(\w)/} \1/g      # spazio dopo :}
    ; s/(\S) +([;:,.])/\1\2/g         # rimozione spazi prima di [:,.;]
    ; s/([a-zA-Z]),([a-zA-Z])/\1, \2/g          # aggiunta spazio dopo ,

    # maiuscole
    ; s/\\item (\\textbf{)?([a-z])/\\item \1\U\2/g                     # dopo item, preservando textbf
    ; s/(?:(?<!(?<!\\url{)(?<!\\href{))):([^\w\d]*)([a-z])/:\1\U\2/   # dopo : preservando caratteri in mezzo e escludendo url e href
    ; s/:(})? ([a-z])/:\1 \U\2/g
    ' "$line"

    while [[ -n "$( grep -zPo '\\item .*?\n[^\\]*?\n' "$line" | tr "\0" '\r' )" ]] ; do
      perl -i -0pe '
      # mergia le linee di item
      ; s/(\\item .*?)\n([^\\]*?)\n/\1 \2\n/g
      ' "$line"
    done

    perl -i -0pe '
    # elenchi ; .
    ; s/(\\item .*?)[:;\.]?\n( *\\item)/\1;\n\2/g         # ; tra 2 \item
    ; s/(\\item .*?)\.\n( *\\item)/\1;\n\2/g              # ; tra 2 \item con il . in mezzo quello sopra non sempre funziona
    ; s/(\\item .*?)[:;\.]?\n( *\\end)/\1.\n\2/g          # . tra \item e \end
    ; s/(\\item .*?)[:;\.]?(})?\n( *\\begin)/\1:\2\n\3/g  # : tra 2 \item e \begin


    ; s/(\\item .*?\$\$)[:;\.]?(})?\n/\1\2\n\3/g  # rimozione del carattere di fine item dopo $$

    # rimozione del rumore
    ; s/\r\n/\n/g           # carriage return
    ; s/\t/  /g             # tab in 2 spazi
    ; s/(\S) +/\1 /g        # compressione di tanti spazi in uno esclusa indentazione iniziale
    ; s/ *\n/\n/g           # testo bianco a fine riga
    ' "$line"
  done

}

function phpparse(){
  #find . -type f -name '*.php' -execdir php '{}' \;
  echo a 
}

function latexcompile(){
  p="$(pwd)"
  find . -type f -name 'main.tex' | while IFS= read line ; do
    cd "$(dirname "$line")"
    echo
    echo $line
    rm -rf .build
    mkdir -p .build
    pdflatex -interaction=nonstopmode -halt-on-error -output-directory=.build/ "main.tex" > /dev/null
    echo $line $?
    cd "$p"
  done
}

function ortografia(){
  # LANG=it_IT.UTF-8 find . -type f -name '*.tex' -execdir hunspell '{}' \;
  hunspell -d it_IT,en_US $(find . -type f -name '*.tex')
}

function glossario(){
  php vocaboli.php
}

glossario && phpparse && findreplace && ortografia && latexcompile

exit 0

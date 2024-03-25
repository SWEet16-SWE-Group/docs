function texfiles(){
  find . -type f -name '*.tex' | grep -v 'verbali'
}

function greptext(){
    sed 's/%.*$//' "$1" | grep -nP "$2" | awk -v msg="$3" -v file="$1" '{printf("%s : %s @ %s\n",msg,file,$0)}'
}

# trova gli errori nei file tex
function finderrors(){
  texfiles | while IFS= read line ; do
    greptext "$line" '\\item [a-z]' 'Maiuscola mancante dopo \\item'
    greptext "$line" '\\item \\texbf{[a-z]' 'Maiuscola mancante dopo \\item \\textbf'
    greptext "$line" '\S\s+[,;:]' 'Spazio presente prima di [,.:]'
    greptext "$line" '[,;:][^}\s0-9]' 'Spazio mancante dopo di [,.:]'

    #greptext "$line" '\\item.*?[^;]}?$' '\\item non finisce con ;'
    #greptextzero "$line" '\\item (?!\\item)*?[^\.]\s*?\n\s*?\\end{(itemize|enumerate)}' '\\item .* \\end non finisce con .'
    #greptextzero "$line" '\\item[^\n]*?[^:]\s*}?\n[^\n]*?\\begin' '\\item .* \\begin non finisce con :'
  done
}

# findreplace le correzzioni
function findreplace(){
  echo "Attenzione pericolo sostituzione regex inplace"
  texfiles | while IFS= read line ; do
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

    while [[ -n "$( grep -zP '\\item .*?\n[^\\]*?\n' "$line" )" ]] ; do
      perl -i -0pe '
      # mergia le linee di item
      ; s/(\\item .*?)\n([^\\]*?)\n/\1 \2\n/g
      ' "$line"
    done

    perl -i -0pe '
    # elenchi ; .
    ; s/(\\item .*?)[:;.]?\n( *\\item)/\1;\n\2/g        # rimozione spazi prima di [:,.;]
    ; s/(\\item .*?)[:;.]?\n( *\\end)/\1.\n\2/g        # rimozione spazi prima di [:,.;]
    ; s/(\\item .*?)[:;.]?(})?\n( *\\begin)/\1:\2\n\3/g        # rimozione spazi prima di [:,.;]

    # rimozione del rumore
    ; s/\r\n/\n/g           # carriage return
    ; s/\t/  /g             # tab in 2 spazi
    ; s/(\S) +/\1 /g        # compressione di tanti spazi in uno esclusa indentazione iniziale
    ; s/ *\n/\n/g           # testo bianco a fine riga
    ' "$line"
  done
  git diff

  texfiles | while IFS= read line ; do
    grep -zP '\\item .*?[:;.]?\n *\\item' "$line"
  done
}


if [[ -z "$*" ]] ; then
  echo Funzioni disponibili
  echo
  cat "$0" | grep -A 2 -P '^# '
  echo
else
  $*
fi

exit 0

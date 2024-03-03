
function grep_padded(){
  grep -ne $* | sed 's/^\([0-9]*\)\:\s*/\1@/;' | awk -F '@' '{printf("%06d: %s\n",$1,$2)}' 
}

function add_message_file(){
  awk -v file="$2" -v msg="$1" -F '\n' '{printf("%s: %s @ %s\n",msg,file,$1)}'
}

# controllo che '\item' sia seguito da una maiuscola
function items_capital(){
  function remove_capital () {
    grep -vE '\\item (|\\textbf{)[A-Z]'
  }

  cat $1 | grep_padded '\\item' | remove_capital | add_message_file "Maiuscola dopo item" $1
}

# controllo che ':' sia seguito da una maiuscola
function colon_capital(){
  function delete_url(){
    perl -pe 's/\\(url|href){.*?}//
    ; s/Ore\s*\d*:\d*\s*//
    ; s/\\textbf{(Inizio|Fine) incontro:}//
    '
  }

  cat $1 | delete_url | grep_padded ':[^a-zA-Z]*[a-z]' | add_message_file "Maiuscola dopo i due punti" $1
}

# items_capital $*
# colon_capital $*
# exit

echo "Attenzione pericolo sostituzione regex inplace"

function pericolo_search_replace(){
  perl -i -pe '
    s/\r\n/\n/g                                       # rimozione carriage return
  ; s/(\S)[ \t]+/\1 /g                                # compressione di tanti spazi in uno esclusa indentazione iniziale
  ; s/\s*\n/\n/                                       # rimozione testo bianco a fine riga
  ; s/\\item ([a-z])/\\item \U\1/                     # maiuscola dopo item
  ; s/\\item \\textbf{([a-z])/\\item \\textbf{\U\1/   # maiuscola dopo item in textbf
  ; s/:([^\w\d]*)([a-z])/:\1\U\2/                     # maiuscola dopo : preservando caratteri in mezzo
  ' $1
}

pericolo_search_replace $*

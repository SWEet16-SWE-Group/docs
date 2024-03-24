
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

function find(){
 items_capital $*
 colon_capital $*
}

function pericolo_search_replace(){
  echo "Attenzione pericolo sostituzione regex inplace"
  perl -i -0pe '
  # rimozione del rumore
    s/\r\n/\n/g           # carriage return
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

  # mergia le linee di item
  ; s/(\\item .*?)\n([^\\]*?)\n/\1 \2\n/g
  ; s/(\\item .*?)\n([^\\]*?)\n/\1 \2\n/g
  ; s/(\\item .*?)\n([^\\]*?)\n/\1 \2\n/g
  ; s/(\\item .*?)\n([^\\]*?)\n/\1 \2\n/g
  ; s/(\\item .*?)\n([^\\]*?)\n/\1 \2\n/g
  ; s/(\\item .*?)\n([^\\]*?)\n/\1 \2\n/g
  ; s/(\\item .*?)\n([^\\]*?)\n/\1 \2\n/g
  ; s/(\\item .*?)\n([^\\]*?)\n/\1 \2\n/g
  ; s/(\\item .*?)\n([^\\]*?)\n/\1 \2\n/g

  # elenchi ; .
  ; s/(\\item .*?)[:;.]?\n( *\\item)/\1;\n\2/g        # rimozione spazi prima di [:,.;]
  ; s/(\\item .*?)[:;.]?\n( *\\end)/\1.\n\2/g        # rimozione spazi prima di [:,.;]
  ; s/(\\item .*?)[:;.]?(})?\n( *\\begin)/\1:\2\n\3/g        # rimozione spazi prima di [:,.;]

  # rimozione del rumore
  ; s/\r\n/\n/g           # carriage return
  ; s/\t/  /g             # tab in 2 spazi
  ; s/(\S) +/\1 /g        # compressione di tanti spazi in uno esclusa indentazione iniziale
  ; s/ *\n/\n/g           # testo bianco a fine riga
  ' $1
}

[[ "$1" == "--find" ]] && { shift; find $* ; exit; }
[[ "$1" == "--replace" ]] && { shift; pericolo_search_replace $* ; exit; }
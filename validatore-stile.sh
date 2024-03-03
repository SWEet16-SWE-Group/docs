
function grep_padded(){
  grep -ne $* | sed 's/^\([0-9]*\)\:\s*/\1@/;' | awk -F '@' '{printf("%06d: %s\n",$1,$2)}' 
}

function add_message_file(){
  awk -v file="$2" -v msg="$1" -F '\n' '{printf("%s: %s @ %s\n",msg,file,$1)}'
}

# controllo che '\item' sia seguito da una maiuscola
function items_capital(){
  function remove_capital () {
    grep -e '[0-9]*: \\item [^A-Z]' | grep -e '[0-9]*: \\item \\textbf{[^A-Z].*}'
  }

  cat $1 | grep_padded '\\item' | remove_capital
}

# controllo che ':' sia seguito da una maiuscola
function colon_capital(){
  function delete_url(){
    perl -pe 's/\\url{.*?}//'
  }

  cat $1 | delete_url | grep_padded ':[^a-zA-Z]*[a-z]' | add_message_file "Maiuscola dopo i due punti" $1
}

items_capital $*
colon_capital $*

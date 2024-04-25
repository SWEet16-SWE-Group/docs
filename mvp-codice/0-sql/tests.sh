#!/bin/bash

function sql_exec () {
  mariadb -N --host=localhost --port=3306 --user=root --password=root --execute="$*"
}

sql_exec "source main.sql" || { printf '\n\n%s\n\n' 'Errore nel sourcing del main' ; exit 1 ; }

find tests.d -type f -name '*.sql' | while IFS= read test; do
  printf '\n=========================== %s\n' "$test"
  sql_exec "source main.sql ; source $test;"
done

printf '\n'

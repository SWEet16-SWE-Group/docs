#!/bin/bash

function sql_exec () {
  mariadb --host=localhost --port=3306 --user=root --password=root --execute="$*"
}

find tests.d -type f -name '*.sql' | while IFS= read test; do
  sql_exec "source main.sql"
  sql_exec "use easymeal ; source $test;"
done

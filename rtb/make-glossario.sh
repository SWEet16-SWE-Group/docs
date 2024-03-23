#!/bin/bash

function findsegnaposti(){
  cat $( find . -type f -name *.tex ) | grep -ne '\$....\$'
}

findsegnaposti

# Come eseguire

## Prerequisiti

1. Avere installato docker e docker-compose sul proprio sistema

## Esecuzione

1. Entrare nella cartella Codice/
2. Eseguire
```shell
  docker-compose up
```

Se tutto è andato correttamente, in automatico verrà aperto il browser predefinito dal sistema sulla home del sito.

## Info varie

- I servizi seguenti si trovano in esecuzione sulle porte seguenti:
  - React: 3000: L'interfaccia utente
  - Apache: 8888: Il controller per permettere all'utente di interagire con il DB
  - MySQL: 3306: Database
  - PHPMyAdmin: 8080: Servizio opzionale, scelto in fase di sviluppo per velocizzare la parte di codifica

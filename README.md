# Come eseguire

## Prerequisiti

1. Avere installato docker e docker-compose sul proprio sistema

## Esecuzione

1. Entrare nella cartella Codice/
2. Eseguire
```shell
  docker-compose up
```

Se tutto è andato correttamente, dopo circa 2 minuti, sul terminale comparirà un messaggio di successo simile a quello qui sotto.
```
react-server  | 
react-server  | Compiled successfully!
react-server  | 
react-server  | You can now view react-frontend in the browser.
react-server  | 
react-server  |   Local:            http://localhost:3000
react-server  |   On Your Network:  http://172.18.0.2:3000
react-server  | 
```

A questo punto è possibile interagire con l'appicazione aprendo il proprio browser all'indirizzo: http://localhost:3000 .

## Info varie

- I servizi seguenti si trovano in esecuzione sulle porte seguenti:
  - React: 3000: L'interfaccia utente
  - Apache: 8888: Il controller per permettere all'utente di interagire con il DB
  - MySQL: 3306: Database
  - PHPMyAdmin: 8080: Servizio opzionale, scelto in fase di sviluppo per velocizzare la parte di codifica

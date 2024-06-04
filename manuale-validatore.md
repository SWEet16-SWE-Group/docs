# Validatore T.messer 

## Come usare

1. Costruire il container

```shell
docker build . -t tmesser
```

2. Compilazione dei documenti

```shell
docker run -v .:/validatore/ -it tmesser php validatore.php --compile
```

Buona compilazione dei documenti :)

## Dettagli inutili

- Il processo di build del container può richiedere anche 5'. A me sono voluti 322s.
- Il validatore esegue le seguenti operazioni nel seguente ordine:
    1. Costruzione del glossario
    2. Esecuzione di tutti gli script PHP
    3. Esecuzione delle regex di correzione
    4. Controllo ortografico di ogni file tex con i dizioniari italiano e inglese americano (Leggete il manuale di Hunspell)
    5. Compilazione di tutti i documenti LaTex
    6. --TODO Spostamento dei documenti compilati nelle directory ad albero che saranno poi mergiate in main

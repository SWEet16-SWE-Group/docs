<p style="text-align: center;">

[![React](https://github.com/SWEet16-SWE-Group/docs/workflows/React/badge.svg)](https://github.com/SWEet16-SWE-Group/docs/actions?query=workflow:"React")
[![Laravel](https://github.com/SWEet16-SWE-Group/docs/workflows/Laravel/badge.svg)](https://github.com/SWEet16-SWE-Group/docs/actions?query=workflow:"Laravel")
[![codecov](https://codecov.io/gh/SWEet16-SWE-Group/docs/graph/badge.svg?token=KZVW5OOT08)](https://codecov.io/gh/SWEet16-SWE-Group/docs)

</p>

## Usare il progetto:

Dopo aver clonato la repository, assicurarsi di avere Docker e Docker Compose installati.

Con il Docker Daemon in esecuzione aprire un terminale e posizionarsi nella cartella del progetto, chiamare il seguente 
comando per creare i container la prima volta:

```
docker-compose up --build -d
```

Entrare ora nel container di php con:
```
docker-compose exec php sh
```
Una volta dentro il container di php eseguire il comando:
```
composer install
```

... e generare le tabelle del database necessarie tramite: 
```
php artisan migrate
```

Controllare ora che la pagina di Laravel (localhost:8000) non dia errori, se così non fosse chiamare sempre da dentro il container php:
```
chmod -R 777 storage
```

Per acccedere all'applicazione (React) collegati a:

```
localhost:3000
```

Per visionare il database (PhpmyAdmin) collegati a:

```
localhost:8443
```

Utilizzare le seguenti credenziali di accesso per il DB:

- **Username**: root
- **Password**: root

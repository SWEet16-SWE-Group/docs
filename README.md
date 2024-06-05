<p style="text-align: center;">

[![React](https://github.com/SWEet16-SWE-Group/docs/workflows/React/badge.svg)](https://github.com/SWEet16-SWE-Group/docs/actions?query=workflow:"React")
[![Laravel](https://github.com/SWEet16-SWE-Group/docs/workflows/Laravel/badge.svg)](https://github.com/SWEet16-SWE-Group/docs/actions?query=workflow:"Laravel")
[![codecov](https://codecov.io/gh/SWEet16-SWE-Group/docs/graph/badge.svg?token=KZVW5OOT08)](https://codecov.io/gh/SWEet16-SWE-Group/docs)

</p>

## Usare il progetto:

Assicurarsi di avere installato Docker Desktop e Docker Compose, aprire un terminale e posizionarsi nella cartella del progetto, chiamare il comando:

```
docker-compose up --build
```

Aprire ora un altro terminale e chiamare: 
```
docker-compose exec php sh
```

E: 
```
composer install
```

Ora: 
```
php artisan key:generate
```

Ed infine:
```
php artisan migrate
```

Controllare ora se la pagina di laravel (localhost/8000) non dia errori, se così non fosse chiamare sempre da dentro il container docker:
```
chmod -R 777 storage
```

Per collegarsi a React andare su:

```
localhost/3000
```

Per collegarsi a Laravel andare su:

```
localhost/8000
```

Per collegarsi a PhpmyAdmin andare su:

```
localhost/8443
```

## Am2 Test
## Zahtjevi
Ova test projekat je radnjen u Laravel frameworku 9.2.0, te je potrebno predhodno ispuniti sve zahtjeve frameworka kao sto je php verzija > 8.*

## Podesavanje
Kako bi projekat bio u potpunosti funkcionala, potrebno je podisiti .env fajl
- Bazu podataka
- Mail servis
- QUEUE_CONNECTION (eg. QUEUE_CONNECTION=database)
- SCOUT_DRIVER (eg: SCOUT_DRIVER=database)

## Instalacija
```
composer install
```

## Migracije i testni podaci
Nakon sto se uredno podesi projekat potrebno je pozvati migracije i seedere.
```
php artisan migrate --seed
```

## Poslovi
Za izvrsavanje poslova kao sto je slanje mailova za cijenu ispod x vrednosti potrebno je pozvati komadu za obradu poslova ili QUEUE_CONNECTION podesiti na SYNC, u slucaju da se podesi SYNC poslovi ce se izvrsiti sa obradom request-a
```
php artisan queue:work
```

## End pointi
```
php artisan route:list
```

## Testovi
Testovi se pokrecu putem komande
```
php artisan test
```

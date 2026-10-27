# Zilveren Schakel – Backend API

REST API voor **Zilveren Schakel**, een platform dat dienstvragers (ouderen of mensen die hulp nodig hebben) in contact brengt met vrijwilligers voor kleine, alledaagse hulp: vervoer, boodschappen, gezelschap, administratie, klusjes, …

Een adviseur begeleidt het geheel: hij/zij doet de intake van nieuwe gebruikers, keurt accounts goed en beheert de abonnementen van dienstvragers.

Gebouwd met **Laravel 12** (PHP 8.3), **MySQL 8.4** en **Laravel Sanctum** voor token-authenticatie. De frontend draait apart (standaard op `http://localhost:5173`).

## Functionaliteit

- **Registratie & login** – via e-mail of telefoonnummer. Na registratie krijgt de gebruiker een welkomstmail en wordt er automatisch een intake aangemaakt. Inloggen kan pas nadat een adviseur het account heeft goedgekeurd.
- **Rollen**
  - `client` (dienstvrager) – plaatst hulpvragen, maakt afspraken, kan vrijwilligers als favoriet markeren.
  - `volunteer` (vrijwilliger) – kiest categorieën waarin hij/zij wil helpen, geeft beschikbaarheden op en aanvaardt hulpvragen.
  - `advisor` (adviseur) – beheert intakes, verifieert/verwijdert gebruikers en beheert abonnementen.
- **Hulpvragen** – per categorie; wanneer een vrijwilliger een hulpvraag aanvaardt, krijgt de dienstvrager een mail.
- **Afspraken** – aanmaken, bevestigen en annuleren.
- **Abonnementen** – een dienstvrager heeft een actief abonnement nodig om hulpvragen en afspraken te gebruiken.
- **Reviews, beschikbaarheden en profielfoto's** voor vrijwilligers/gebruikers.

## Projectstructuur

```
.
├── app/                 # Laravel-applicatie
│   ├── app/Http/        # Controllers en middleware (advisor, client, volunteer, subscription)
│   ├── app/Models/      # Eloquent-modellen
│   ├── database/        # Migrations, factories en seeders
│   ├── routes/api.php   # Alle API-routes
│   └── tests/           # Feature- en unittests
├── docker/              # Dockerfile en php.ini voor de webcontainer
├── docker-compose.yml   # PHP/Apache, MySQL en phpMyAdmin
└── .gitlab-ci.yml       # CI/CD: build, lint (Pint), test en deploy
```

## Installatie (lokaal met Docker)

### Vereisten

- [Docker Desktop](https://www.docker.com/products/docker-desktop/) (op Windows met WSL2)
- Git

### 1. Project ophalen

```shell
git clone https://github.com/mathisdebaere/2526-fsa-backend.git
cd 2526-fsa-backend
```

### 2. Containers starten

```shell
docker-compose up
```

Dit start drie containers:

| Service      | URL                     | Omschrijving                     |
|--------------|-------------------------|----------------------------------|
| `php-web`    | http://localhost:8080   | Laravel API (Apache + PHP 8.3)   |
| `mysqldb`    | `localhost:3307`        | MySQL 8.4 (root / `Azerty123`)   |
| `phpmyadmin` | http://localhost:8000   | phpMyAdmin                       |

### 3. Laravel configureren

Open een tweede terminal en ga in de webcontainer:

```shell
docker-compose exec -u 1000:1000 php-web bash
```

Voer daarin uit:

```shell
cp .env.example .env
composer install
php artisan key:generate
touch storage/logs/laravel.log
chmod 777 -R storage bootstrap/cache
php artisan storage:link
php artisan migrate --seed
exit
```

De API is nu bereikbaar op **http://localhost:8080/api**.

### 4. Stoppen

Stop met `Ctrl+C` in de terminal waar `docker-compose up` draait, en ruim daarna op met:

```shell
docker-compose down
```

## Testaccounts

Na `php artisan migrate --seed` zijn deze accounts beschikbaar (wachtwoord voor allemaal: `password`):

| Rol         | E-mail                                          |
|-------------|-------------------------------------------------|
| Adviseur    | `tine@zilverenschakel.be`                       |
| Dienstvrager| `joris@example.com`, `bart@example.com`         |
| Vrijwilliger| `smurf1@example.com` … `smurf20@example.com`    |

De seeders vullen ook de hulpvraagcategorieën en een aantal voorbeeldhulpvragen.

## API gebruiken

Alle routes staan in [app/routes/api.php](app/routes/api.php) en hebben de prefix `/api`.

1. Log in met `POST /api/login` (`email` of `phone` + `password`).
2. Gebruik de teruggegeven `token` als header bij elke volgende request:

```
Authorization: Bearer <token>
Accept: application/json
```

Belangrijkste endpoints:

| Methode | Endpoint                                   | Toegang                     |
|---------|--------------------------------------------|-----------------------------|
| POST    | `/register`, `/login`                      | publiek                     |
| GET     | `/help-request-categories`                 | publiek                     |
| GET     | `/user` · POST `/logout`                   | ingelogd                    |
| GET/PUT | `/clients`, `/volunteers`                  | ingelogd                    |
| *       | `/help-requests`                           | ingelogd + actief abonnement|
| POST    | `/help-requests/{id}/accept`               | vrijwilliger                |
| *       | `/appointments`                            | ingelogd + actief abonnement|
| *       | `/intakes`                                 | adviseur                    |
| PATCH   | `/users/{id}/verify` · DELETE `/users/{id}`| adviseur                    |
| GET     | `/subscriptions`                           | ingelogd                    |
| POST/PUT/PATCH/DELETE | `/subscriptions…`            | adviseur                    |

Lijst-endpoints ondersteunen paginatie met `?per_page=` en het meeladen van relaties met `?include=`.

## E-mail

Standaard staat `MAIL_MAILER` op `log`: verzonden mails komen dan in `app/storage/logs/laravel.log` terecht in plaats van echt verstuurd te worden. Wil je echte mails versturen, vul dan de `MAIL_*`-variabelen in `app/.env` in (bv. met een SMTP-server of Mailtrap).

## Tests en codestijl

In de webcontainer (`docker-compose exec -u 1000:1000 php-web bash`):

```shell
php artisan test          # tests uitvoeren
./vendor/bin/pint         # code automatisch formatteren
./vendor/bin/pint --test  # alleen controleren (zoals in de CI)
```

## CI/CD

De GitLab-pipeline ([.gitlab-ci.yml](.gitlab-ci.yml)) doorloopt bij elke push:

1. **build** – `composer install` en `.env` aanmaken
2. **lint** – codestijl controleren met Laravel Pint
3. **test** – `php artisan test`
4. **deploy** (alleen `master`) – via rsync/SSH naar de Plesk-server, gevolgd door `migrate --seed` en `optimize`

## Problemen oplossen

**Rechtenproblemen bij schrijven naar `storage` (WSL2)**

```shell
sudo chown $USER:$USER -R .
docker-compose exec -u 1000:1000 php-web bash
chmod 777 -R storage bootstrap/cache
```

**Een container start niet**

Waarschijnlijk is poort `8080`, `8000` of `3307` al in gebruik. Bekijk de output van `docker-compose ps -a`, pas de poort aan in `docker-compose.yml` en start opnieuw.

## Links

- [Laravel 12 documentatie](https://laravel.com/docs/12.x)
- [Laravel Sanctum](https://laravel.com/docs/12.x/sanctum)
- [MySQL 8.4 Reference Manual](https://dev.mysql.com/doc/refman/8.4/en/)

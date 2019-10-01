## Telemedico - Zadanie testowe telemedico

# Instalacja

 - 1) Pobieranie repozytorium - należy sklonować archiwum
 - Komenda: git clone https://github.com/paulpiotr/telemedico.git
 - 2) Composer Update - należy zainstalować biblioteki
 - Komenda: composer update
 - 3) Baza danych:

 - Dane do logogania zmieniamy w pliku .env Dla potrzeby projektu przykładowa konfiguracja: 

- DB_HOST=127.0.0.1
- DB_USER=telemedico
- DB_PASSWORD=telemedico
- DB_NAME=telemedico
- DB_PORT=5432

- DATABASE_URL=pgsql://${DB_USER}:${DB_PASSWORD}@${DB_HOST}:${DB_PORT}/${DB_NAME}

 - 4) Instalacja schematu:
 - Komenda: php bin/console doctrine:migrations:migrate
 - lub z pliku w lokalizacji: src/Migrations/schema.sql

 # Konfiguracja apache:

- <VirtualHost DOMENA:80>
- ServerName DOMENA
- DocumentRoot KATALOG WWW/DOMENA/public
- <Directory KATALOG WWW/DOMENA/public>
-     Require all granted
-     Options FollowSymlinks
-     <IfModule mod_rewrite.c>
-         Options -MultiViews
-         RewriteEngine On
-         RewriteCond %{REQUEST_FILENAME} !-f
-         RewriteRule ^(.*)$ index.php [QSA,L]
-     </IfModule>
- </Directory>
- ErrorLog KATALOG WWW/DOMENA/error.log
- CustomLog KATALOG WWW/DOMENA/access.log combined
- </VirtualHost>

 # Wywoływanie komend:

  - Nowy user bez logowanie:
  - curl -X PUT -H 'Accept: application/json' -i http://telemedico/user/new --data '{"email":"paul.piotr@gmail.com","password":"qwerty"}'
  - Nowy user z logowaniem:
  - curl -X PUT -H 'Accept: application/json' -i 'http://telemedico/user/add/paul.piotr@gmail.com/qwerty' --data '{"email":"paul.piotr@gmail.com","password":"qwerty"}'
  - Logowanie:
  - curl -X PUT -H 'Accept: application/json' -i 'http://telemedico/user/login/paul.piotr@gmail.com/qwerty'
  - Usuwanie użytkownika:
  - curl -X PUT -H 'Accept: application/json' -i 'http://telemedico/user/delete/2/paul.piotr@gmail.com/qwerty'

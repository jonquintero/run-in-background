# Ping CRM


Install PHP dependencies:

```sh
composer install
```

Install NPM dependencies:

```sh
npm ci
```

Build assets:

```sh
npm run dev
```

Setup configuration:

```sh
cp .env.example .env
```

Generate application key:

```sh
php artisan key:generate
```

Run database migrations:

```sh
php artisan migrate
```

Run database seeder:

```sh
php artisan db:seed
```

Run the dev server (the output will give the address):

```sh
php artisan serve
```

You're ready to go! Visit Ping CRM in your browser, and login with:

- **Username:** johndoe@example.com
- **Password:** secret

## See Crawl Information
Run this command:

```sh
php artisan queue:listen
```

- After sending the search parameter, a redirect to the "crawl" route is made, please press refresh in your browser so that it can display the data found.
- If you want to delete the information from the database, you must do it manually

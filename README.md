# Lionheart

Comments app. Uses Laravel 5.8 + Vue 2.6

## Installation

### Clone repo

### Change to directory

````
cd lionheart
````   

### Install dependencies

````
composer install
````

### Copy .env file

```
cp .env.example .env
```

### Modify `DB_*` value in `.env` with your database config.

### Enter Facebook and Google app credentials in `.env` file.

### Generate application key:

````
php artisan key:generate
````

### Migrate
````
php artisan migrate
````

### Install Node modules
````
npm install
````

### Build

````
npm run dev
````

or for real-time building

````
npm run watch
````

# WishBox

### Requirements
- Composer
- PHP >= 7.0
- MySQL

### Install dependencies
```shell
composer install
```

### Set environnement variables
```shell
cp .env.example .env
```

Create a MySQL database and configure access to it in .env file

### Migrate database then fill tables 
```shell
php artisan migrate --seed
```

### Run application
```shell
php artisan serve
```





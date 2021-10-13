# Laravel Sql Migrations

**Commands to use a sql approach for migrations**

*This repository now is only for postgre!!!*

* ### How to install:
```bash
composer require igorhaf/laravel-sql-migrations
```
**In the config folder declare the service provider in the app.php**
```php
[
    ...
    
    Igorhaf\LaravelSqlMigrations\LaravelSqlMigrationsProvider::class
    
    ...
],
```
**Publish the config file**
```bash
php artisan vendor:publish --provider="Igorhaf\LaravelSqlMigrations\LaravelSqlMigrationsProvider"
```

* ### How to use:

####We have 3 commands for migrate with sql files.

* To create a new migration sql file:

```bash
php artisan sql-migration:create name_of_migration
```

* To migrate all sql files on the migration folder (can be changed on config file):

```bash
php artisan sql-migration:migrate
```


* Fresh migrate clear and refactoring all data in sql files, **warning** this will **destroy** all data in the database :

```bash
php artisan sql-migration:fresh
```


**Todo:**
* **Mysql** compatibility
* **MariaDB** compatibility
* **SqlServer** compatibility




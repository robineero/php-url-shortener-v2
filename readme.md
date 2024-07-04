# URL Shortener in PHP

## sqlite3

Create database. Install sqlite3 and create database in command line.

~~~
sqlite3
.save data.db
~~~

In php.ini uncomment extension=pdo_sqlite and extension=sqlite3.

## Composer packages

~~~
vlucas/phpdotenv
twig/twig
~~~

`composer dump-autoload` - run after updating autoload configuration.

## htaccess

~~~
RewriteEngine On
RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]
RewriteBase /redirect/
RewriteRule ^index\.php$ - [L]
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule . /redirect/index.php [L]
~~~
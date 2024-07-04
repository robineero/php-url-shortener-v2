# URL Shortener in PHP

## sqlite3

Create database. Install sqlite3 and create database in command line.

~~~
sqlite3
.save data.db
~~~

In php.ini uncomment extension=pdo_sqlite and extension=sqlite3.

## Composer packages

[Dotenv](https://www.youtube.com/watch?v=qAkxQIYHlUw) for variables, twig for templating. [Doctrine](https://www.youtube.com/watch?v=bfTIVQvS5JI) for queries

~~~
vlucas/phpdotenv
twig/twig
doctrine/dbal
~~~

`composer dump-autoload` - run after updating autoload configuration.

## htaccess

Replace "redirect" with the name of the directory.

~~~
RewriteEngine On
RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]
RewriteBase /redirect/
RewriteRule ^index\.php$ - [L]
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule . /redirect/index.php [L]
~~~
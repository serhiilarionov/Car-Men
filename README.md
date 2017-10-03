## The CarMen project based on Laravel 5 framework

**Install PostgreSql For Ubuntu 15.04**

A detailed documentation is here http://trac.osgeo.org/postgis/wiki/UsersWikiPostGIS21UbuntuPGSQL93Apt


Add Keys

```sh
wget --quiet -O - http://apt.postgresql.org/pub/repos/apt/ACCC4CF8.asc | sudo apt-key add -
sudo apt-get update
```


Install postgresql 9.4, PostGIS, PGAdmin3

```sh
sudo apt-get install postgresql-9.4-postgis-2.1 pgadmin3 postgresql-contrib php5-pgsql
```


Install pgRouting

```sh
sudo apt-add-repository -y ppa:georepublic/pgrouting
sudo apt-get update
sudo apt-get install postgresql-9.4-pgrouting
```


Create new PGSQL user

```sh
sudo su - postgres
createuser -d -E -i -l -P -r -s yourUserName
```


Enable postgis extensions on new database. You must create new database in PgAdmin before it.
Expand the database tree in PGAdmin, and reveal the extensions node
Right-click the extensions node, and click new extension
Enable the next extensions: postgis, postgis_topology, fuzzystrmatch and postgis_tiger_geocoder

Reboot Apache

```sh
sudo service apache2 restart
```


**Install the project**

1. Clone project from repository

2. Run "composer install"

3. Prepare configuration in ".env" file (copy .env.example and change it)

4. Run migrations "php artisan migrate"

5. Run seeds "php artisan db:seed"

6. Set full permissions to storage folder "chmod -R 777 storage"


Before each pull recommends make migration reset "php artisan migrate:reset" and after pull make migration "php artisan migrate" and "php artisan db:seed"
Or simple "php artisan migrate:refresh --seed"

If you have an error "class not found" - try to run "composer dump-autoload"
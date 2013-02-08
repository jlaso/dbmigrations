**DB Migrations for my projects based on IdiORM**

Joseluis Laso <info@joseluislaso.es>

Clone project
```
cd app/models
git clone git://github.com/jlaso/dbmigrations.git

```
folder hierarchy
```
   app
     - models
         - dbmigrations
           - migrations*
   vendor
     - Idiorm
   server.php

```

## Instructions

First copy server_sample.php into ../../server.php and correct data to access your DB


Clone migration_sample.php into migrations folder to _migrationYYYYMMDDHHMMSS.php_ where
YYYY,MM,DD are year,month and day respectively and HH,MM,SS are hour, minute and second
respectively.

Into the migrate method of _migrationYYYYMMDDHHMMSS_ class execute the sql intructions that
let the DB in a determinate state.

In this way you can reconstruct your DB doesn't matter which version are DB.

Obiously the body of migrate method can execute simple or very complex sql sentences but
is important to have in mind this little notes:

- use IF NOT EXISTS clause in the CREATE TABLE cases
- recommended process that converts columns that are execute in two or more
steps, first create new column, second foreach row convert data, next delete original collumn and
finally rename column


**For migrate**


```
php migrate.php

```

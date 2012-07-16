# Preparation

## PostgreSQL

The PostgreSQL server comes preinstalled. However it has not been possible (yet) to setup the password for the postgres administrator.

You have to do this per hand, if you wish to use a PostgreSQL Database.

Open a console and enter ```su``` to become **root** (remember the root password is **root**)

<div class="console">
```
$ su
password:
#
```
</div>

Now change the user to **postres** and start the postgres console with psql
<div class="console">
```
# su postgres -c psql postgres
```
</div>

From the PostgreSQL prompt change the password to **postgres**
<div class="console">
```
postgres=# ALTER USER postgres WITH PASSWORD 'postgres';
ALTER ROLE
```
</div>

Quit the prompt
<div class="console">
```
postgres=# \q
```
</div>


And restart the service
<div class="console">
```
# rcpostgresql restart
```
</div>

You should now be ready to create databases or run the Joomla CMS system tests for PostgreSQL.

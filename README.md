sf2.8
=====

A Symfony project created on March 7, 2016, 12:24 pm.

initialisation du projet
php app/console doctrine:database:create
php app/console doctrine:schema:update  --dump-sql
php app/console doctrine:schema:update  --force

#lancer le serveur
php app/console server:run

#les routes
php app/console debug:route
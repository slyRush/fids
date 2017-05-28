sf2.8
=====

A Symfony project created on March 7, 2016, 12:24 pm.

#initialisation du projet
php app/console doctrine:database:create
php app/console doctrine:schema:update  --dump-sql
php app/console doctrine:schema:update  --force

#creation utilisateur

php app/console fos:user:create nomUtilisateur monemail@example.com monp@ssword
php app/console fos:user:activate nomUtilisateur
php app/console fos:user:promote nomUtilisateur ROLE_ADMIN

#lancer le serveur
php app/console server:run

#les routes
php app/console debug:route
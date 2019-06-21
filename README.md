INSTALL
========================

Pour installer le projet, suivre les étapes suivantes:
**Backend**
*1 - Cloner le repos git suivant :* 
git clone https://github.com/devgourram/app-transactions.git

*2 - Accèder au répértoire du projet et lancer l'installation des dépendances :*
cd app-transactions && composer install 
 
*3 - Lors de l'installation, renseigner la configuration de la base de données*
 
*4 - Création de la base de données & schéma*
php bin/console doctrine:database:create && php bin/console doctrine:schema:update --force

*5 - Chargement des fixtures*
php bin/console doctrine:fixtures:load --no-interaction

*6 - Démarrer le serveur PHP*
php bin/console server:run

*7 - Accèder à l'url suivante*
http://localhost:8000/app.php/transactions
    

**Front**

*1 - Accéder au dossier app-transactions/front*

*2 - Installation des dépendences*
npm install

*3 - Lancer l'application*
ng serve

*4 - Accèder à l'url suivante*
http://localhost:4200/



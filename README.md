Prerequis
- PHP version 8
- Serveur web(Laragon)

Recommandation
Il est recommandé d'utiliser le logiciel de serveur Laragon au lieu de Wampserver pour 
assurer la stabilité de l'application 

Installation de PHP 8 dans Laragon
copier le dossier php verion 8,ouvrez le fichier bin de le dossier d'installation de Laragon, 
puis ouvrez le dossier php, supprimer le dossier à l'interieur
et puis collez le dossier php verion 8


Collez le projet dans le dossier www de laragon


Utilisation de l'application
Pour commencer vous devez vous connecter avec les informations suivante:
- email: admin@gmail.com
- password: password

Une fois connecté, vous devez changer modifier votre profil dans la section profil

Avant tout, si vous avez oublié d'importer la base de données du projet 
creer une nouvelle BDD, puis vous ouvrez le fichier .env et changé DB_DATABASE par le nom de la base de donnée que vous venez de céer.
Puis lancé l'invite du commande, puis spécifié le chemein vers la racine du projet et éxcecuter la commande php artisan migrate
Un compte admin sera génerer aléatoirement dans la base données, vous pouvez connecter à l'aide de ce compte en recuperant l'email dans la BDD le mot de
passe étant: password.

Une fois connecté, vous devez changer modifier votre profil dans la section profil.



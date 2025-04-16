# **Arche**

Ce projet universitaire a pour objectif de reproduire de manière simplifiée la plateforme éducative **Moodle**.

<br>

## **Prérequis**

Avant de démarrer, assurez-vous d’avoir les éléments suivants installés sur votre machine :

- [XAMPP](https://www.apachefriends.org/index.html)
- PHP ≥ 8.2
- [Symfony](https://symfony.com/download) ≥ 7.0.0

<br>

## **Installation**

Ouvrir un terminal dans le répertoire `htdocs` de votre installation XAMPP, puis cloner le dépôt :

* Avez une clé SSH :
```bash
git@github.com:giuliana-fabrizio/Arche.git
```

* Sans clé SSH :
```bash
https://github.com/giuliana-fabrizio/Arche.git
```

<br>

## **Initialisation**

### **1. Création du fichier `.env`**

À la racine du répertoire `arche`, créer un fichier nommé `.env`. Ce fichier doit contenir les variables suivantes :

- APP_ENV
- APP_SECRET
- DATABASE_URL au format suivant :

```env
DATABASE_URL="mysql://nom_utilisateur:mot_de_passe@127.0.0.1:port_database/nom_database?serverVersion=8.0.32&charset=utf8mb4"
```

<br>

### **2. Installation des packages nécessaires**

Toutes dépendances qui permettent le bon fonctionnement de l'application sont définies dans le fichier `composer.json` à la racine du répertoire `arche`.

Pour les installer, exécutez les commandes suivantes dans un terminal ouvert depuis le dossier du projet :

```bash
cd arche
composer install
```

<br>

### **Création de la base de données**

Pour créer la base de données MySQL, exécuter la commande suivante :
```bash
php bin/console doctrine:database:create
```

Puis, pour exécuter les instructions permettant de créer les tables dans la base :
```bash
php bin/console doctrine:migrations:migrate
```

Enfin, pour récupérer les fixtures, exécuter la commande qui suit :
```bash
php bin/console doctrine:fixtures:load
```

<br>

### **Lancement du projet**

Pour démarrer l'application et l'ouvrir dans votre  navigateur exécuter :
```bash
symfony server:start
```

Pour arrêter l'application exécuter la commande suivante :
```bash
symfony server:stop
```
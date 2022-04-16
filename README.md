# KametoTV

Site web permettant d'avoir les dernières nouveautés du youtuber Kameto.

## Table de matières

* [Introduction](#introduction)
* [Technologies](#technologies)
* [Installation](#installation)
* [Fonctionnalités](#fonctionnalites)
* [Liens externes](#externes)
* [Créateurs](#credits)

## Introduction <a name="introduction"></a>

Nous avons crée un site permettant de visionner les dernières vidéos/stream de Kameto ainsi que d'acheter des goodies
dans sa boutique.

## Technologies <a name="technologies"></a>

Le projet a été crée à l'aide de :

* Symfony version : 6.0
* Bootstrap version : 4.4.1
* Twig : 6.0
* MySQL : 5.1.1

## Installation <a name="installation"></a>

Cloner le projet, crée une base ded données nommé kameto et lancer les commandes suivantes dans l'ordre indiqué :

    composer install

    php bin/console doctrine:migrations:migrate

    php bin/console doctrine:fixtures:load

**Comptes tests**

Pour tester les fonctionnalités des comptes super admin et admin,
nous avons crée d'avance un compte avec pour données de connexion :

    Super Admin :
        username : SuperAdmin
        password : azerty

    Admin : 
        username : Admin
        password : azerty

Vous pouvez aussi crée un compte vous même via la page register et vous donnez le rôle Admin.

NB : Il n'est pas possible de données le rôle Super Admin via la page de gestion des rôles.
## Fonctionnalités <a name="fonctionnalites"></a>

Le site est disponible en 2 langues.

Il existe un système d'inscription, connexion et mot de passe oublié avec des mails (implémenter avec Symfony Mailer)

L'utilisateur admin possède des droits de gestions de catalogue et de la faq.

L'utilisateur super admin peut gerer les autres utilisateurs

Les autres utilisateurs peuvent obtenir des informations sur les goodies de Kameto et ensuite les placer dans leurs
paniers afin de commander. Il est ausis possible de visualiser ses commandes passés.

A l'aide des API Google et Twitch, il est possible de visionner les dernières vidéos de Youtube et stream de Twitch

## Liens externes <a name="externes"></a>

Tableau de gestion GitHub Project : https://github.com/L3Web/KametoTV/projects/2

Base de données sous format SQL :

Diagramme de la base : 
## Créateurs <a name="credits"></a>

Etudiants en L3 MIAGE :


* Elodie : Product Owner
* Mehdi
* Florent
* Alix
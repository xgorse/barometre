Baromètre
=========

[![Build Status](https://secure.travis-ci.org/afup/barometre.png?branch=master)](http://travis-ci.org/afup/barometre)

Lors du forum PHP 2013 l’Association Française des Utilisateurs de PHP (AFUP) et le cabinet de recrutement spécialisé Agence-e ont publié le résultat d'une enquête auprès des développeurs PHP : [le baromètre AFUP – Agence-e 2014](http://afup.org/docs/barometre/Barometre-AFUP-Agence-e-2014-Les-salaires-de-l-ecosysteme-PHP-en-France.pdf) présentant la rémunération des développeurs PHP ainsi que l’écosystème PHP en France.

Ce site a pour vocation de présenter les résultats de cette enquête en permettant de filtrer sur différents critères (le département, la rémunération, le type d'entreprise...) pour ainsi présenter des résultats plus en accord avec la situation du développeur les consultant.


Dépendances
-----------

* [bower](http://bower.io/)
* [grunt](http://gruntjs.com/)
* [sass](http://sass-lang.com/)

Installation
------------

```
php composer.phar install
bower install
npm install
```

Build des assets
----------------

### Si grunt-cli est installé globalement

```
grunt
```

Pour les builder automatiquement à chaque modification :

```
grunt watch
```

### Si grunt-cli n'est pas installé globalement

```
./node_modules/.bin/grunt
```

Pour les builder automatiquement à chaque modification :

```
./node_modules/.bin/grunt watch
```

Construction de la base de donnée
---------------------------------

Création de la base
```
php app/console doctrine:database:create
```

Mise à jour/création du schema
```
php app/console doctrine:schema:update --force
```

Chargement des données de test
------------------------------

Pour charger les données de test, il faut effectuer un

```
php app/console doctrine:fixtures:load --fixtures=src/Afup/BarometreBundle/DataTest/ORM/
```


Installation des hooks de précommit
-----------------------------------

```
grunt githooks
```

Installation de données réelles
-------------------------------

re installation des fixtures

```
php app/console doctrine:fixtures:load
```

chargement des données

```
php app/console barometre:imports  2013 01/05/2013 01/11/2013  ~/Downloads/test.csv
```

pour créer une campagne du 01/05/2013 01/11/2013.

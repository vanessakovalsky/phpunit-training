# Exercice 4 - Découverte et génération d'un rapport de couverture de code

Cet exercice a pour objectifs : 
* de générer un calcul de la couverture de code
* de produire et d'afficher un rapport sur cette couverture de code

## Générer le calcul de la couverture de code

* En préambule, il est nécessaire pour calculer la couverture de code d'installer xdebug : 
```
pecl install xdebug
```

* Afin de générer le calcul de la couverture de code, il est nécessaire de donner des options supplémentaires au binaire d'exécution des tests : 
```
vendor/bin/phpunit --coverage-html /mon_repertoire/coverage
```


## Produire un rapport
* Installer php-code-coverage : 
```
composer require phpunit/php-code-coverage
```
* Créer un fichier Report.php qui contient le code suivant : 
```
<?php declare(strict_types=1);
use SebastianBergmann\CodeCoverage\Filter;
use SebastianBergmann\CodeCoverage\Driver\Selector;
use SebastianBergmann\CodeCoverage\CodeCoverage;
use SebastianBergmann\CodeCoverage\Report\Html\Facade as HtmlReport;

$filter = new Filter;
$filter->includeDirectory('/mon_repertoire/');

$coverage = new CodeCoverage(
    (new Selector)->forLineCoverage($filter),
    $filter
);

$coverage->start('<name of test>');

// ...

$coverage->stop();


(new HtmlReport)->process($coverage, '/mon_repertoire/coverage');
```
* Appeler le fichier php dans le navigateur pour voir le rapport apparaitre
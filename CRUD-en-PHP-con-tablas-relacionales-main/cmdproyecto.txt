Microsoft Windows [Versión 10.0.19045.3693]
(c) Microsoft Corporation. Todos los derechos reservados.

C:\xampp\htdocs\Nueva carpeta02>composer init
PHP Warning:  PHP Startup: Unable to load dynamic library 'zip' (tried: C:\xampp\php\ext\zip (No se puede encontrar el m├│dulo especificado), C:\xampp\php\ext\php_zip.dll (No se puede encontrar el m├│dulo especificado)) in Unknown on line 0
Warning: PHP Startup: Unable to load dynamic library 'zip' (tried: C:\xampp\php\ext\zip (No se puede encontrar el m├│dulo especificado), C:\xampp\php\ext\php_zip.dll (No se puede encontrar el m├│dulo especificado)) in Unknown on line 0


  Welcome to the Composer config generator



This command will guide you through creating your composer.json config.

Package name (<vendor>/<name>) [cacer/nueva carpeta02]: composer init
The package name composer init is invalid, it should be lowercase and have a vendor name, a forward slash, and a package name, matching: [a-z0-9_.-]+/[a-z0-9_.-]+
Package name (<vendor>/<name>) [cacer/nueva carpeta02]: jhack/nueva-carpeta
Description []: jhack
Author [n to skip]:
Invalid author string.  Must be in the formats: Jane Doe or John Smith <john@example.com>
Author [n to skip]: jhack <cacereshilasacajhack@gmail.com>
Minimum Stability []:
Package Type (e.g. library, project, metapackage, composer-plugin) []:
License []: MIT

Define your dependencies.

Would you like to define your dependencies (require) interactively [yes]? yes
Search for a package: phpoffice/phpspreadsheet

Found 13 packages matching phpoffice/phpspreadsheet

   [0] onurb/excel-bundle
   [1] tanur/excel-bundle
   [2] moveek/excel-bundle
   [3] remember/laravel-spreadsheet
   [4] lyquidity/php-pivottables-4-excel-lite
   [5] nnchutchikov/spreadsheet
   [6] nabu-3/spreadsheet-utils
   [7] mulgor/phpspreadsheet
   [8] marble-d/phpspreadsheet
   [9] drakx116/xlsx-writer
  [10] cyberclick-os/excel-bundle
  [11] ahmadyusri/phpspreadsheet
  [12] ecbc-phpoffice/phpspreadsheet

Enter package # to add, or the complete package name if it is not listed: 12
Enter the version constraint to require (or leave blank to use the latest version): ^1.0
Search for a package:
Would you like to define your dev dependencies (require-dev) interactively [yes]?
Search for a package:
Add PSR-4 autoload mapping? Maps namespace "Jhack\NuevaCarpeta" to the entered relative path. [src/, n to skip]:

{
    "name": "jhack/nueva-carpeta",
    "description": "jhack",
    "require": {
        "ecbc-phpoffice/phpspreadsheet": "^1.0"
    },
    "license": "MIT",
    "autoload": {
        "psr-4": {
            "Jhack\\NuevaCarpeta\\": "src/"
        }
    },
    "authors": [
        {
            "name": "jhack",
            "email": "cacereshilasacajhack@gmail.com"
        }
    ]
}

Do you confirm generation [yes]? yes
Would you like to install dependencies now [yes]? yes
Loading composer repositories with package information
Updating dependencies
Lock file operations: 2 installs, 3 updates, 2 removals
  - Removing phpoffice/phpspreadsheet (1.29.0)
  - Removing setasign/fpdf (1.8.6)
  - Locking ecbc-phpoffice/phpspreadsheet (1.24.0)
  - Downgrading maennchen/zipstream-php (3.1.0 => 2.4.0)
  - Locking myclabs/php-enum (1.8.4)
  - Downgrading psr/http-message (2.0 => 1.1)
  - Downgrading psr/simple-cache (3.0.0 => 2.0.0)
Writing lock file
Installing dependencies from lock file (including require-dev)
Package operations: 2 installs, 3 updates, 2 removals
  - Downloading psr/simple-cache (2.0.0)
  - Downloading psr/http-message (1.1)
  - Downloading myclabs/php-enum (1.8.4)
  - Downloading maennchen/zipstream-php (2.4.0)
  - Downloading ecbc-phpoffice/phpspreadsheet (1.24.0)
  - Removing setasign/fpdf (1.8.6)
  - Removing phpoffice/phpspreadsheet (1.29.0)
  - Downgrading psr/simple-cache (3.0.0 => 2.0.0): Extracting archive
  - Downgrading psr/http-message (2.0 => 1.1): Extracting archive
  - Installing myclabs/php-enum (1.8.4): Extracting archive
  - Downgrading maennchen/zipstream-php (3.1.0 => 2.4.0): Extracting archive
  - Installing ecbc-phpoffice/phpspreadsheet (1.24.0): Extracting archive
4 package suggestions were added by new dependencies, use `composer suggest` to see details.
Generating autoload files
2 packages you are using are looking for funding.
Use the `composer fund` command to find out more!
No security vulnerability advisories found.
PSR-4 autoloading configured. Use "namespace Jhack\NuevaCarpeta;" in src/
Include the Composer autoloader with: require 'vendor/autoload.php';

C:\xampp\htdocs\Nueva carpeta02>

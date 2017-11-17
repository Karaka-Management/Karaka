# Installation

Installing the application as a developer can be achived by following one of the following instructions.

## Server Requirements

* PHP >= 7.1
* PDO PHP Extension

### Recommended Extensions

* Memcache
* Sqlite
* Socket
* Curl
* Imap
* bcmath
* zip
* mbstring

## Linux Shell Script

This is the prefered way to install the application since this also installs all required dev tools and sets up the direcetory structure by itself. Using this method also tears down previous installs for a fresh install perfect for re-installing from the current development version. Furthermore the use of phpUnit also makes sure that the application is working as intended. The phpUnit install also provides lots of dummy data for better integration and functionality testing of your own code/modules.

### Steps

1. Go somewhere where you want to install the build script
2. Enter `git clone -b develop https://github.com/Orange-Management/Build.git`
3. Modify `var.sh`
4. Run `chmod 777 setup.sh`
5. Run `./setup.sh`
6. Modify `config.php`
7. Run `php phpunit.phar --configuration Tests/PHPUnit/phpunit_default.xml` inside `Orange-Management` or open `http://your_url.com/Install`

### Annotation

During this process the database automatically gets dropped (if existing) and re-created. The database user and password can't be changed right now since the install config relies on the same data. Future releases will make use of a new user that will get set up by the install script as well. If you don't have `xdebug` installed but `phpdbg` you can replace `php phpunit.phar ...` with `phpdbg -qrr phpunit.phar ...`.

## FTP Web Install

This only installs an application without any dev tools that may be required by other scripts in order to test your implementations.

### Requirements

1. PHP 7.0
2. xdebug or phpdbg
3. phpunit

### Steps

1. Download all Orange-Management repositories
2. Put all repositories inside the Orange-Management repository
3. Modify `config.php`
4. Run `php phpunit.phar --configuration Tests/PHPUnit/phpunit_default.xml` inside `Orange-Management` or open `http://your_url.com/Install`

### Annotation

During this process the database automatically gets dropped (if existing) and re-created.

# Tests

The applications goal is to achive 90% code coverage, which applies for the core application as well as all modules. All unit tests are located in a separate repository `Tests`.

## PHPUnit

This application uses PHPUnit as unit testing framework. The PHPUnit directory is structured the same way as the `Framework`, `Modules`, `Install` and `Models` directories. Unit tests for specific classes need to be named in the same manner as the testing class.

### Modules

Every module needs to have a `Admin` directory containing a class called `AdminTest.php` which is used for testing the installation, activation, deactivation, uninstall and remove of the module. Tests that install, update, remove etc. a module need to have a group called `admin`. After running the `AdminTest.php` test the final state of the module should be installed and active, only this way it's possible to further test the controller and models. A code coverage of at least 80% is mandatory for every module for integration.

## Jasmine

The javascript testing is done with jasmine. The javascript testing directory is structured the same way as the `Framework`. Unit tests for specific classes need to be named in the same manner as the testing class.
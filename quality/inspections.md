# Inspections

Code inspections are very important in order to maintain the same code quality throughout the application. The Build repository contains all esential configuration files for the respective inspection tools. Every provided module will be evaluated based on the predefined code and quality standards. Only modules that pass all code, quality and unit tests are accepted. This also applies to updates and bug fixes. Any change will have to be re-evaluated.

## Tools

Tools used for the code inspection are:

* PhpMessDetector
* PhpMetrics
* PhpDepend
* PhpCS
* PhpCPD
* PhpUnit (see tests)
* Jasmine (see tests)
* Custom scripts/tools

These tools are all installed by running the `setup.sh` script from the Build repository.

## Configurations

### PhpMessDetector


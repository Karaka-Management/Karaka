# General

The Orange Management build system is a collection of scripts to create builds. Builds that can get created are:

* Public release builds
* Public developer release builds

On top of the release builds the build system can also perform automated code inspections. This allows to run all tests and inspections without interaction and generates a report for developers at the end.

The last feature is the backend and documentation generation based on the DocBlock documentation.

# Setup

* Clone the repository somewhere save
* Modify the `config.sh` file to your needs
* Run `setup.sh`

## Dependencies

The build system will take care of most requirements, the following tools and commands have to be available on the system.

* npm
* git
* wget
* curl
* grep
* xargs
* sed
* php
* php-dom
* php-xdebug

# Usage

* Run `build_dev.sh`
* Run `build_public.sh`
* Run `inspection.sh`

## Inspections

The following inspections are performed:

* Linting
* Security
* Unit tests
* Metrics (loc, dependencies)
* Code quality (crap, code coverage, code style)

In order to perform these inspections the build system relies on third party tools as well as custom scripts.
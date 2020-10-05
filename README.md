# Orange-Management

<p align="center"><img src="https://raw.githubusercontent.com/Orange-Management/Assets/master/art/logo.png" width="256" alt="Logo"></p>

The Orange Management software is a modular web application for small to mid sized companies that need CRM, ERP, Intranet and/or CMS functionalities and much more.

With Orange-Management you have one partner who can provide all the tools and software solutions you are used to at fair and reasonable prices even for small organizations and companies/startups. Our solutions can be used independently from each other or fully integrated with other solutions we provide. By choosing Orange-Management as your partner you'll be able to adjust your software based on the changes in your requirements without worrying about integration and workflow optimization.

## Table of content

- [Orange-Management](#orange-management)
  - [Table of content](#table-of-content)
  - [Installation](#installation)
    - [Requirements](#requirements)
    - [Setup](#setup)
  - [Philosophy](#philosophy)
  - [Development Status](#development-status)
  - [Unit Tests](#unit-tests)
  - [Become a contributor](#become-a-contributor)
  - [Misc](#misc)

## Installation

### Requirements

Some of the following requirements are only necessary for developers and not for end-users:

* PHP 7.4
* PHP extension: php7.4-cli php7.4-common php7.4-mysql php7.4-pgsql php7.4-xdebug php7.4-json php7.4-opcache php7.4-pdo php7.4-sqlite php7.4-mbstring php7.4-curl php7.4-imap php7.4-bcmath php7.4-zip php7.4-dom php7.4-xml php7.4-phar php7.4-gd php7.4-dev php-pear php7.4-pcov
* apache2 (recommended) or nginx
* mysql-server or postgresql postgresql-contrib
* Make sure that url rewriting is active
* Download the Orange-Management project or clone the Orange-Management repository (incl. submodules).

### Setup

After installing the requirements and configuring the webserver for the correct path navigate to https://your_url.com/Install and follow the installation process. Afterwards you will be redirected to the installed backend.

For more detailed information please checkout the [Installation Guide](https://orange-management.org/dev/guide?page=setup/installation) for developers or the [Installation Guide](https://orange-management.org/info?page=setup/server) for end-users.

## Philosophy

We believe software should support a business in it's daily tasks and growth in a very efficient way without frustration. In order to achieve this we constantly take feedback from our customers and expand and improve our software solutions.

Since we believe in our software and transparent business model you can live test parts of our application and it's modules in our demo application at https://orange-management.app (user: admin, pass: orange) without any registration or inquiry. This can be done even during the development phase.

## Development Status

Currently Orange Management is still developing the first Alpha version. As soon as we have a running Beta version we are allowing external testers to use our software and a selected amount of inhouse developed modules.

General updates can be found in our info section at https://orange-management.org/info and developer updates can be found in our developer section at https://orange-management.org/dev. In our developer section you can also check out the automatically generated reports such as code coverage, code style, static analysis etc. as well as our code style guide lines and developer documentation.

![Preview](https://raw.githubusercontent.com/Orange-Management/Assets/master/art/preview.png)

## Unit Tests

Run the following command in the repository directory of the web application for unit tests:

```
php .\phpunit.phar --configuration ./tests/phpunit_default.xml
```

This command will also generate the code coverage reports in the `./Build/coverage/` directory of the whole application (including framework unit tests).

## Become a contributor

Orange-Management has a very open culture and we always welcome new people who share our philosophy in providing create solutions which just work. Please contact us if you are interested in working together on our application.

* PHP Developer
* JS Developer
* Artist and/or Frontend
* DevOps

Check out https://orange-management.org/career and our developer section https://orange-management.org/dev for more information.

## Misc

* Languages: PHP, JS, HTML, CSS
* Website: [https://orange-management.org](https://orange-management.org)
* Demo: [https://orange-management.app](https://orange-management.app) (user: admin, pass: orange)
* Dev: [https://orange-management.org/dev](https://orange-management.org/dev)
* Contact: dennis@orange-management.email

# Karaka

<p align="center"><img src="https://raw.githubusercontent.com/Karaka-Management/Assets/master/art/logo.png" width="256" alt="Logo"></p>

The Karaka software is a modular web application for small to mid sized companies that need CRM, ERP, Intranet and/or CMS functionalities and much more.

With Karaka you have one partner who can provide many tools and software solutions you are used to at fair and reasonable prices even for small organizations and companies/startups. Our solutions can be used independently from each other or fully integrated with other solutions we provide. By choosing Karaka as your partner you'll be able to adjust your software based on the changes in your requirements without worrying about integration and workflow optimization.

## Table of contents

- [Karaka](#karaka)
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

* PHP 8.0
* PHP extension: php8.0 php8.0-dev php8.0-cli php8.0-common php8.0-mysql php8.0-pgsql php8.0-xdebug php8.0-opcache php8.0-pdo php8.0-sqlite php8.0-mbstring php8.0-curl php8.0-imap php8.0-bcmath php8.0-zip php8.0-dom php8.0-xml php8.0-phar php8.0-gd php-pear
* apache2 (recommended) or nginx
* mysql-server (recommended) or postgresql postgresql-contrib
* Make sure that URL rewriting is active!
* Download the Karaka project or clone the Karaka repository (incl. submodules).

#### Optional

The following tools and libraries may be neccessary depending on the features you would like to use:

* Redis or Memcached
* tesseract-ocr
* pdftotext
* pdftoppm

#### Developer tools

* Php extension: xdebug
* Tools: Composer, Npm
* Composer tools: phpstan, phpunit, phpcs
* Npm tools: eslint

### Setup

#### End-User

After installing the requirements and configuring the web server for the correct path navigate to https://your_url.com/Install and follow the installation process. Afterwards you will be redirected to the installed backend.

For more detailed information please checkout the [Installation Guide](https://karaka.app/dev/guide?page=setup/installation).

#### Developer

https://github.com/karaka-management/Developer-Guide/blob/develop/general/setup.md

## Philosophy & Demo

We believe software should support a business in it's daily tasks and growth in a very efficient way without frustration. In order to achieve this we constantly take feedback from our customers and expand and improve our software solutions.

Since we believe in our software and transparent business model you can live test parts of our application and it's modules in our demo application at https://karaka.app (user: admin, pass: orange) without any registration or inquiry.

## Development status

Currently Karaka is still developing the first Alpha version. As soon as we have a running Beta version we are allowing external testers to use our software and a selected amount of inhouse developed modules.

General updates can be found in our info section at https://karaka.app/info and developer updates can be found in our developer section at https://karaka.app/dev. In our developer section you can also check out the automatically generated reports such as code coverage, code style, static analysis etc. as well as our code style guide lines and developer documentation.

![Preview](https://raw.githubusercontent.com/Karaka-Management/Assets/master/art/preview.png)

## Tech stack

* Language: php, js, c++, html, css, markdown, shell script
* Database: Maria/MySQL, PostgreSQL, MSSQL, SQLite
* Webserver: apache2, nginx
* Cache: Redis, Memcached

## Become a contributor

Karaka has a very open culture and we always welcome new people who share our philosophy in providing create solutions which just work. Please contact us if you are interested in working together on our application.

* PHP Developer
* JS Developer
* Artist and/or Frontend
* DevOps

Check out https://karaka.app/career and our developer section https://karaka.app/dev for more information.

## Misc

* End-User documentation: https://github.com/Karaka-Management/Documentation
* Developer documentation: https://github.com/Karaka-Management/Developer-Guide
* Website: [https://karaka.app](https://karaka.app)
* Demo: [https://karaka.app](https://karaka.app) (user: admin, pass: orange)
* Dev: [https://karaka.app/dev](https://karaka.app/dev)
* Contact: dennis@karaka.email

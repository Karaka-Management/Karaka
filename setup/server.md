# Server Setup

The server setup instructions only explain which requirements must be met in terms of software and version. Install instructions for these components can be found in various online documentations.

## Linux

### Web Server

Make sure you have a web server installed such as `Apache` or `Nginx`. If not install one through your package manager. Google for `How to install Apache on XYZ`

#### Apache

#### Nginx

### Database

Make sure you have a database installed such as `MySQL` or `Postgresql` and the corresponding drivers and php modules. If not install one through your package manager. Google for `How to install mysql on XYZ`

### Php

The required php version is 7.1. Install php through your package manager, this may require you to add one additional repository to your package manager. Google for `How to install php 7.1 on XYZ`

Modules for php that may be required depending on your use case are:

* Memcache
* Sqlite
* Socket
* Curl
* Imap
* bcmath

Some of these modules are already provided and only need to be activated in your `php.ini` file.

### Other

Depending on your use case you may have to install the following software as well:

* Memchache or Redis (prefered)

## Windows

On windows the easiest way to install all necessary components is to download the Bitnami stack. This includes php, mysql and various modules which may only need to be activated in the `php.ini` config file.

## OSX

## php.ini


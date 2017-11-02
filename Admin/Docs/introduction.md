# Introduction

The **Admin** module is one of the essential core modules that is always required. This module handles basic account, group and module management.

## Target Group

The target group for this module is everyone, since every application must have this module. However mainly administrators should have access permissions to this module since core application settings can be changed. 

# Setup

This module doesn't have any additional setup requirements since it is installed during the application install process. This module cannot be uninstalled if it is manually deleted from the hard drive please manually download the module from the page and put it into the `Modules/` directory.

# Features

## Application Settings

The module provides basic application settings such as:

### Security

The following are only the customizable security settings. Many security settings are fixed within the application and in addition security settings (e.g. iptables) should be done on the server-side.

* Password structure
* Password change interval
* Auto updates for modules

### Localization

The localization settings are only for the server, accounts can have their own localization settings which is especially important for international use.

* Location
* Language
* Time format
* Numeric (number and currency format)
* Units (weight, speed, length, temperature, etc.)

## Account Management

The account management allows to create, modify and delete accounts. Accounts can get assigned to groups and individual permissions. It's easy to see which groups and permissions one account is assigned to. Every account has a numeric ID larger 0.

### Account Type

Accounts can have the following types:

* Person
* Organization

This allows organizations to have an account and also normal users. It's also possible to assign an account to an organization which allows for permission management in one organization. 

The use case for this could be one customer account for a company and user accounts assigned to the company which each have different permissions within the company. The purchase department of a company e.g. could be able to see their orders while only the financial department of that company is allowed to see the accounts payable of their company.

### Account Status

Accounts can have the following status:

* Active (login possible)
* Inactive (login not possible)
* Banned (login not possible)
* Timeout (login possible in x-minutes)

The status doesn't represent account activity it's only perpose is to allow or disallow the login to the application. Only active accounts can login to the application. It is often necessary to create accounts in the system for ineraction but disallow them to login to the system, this can be achived by simply assigning the inactive status.

## Group Management

The group management allows to create, modify and delete groups. Groups can get assigned to other groups which lets the group inherit permissions from the other groups. It is also possible to assign individual permissions to a group. In the group accounts can be added and it's easy to see which accounts are part of the group.

Groups have a numeric ID larger 0. Every module has its own permission/group range. Modules can pre-define groups upon installation for easier use, every module can have up to 99,999 groups AND permissions.

## Module Management

The module management allows to install, update, delete and configure modules. The configuration of every module can be different depending on the functionality of the module. 

Modules can be installed either manually by uploading the module directly to the `Modules/` directory or via online installation. The online installation requires the php module `curl`.

In the module you can see which groups have permissions belonging to the module, which permissions are available for the module and what their effect is.

# Recommendation

Other modules that work great with this one together are:

* [Job](Job)
* [Monitoring](Monitoring)
* [Backup](Backup)
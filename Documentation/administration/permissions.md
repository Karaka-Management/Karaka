# Permissions

Permissions can be assigned to accounts or groups. In most cases it is recommended to assign to groups since it's easier to modify the permissions of one group instead of the permissions of multiple accounts. 

## Permission

Permissions are:

* Create (C)
* Read (R)
* Update/Modify (U)
* Delete (D)
* Permission (P)

### Create

The create permission is used in order to allow an account to create something (e.g news article, task, media file etc.)

### Read

The read permission is used to allow a user to read data (e.g. news article, media file etc.)

### Update/Modify

The update/modify permission is used to allow a user to modify data (e.g. news article, media file etc.)

### Delete

The delete permission is used to allow a user to delete data (e.g. news article, media file etc.). However deleting something doesn't always mean that the data is completely removed. In some cases it's not possible or allowed to delete data (e.g. customer data for tax purposes). In such a case delete is usually interpreted as *hide data*.

### Permission

The permission permission is used to allow a user to modify or give other users permission for certain features.

## Level

These permissions can be assigned on multiple levels (descending in the following order):

* Unit/Organization
* Application
* Module
* Type
* Element
* Component

### Unit/Organization

`Orange Management` supports the definition of multiple units/organizations which is especially usefull for organizations with subsidiaries or business units etc. For each unit/organization permissions can be assigned to accounts.

### Application

Every unit/organization can have multiple applications. One application could for example have a shop application and ticket application, another unit/organization may only have the shop application. However accounts may only need certain permissions for certain applications in certain units/organizations. Consider a business with subsidiaries where accounts in the subsidiaries should not have the same permissions as the accounts in the parent business.

### Module

Different modules provide different features, by defining the modules permissions can be managed more granular. A sales person for example doesn't need access to R&D for example.

### Type

Often a module provides multiple features or functionalities. The type can be used to give accounts even more specific permissions. In a organization an account may be allowed to create new invoices for customers but is not allowed to create a new customer. 

### Element

The element is the unique element the account has the defined permissions for. In some cases it's necessary that an account only has permissions to specific elements. In a company a customer account for example should only have access to invoices for himself and not to invoices of other customers.

### Component

The component is the lowest level for permissions. This is used in order to define (if necessary) permissions for very specific components. In a company some employees may be allowed to adjust customer data but only the accounting department may be allowed to adjust the bank information of a customer.

### Example

For permissions always the next higher level (recursive) is considered (inclusive) in order to check if an account has the necessary permissions. 

If for example an account has all permissions (CRUDP) for one unit/organization but only reading permissions (R) assigned for a certain module in that unit/organization this user will still have all the other permissions (CRUDP) for that module since the unit/orgainization permission definition superseeds the module permissions 

e.g. Account A has the following two permissions: 

1. `CRUDP` for organization `Orange`
2. `R` for module `News` in the organization `Orange`

Since the account has `CRUDP` for the whole organization `Orange` the account also has `CRUDP` for the `News` module.

e.g. Account B has the following two permissions:

1. `C` for organization `Orange`
2. `R` for module `News` in the organization `Orange`

In this case the account has `CR` permissions for the `News` module


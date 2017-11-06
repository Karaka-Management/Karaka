# Accounts

A account is used to bind information to a single person or a group of people. As a result of this a account is either a single person (user account) or an organization (organization account). Please don't confuse these organization accounts with groups or organizations, they are different!

## Organization Accounts

User accounts can be assigned to an organization account (or multiple) if so desired. This way it's possible to create a relation between user accounts and organization accounts. The organization account can manage permissions for all assigned user accounts. This way the organization account can give the assigned useres the same or less permissions than itself has. This way user accounts assigned to the organization account can have access to the same features and information as the organization account. 

A simple example could be an organization account which has invoices and support tickets. The organization account can give user accounts the permission to read the invoices and tickets assigned to that organization. This way an accountant can get assigned the permissions to see the invoices but not the support tickets (which he not necessarily needs).

## Permissions

Accounts can be assigned to groups and thus inherit the permissions of these groups, directly get assigned permissions, or inherit the permissions assigned by organization accounts. Assigning permissions to groups and than assigning these groups to user/organization accounts is the preferred way to manage permissions. 

The reason for this is that in case the permissions need to be changed, they only have to be changed once in the group and all assigned user/organization accounts get updated. If permissions are directly assigned to accounts and they need to be changed in the future, every single account needs to be modified instead of just one or two groups.

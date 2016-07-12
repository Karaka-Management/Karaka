# Application Security

## Passwords

While the application allows to fully customize the password policies it is recommended to not weaken the default settings too much.

### Structure

The password structure is a highly discussed topic however a password with

* At least one upper case letter
* At least one lower case letter
* At least one numeric character
* At least one special character
* At least 8 characters

is one of the business standards. Longer passwords may be required in the future. Just as a quick info in order to convey the importance of these suggestions, a 8 character password with only upper and lower case characters can be found in less than 6 hours. More and different (like numeric and special) characters exponentially increase the time that is required to brute force a password.

### Aging

Passwords should be changed every 3 month. Enforced password changes are very common and prevent people from using the same passwords over a long period and potentially also for many other applications/services. More important this prevents people from using their standard password which they may use at home in a much less secure environment.

## Permissions

The application allows permission handly by user groups and directly by users. It is strongly recommended to lay out a basic organisation schematic and job description for every area. Based on these job descriptions groups should be generated. The permission management through groups is preferred since it's much more verbose and shows a clear structure. While permissions on user basis are in some cases more convenient for quick permission handling they indicate that the actual job function compared to the organization layout is not coherent with the actual tasks that person is performing. Permission handling on user level is strongly advised against and restructuing groups and creating new groups is much cleaner even if in some cases a group only has one account assigned. Permissions for accounts should also get re-evaluated on a regular basis in order to prevent non-active accounts or accounts whose job description changed to have permissions they no longer need.

## Updates

Updates are very important not only to implement the newest features but also to close potential security vulnerabilities. Depending on your server environment automatic security updates can be activated which then will be executed once a day. Alternatively these updates should be performed manually on a regular basis.

## Modules, Extensions, Themes etc.

Only download software components from the official website never trust any third party services. All software components on the official website get tested and reviewed internally in order to ensure no malicious behavior.
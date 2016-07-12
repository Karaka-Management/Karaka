# Server Security

Since server security or operating system security is a very large topic this chapter only provides a rough schematic of some best practices which you should look up on the internet. These are the most common practices and are well documented in many online documentations for multiple operating systems. While these practices and guidelines are the basics for most server administrators they may seem to be confusing or unnecessary for people that have never managed their own server. If you are only using standard webhosting with a simple ftp upload and database system and no ssh or vnc login (vps, root server etc.) the following guidelines don't apply since this should have been already done by any responsible webhost provider.

## Access Restrictions

In general only whitelist user access permissions instead of blacklisting them. In other words don't be afraid to create multiple accounts or user groups for single applications and only give them reading/writing/execution permissions to directories and files they need access to. In case of our applications make sure the virtual user which is running the web server and hence these applications only has permissions to directories and files that it requires. It also doesn't hurt to create different accounts for different applications (web applications, socket applications). This is smart especially since the socket applications require different permissions than the web applications and there is no good reason to give the user account responsible for running the web applications permissions that it doesn't need just so you don't have to create another user or user group for the socket applications.

## HTTPS

HTTPS is a protocol or form of encrypted communication between client and server. It prevents attackers from reading the data beeing sent back and forth between server and client, which can be very critical when we are talking about user, company, customer, employee, private information. Nowadays it's fairly simple and cheap to setup and a must have for every website and application that is accessible through the internet browser. It is recommended to use the free service of Let's encrypt. Since https is a matter of server configuration this cannot be achived by the application itself. Follow the step-by-step instructions of https://certbot.eff.org/ in order to setup https for your own server. Normal webhosting services usually optionally offer https for a premium which you should definately consider. While you'll most likely have to pay your webhosting agency they will do the setup for you. Just remember that the actual certificate can be optained for free and while services may try to sell you more expensive certificates they are essentially the same as the free alternative.

## Root Login

By deactivating root login you can at least prevent yourself from potentially breaking critical system configurations by accident and much more important even if your login credentials get compromised an attacker will be restricted to the permissions of that account while the administrator/root access would compromise not only the files and areas of the web application but also all other programs and directories or in case of a shared server you would also open all doors for attackers to these user files/information.

## Updates

Keep your software updated. This doesn't only apply for the operating system but also all the other software you may be running. A chain is only as strong as it's weakest link and if one of your software components has a security vulnerability this could be potentially used to infect the whole system.

## Login

Implement passwordless login. This way you don't login into your server by using a login password but by generating a specific authentication key. This can be achieved by using ssh authentication and provides another layer of security to your server. At least implement some form of password policy which requires you to change your passwords from time to time.

## Other

There are still many more uncovered topics and tools which definately are worth reading up on.

*. Iptables
*. Monitoring
*. fail2ban
*. UFW
*. Intrusion detection system
*. SFTP vs FTP

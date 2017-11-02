# Updates & Patches

Updates provide functionality improvements where patches provide security and bug fixes. It is always recommended to keep all application components up-to-date. The application either informs administrators about updates for installation or automatically installs them depending on the settings. 

Updates and patches are only concerned with the application and libraries it comes with, system and application updates such as OS, database etc. have to be updated by the system administrator. It is adviced to only perform database updates once they are confirmed to work by Orange Management. 

## Automatic Updates

Automatic updates can be activated in the application settings. In order use automatic updates either Cron or Windows Task Scheduler is required. Updates can be pulled in a custom defined interval thus allowing to perform updates at times with low application load to minimize user interuption.

## Security Ratings

Security updates & patches for the application and libraries follow the Red Hat classification.

### Critical

This rating is given to flaws that could be easily exploited by a remote unauthenticated attacker and lead to system compromise (arbitrary code execution) without requiring user interaction. Flaws that require an authenticated remote user, a local user, or an unlikely configuration are not classed as Critical impact.

### Important

This rating is given to flaws that can easily compromise the confidentiality, integrity, or availability of resources. These are the types of vulnerabilities that allow local users to gain privileges, allow unauthenticated remote users to view resources that should otherwise be protected by authentication, allow authenticated remote users to execute arbitrary code.

### Moderate

This rating is given to flaws that may be more difficult to exploit but could still lead to some compromise of the confidentiality, integrity, or availability of resources, under certain circumstances. These are the types of vulnerabilities that could have had a Critical impact or Important impact but are less easily exploited based on a technical evaluation of the flaw, or affect unlikely configurations.

### Low

This rating is given to all other issues that have a security impact. These are the types of vulnerabilities that are believed to require unlikely circumstances to be able to be exploited, or where a successful exploit would give minimal consequences.
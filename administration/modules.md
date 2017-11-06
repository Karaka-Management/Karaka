# Modules

Modules are smaller components of the application which provide additional features and functionality. Some modules only extend existing modules with new features and other modules provide completely new features. In some cases modules can depend on other modules in order to provide their own features (e.g. a news module requires the media module for uploading and displaying images).

Every module can be managed and configured in the administration panel. Updates and patches can be installed automatically or manually depending on the configuration. Modules just like the application itself provide localization for different languages and countries. Access permissions for accounts and/or groups can be defined per module and even per feature a module provides. 

## Applications

In some cases it's even possible that applications are primarily build around one module. The ticket application for example is responsible for managing support tickets without showing any of the other installed modules compared to the backend where all modules are available. This is done in order to provide a clean and simple interface for users that primarily use this module. Another example would be the message application which primarily provides the features of the Messages module.

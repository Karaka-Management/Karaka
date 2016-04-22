# Modules

The following directory structure should roughly visualize how modules are strucured. The purpose of the different sub-directories and their files will be covered in the following sections.

* {UniqueModuleName}
    * Admin
        * Install
            * Navigation.install.json
            * Navigation.php
        * Update
            * yourUpdateFiles.???
        * Activate.php
        * Deactivate.php
        * Installer.php
        * Uninstall.php
        * Update.php
    * Img
        * modulePreviewImage.jpg
    * Models
        * YourPhPModels.php
        * YourJavaScriptModels.js
    * Theme
        * Backend
            * Css
                * yourCss_1.0.0.css
                * yourScss_1.0.0.scss
            * Img
                * yourTemplateImages.jpg
            * Lang
                * en.lang.php
                * navigation.en.lang.php
            * your_template_files.tpl.php
    * Views
        * YourPhpViews.php
        * YourJavaScriptViews.js
    * Controller.php
    * Controller.js
    * Module{UniqueModuleName}.js
    * info.json

All modules are located inside the `/Modules` directory and their directory name has to be the module name itself without whitespaces.

## Admin

The admin directory contains the install directory as well as the install, delete, update, activate and deactivate script assoziated with this module. The install directory contains installation files required for other modules. The above example contains the two required files for providing navigation information to the navigation module so that the navigation module can display this module in the navigation bar. The navigation installation file as well as all other module installation files must have the same name as the navigation module and will be automatically called on installation if defined in the info.json file. 

The content of the navigation install file highly depends on the module and should be documented in the according module. The additional json file is also required by the navigation module for the installation process. How many additional files and how they have to be structured/named should all be documented in the module documentation. If your module doesn't provide any navigation links or in general doesn't use any other modules, your install directory will be empty.

Some modules can be used without requiring any additional installations it all depends on how the other modules got implemented. Thats also why many modules don't offer any integration at all and 
are almost stand-alone without the possibility to get extended.

### Installer.php

In contrast to the install file for other moduels this file has to follow more strict standards. The following example shows you the bare minimum requirements of a installation file:

```
<?php
namespace Modules\Navigation\Admin;

use phpOMS\DataStorage\Database\DatabaseType;
use phpOMS\DataStorage\Database\Pool;
use phpOMS\Module\InfoManager;
use phpOMS\Module\InstallerAbstract;

class Installer extends InstallerAbstract
{
    public static function install(Pool $dbPool, InfoManager $info)
    {
        parent::install($dbPool, $info);

        switch ($dbPool->get('core')->getType()) {
            case DatabaseType::MYSQL:
                /* Your database setup goes here */
                break;
        }
    }
}
```

If your application doesn't need to implement any database tables for itself the switch statement can be omitted. From the directory structur at the beginning we can however see that some modules accept information form other modules. The following example shows how the navigation module is accepting information during the installation of other modules:

```
public static function installExternal(Pool $dbPool, array $data)
{
    /* What do you want to do with the data provided by $data? */
}
```

Other modules have to create a Navigation.php file inside the install directory with the following method:

```
public static function install(Pool $dbPool)
{
    $navData = json_decode(file_get_contents(__DIR__ . '/Navigation.install.json'), true);

    $class = '\\Modules\\Navigation\\Admin\\Installer';
    $class::installExternal($dbPool, $navData);
}
```

How the receiving module (e.g. Navigation) is accepting information depends on the module itself. The module documentation will also state how the content of the `install(...)` method has to look like. At the same time if you write a module and are accepting information from other modules during their installation you have to document very well how they have to provide these information. Very often however it will not be necessary to let other modules pass these information during installation and only do this during runtime. 

The navigation module is a good example of passing navigation links during installation. The navigation module could request the link information during runtime this would mean that all modules would have to be initialized for every request since the navigation module doesn't know if these modules are providing links or not. By providing these information during the installation, the navigation module can store these information in a database table and query these information for every page request without initializing all modules or performing some file readings.

### Update.php

### Uninstall.php

### Activate.php

### Deactivate.php

## Img

All module specific images (not theme specific images). E.g. Module preview images showing when searching for modules. 

## Models

All models and data mapper classes should be stored in here (PHP & JS). How to create a data mapper for a model is described in the data mapper chapter. All JavaScript files need to be provided unoptimized (not minified or concatenated).

## Theme

The Theme directory contains the current theme for every page this module supports. If a module only supports the backend application there will only be a Backend directory containing the theme for the backend.

### Css

Every page has its own CSS directory. This application only allows the use of SASS/SCSS as preprocessor. All sass/scss files need to be provided as well as the processed CSS files. Make sure to update the version number in the `Controller.php` file. CSS files need to be minimized and if it makes sense concatenated.

### Img

This directory contains all images for this page.

### Lang

The Lang directory contains all language files for this application. Usually there is one language file for the page which will be loaded automatically wherever the module gets loaded (this language file has to exist).

A language file should have the following naming convention:

    {ISO 639-1}.lang.php
    {UniqueModuleName}.{ISO 639-1}.lang.php 

The content of the language file is straight forward:

```
<?php
$return [ '{UniqueModuleName}' => [
    'StringID' => 'Your localized string',
]];
```

All other language files are optional and usually are only required by other modules. The navigation module for example requires an extra language file for the navigation elements. This however should be specified in the modules you want to make use of.

## Views

## Controller.php

## Controller.js

## info.json
# Changelog

## September 2021

### New

#### Admin

* Module settings can have a custom settings page by defining it in the module routing file. The template file should be stored in `\Modules\{Module}\Admin\Settings`.
* Settings now can have a regex pattern for validation. If it is not empty, setting changes must meet the pattern.
* Settings can now be installed by providing a `Admin.install.json` to the Admin module.

#### Media

* The media_type is now a table for custom media types.
* The media_type has a *installExternal* binding similar to uploading media files during module installation or collection creation.
* Media files are now streamed to the user.

#### phpOMS Framework

* Created `deleteRelation` function as opposite to `createRelation`
* Created `deleteModelRelation` as opposite to `createModelRelation`
* `hasMany` definitions in mappers can now have an additional component `['sort' => ['orderBy' => 'memberName', 'sortOrder' => 'DESC/ASC']]` which allows default ordering behavior for hasMany relations. This is useful if a model expects a specific order most of the time.
* Mappers can have a custom ordering which also overwrites the default mapper ordering behavior introduced in this update. The ordering can be called with `::sortBy($memberName, 'ASC/DESC', ...)`

#### UI

* The table UI sort recognizes *ISO 8601* format and sorts them accordingly. Since the template doesn't always output *ISO 8601* formatted times, it is recommended to use the `data-content` attribute to store the *ISO 8601* formatted time. This allows localized visualization but correct sorting behavior.

#### Applications & CMS

* Applications are now installed through the CMS module.
* Applications can have dependencies.
* Applications can provide for other modules.
* Applications can install routes.
* Applications can install navigation elements.
* Applications can install pages.
* Applications can have their own controllers
* Applications have their own install scripts

### Bug fixes

#### UI

* Tables are now overflowing with scroll bars below if the horizontal screen size is smaller than the table.
* Table UI sort performance got improved. The previous sort didn't terminate properly resulting in a infinite loop.
* The table UI sort recognizes pure numeric values and sorts them accordingly instead of alphabetical.

#### Auditor

* Audit logs are created during module status changes incl. module installation.
* Audit logs are now also created during the installation process.

### Other

#### Admin

* The admin group permissions can no longer get modified, which ensures there is always a admin group with sufficient permissions.
* A user can no longer remove himself from the admin group in order to prevent mistakes.

#### UI

* The install script has improved highlighting for mandatory input fields.
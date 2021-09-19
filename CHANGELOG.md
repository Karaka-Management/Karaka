# Changelog

## September 2021 - v0.1.0-alpha

### New

#### Admin

* Module settings can have a custom settings page by defining it in the module routing file. The template file should be stored in `\Modules\{Module}\Admin\Settings`.
* Settings now can have a regex pattern for validation. If it is not empty, setting changes must meet the pattern.

#### Media

* The media_type is now a table for custom media types.
* The media_type has a installExternal binding similar to uploading media files during module installation or collection creation.

#### phpOMS Framework

* Created `deleteRelation` function as opposite to `createRelation`
* Created `deleteModelRelation` as opposite to `createModelRelation`

#### Bug fixes

#### UI

* Tables are now overflowing with scroll bars below if the horizontal screen size is smaller than the table.

#### Auditor

* Audit logs are created during module status changes incl. module installation.

#### Other

#### Admin

* The admin group permissions can no longer get modified, which ensures there is always a admin group with sufficient permissions.
* A user can no longer remove himself from the admin group in order to prevent mistakes.

#### UI

* The install script has improved highlighting for mandatory input fields.
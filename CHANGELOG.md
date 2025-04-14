# Changelog

## April 2022

### New

#### Application

* Add default export scripts (no API calls implemented yet)
* Create filter UI draft (text, number, select, radio, checkbox) (no API calls and frontend logic implemented)

#### Framework

* Form inline and external save, update, add implemented (no API calls implemented yet)
* Allow users to edit table column visibility (e.g. hide information they are not interested in) (no API calls necessary)

## March 2022

### New

#### Application

* Created basic `ConsoleApplication` which will be used for example to create async. code executions from web requests
* Renamed the console application to `CliApplication` and the Cli interface to `cli.php`
* The account mapper no longer auto-loads the password since it got removed from the mapper. In order to load an account with password or change the password, one must use the `AccountCredentialMapper`
* Improved naming conventions in permissions. "Type" is replaced by "Category"
* The `installExternal` scripts are now mostly using the Api end points through internal Api requests
* During the installation the application checks if the Cli application is callable and sets the settings accordingly
  * This is for example used by the event offloading/asynchronous event handling

#### Framework

* Started to create C++ framework
* Created a `pdf2text` parser function
* Turned permission flag internally into booleans for read, create, change delete, permission. This allows faster DB reads in certain cases
  * Externally it still uses flags

#### Billing

* Allow to upload invoices as Pdfs for invoice recognition
  * Invoice pre-processing 75% completed, can be used as is but improvements are recommended
  * Invoice layout recognition and parsing still need to get implemented as well as manual layout definition

#### Media

* Reduced middle-man function for multiple file uploads and replaced it with loops (removed: `createDbEntries`)
  * File uploads can no optionally be related to accounts. This is not always wanted/necessary
* Automatically save the contents of a text file (txt, md), word file (doc, docx) or pdf in the database
  * Pdfs either use the text which is stored inside of them or if the pdf is an "image" OCR is used with pre-processing
* Media files can have a status (hidden, active/normal, deleted)
* The media view now shows the virtual path as a directory path, similar to the list view

#### Dashboard

* The dashboard can receive data from other modules. This way new components automatically get added to the default board (board id 1).

#### Editor

* Support text versioning by creating a history table and custom version field

#### Knowledgebase

* Support text versioning by creating a history table and custom version field

#### Q&A

* Implemented basic voting
* Implemented basic answer accepting
* Optimized score table by adding who a vote is cast for, not just the answer/question id (= easier score calculation per account)

#### Frontend

* Created a tool which pre-processes invoice images

#### Demo setup

* Created async. install option for the demo application.
  * Cli command:`php demoSetup/setup.php -a 0`
  * Remark: This most likely maxes out the CPU usage at 100% for 1 hour since almost all setup scripts are execute in parallel.

### Bug fixes

#### Framework

* Fixed limit and sort bug for has many elements
* Uri query parameters where no value could be found are removed. Query parameters where no value is specified remain.
  * `?para1=123&para2={?NOT_FOUND}` => `?para1=123`
  * `?para1=123&para2` => `?para1=123&para2`

#### Media

* Implemented `\urlencode` to fix file path bug for Pdf viewer + adjusted `viewer.js` url decoding in Resources

#### Dashboard

* Fixed bug where the admin didn't have a dashboard. Now the default dashboard is created during the install process (see changelog above).

#### CMS

* Created reserved application names `cli`, `backend`, `api`.

#### Other

#### Installer

* Implemented `GroupPermissionMapper` to create default permissions instead of hard coded permission setup

## January 2022

### New

#### Media

* Added the reference media type (similar to collections) which allows to create references to existing media. This is ideal for showing the same media file in different places while making sure that deleting or changing the reference doesn't effect the actual media file.
* Create collection directories recursively (similar to `mkdir` with a recursion flag set to true)

### Other

#### Installer

* Added command line to developer documentation for generating cachegrind output during installation
* The demo setup script now uses the correct row counts instead of estimations
* Added API call counter to demo installer script

## December 2021

### New

#### Framework

* Implemented the new `DataMapper` / `DataMapperFactory`  pattern
  * This solved various issues and todos (see archived todos for details)

## November 2021

### New

#### Framework

* Sending basic emails with `mail`, `sendmail` and `SMTP` is possible
* Sending signed emails is possible.
* Reading and creating mailboxes with `IMAP` is possible
* Reading mailboxes with `POP3` is possible

#### Frontend

* Frontend messages can be manually closed with a close button (x)
* Frontend messages can be defined sticky
* Frontend messages may omit the title

#### Admin

* Implemented basic server/admin email settings
* Implemented password reset with reset emails
* Implemented read-only/maintenance mode (configurable in the `Admin` settings)

#### Billing

* Bill can have notes (very helpful for additional remarks later on e.g. from accounting/sales/purchasing)
* Bills have net/gross profit, sales, costs and discount as unnormalized values
* Bills store the bill number and the number format in the model

#### ContractManagement

* Create a new media type "contract" during installation
* Contracts can have  a renewal time in months set when the contract renewal must be done (latest).
* Contracts can have a flag which indicates if the contract auto renews.
* Added a global warning deadline until when users are informed before the renewal deadline runs out.
* Contracts can be assigned to a unit.

#### Editor

* Implemented editor doc types (similar to media types)

#### EventManagement

* Events have planned and actual costs/earnings.
* Accounts can be assigned to events with different purposes.
* Events can have attributes (incl. default attributes)

#### Job

* Jobs can be created in the Job module
* Created three jobs which run `monthly`, `weekly` and `daily` and execute some default tasks (e.g. email error logs to admin). These also have placeholders to run additional tasks (e.g. run exchange scripts)

#### Marketing

* Promotions have planned and actual costs/earnings.
* Accounts can be assigned to promotions with different purposes.
* Promotions can have attributes (incl. default attributes)

#### ProjectManagement

* Projects have planned and actual costs/earnings
* Projects can have attributes (incl. default attributes)

### Bug fixes

* Fixed a bug where the tests created a log file in the main directory
* Fixed a bug where changing headers during the rendering process would conflict with already sent header information in the `WebApplication`. The response is now rendered independently, without sending it (first render data, then push the headers, then send the response).

#### QA

* Fixed a bug where the question and answer content where shorter than the score content on the side resulting in portlets without background color.

### Other

* Removed many unnecessary getters and setters

#### Tests

* The overall code coverage improved to 91.8% (mid of November, this will go down as now additional functionality will be implemented)

## October 2021

### New

* Improved settings handling by using `Setting` and `SettingMapper` in the `CoreSettings` file

#### Media

* It is possible to define the media title separately from the file name.

### Bug fixes

### Other

#### Tests

* Added various tests. The total code coverage is at approx. 84%

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
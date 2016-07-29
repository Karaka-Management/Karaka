# Monitoring

## Internal

The application provides activity monitoring through error logging as well as activity logging. 

### Error Logging

The error logging creates log entries whenever an error occures. These error logs contain specific information about what, when, where and who caused the error. These error messages indicate that something is not working as intended and require immediate attention. These errors however are not known to the development team since they are application specific; in order to inform the development team that there is an error it's possible to forward this error via a simple click of a button. This error can now get inspected and fixed. Make sure to report all errors so that they can get fixed. Errors that appear because of changes in the source code will be ignored since customer or third party code changes are not supported or allowed.

### Activity Logging

The activity logging is used by modules in order to log user and system activities such as changes/updates to existing elements or the creation and deletion of elements. Elements in this context referes to all database data and state changes. These logs are important in order to investigate changes by certain people or to certain elements. Activity logs can be an important factor for audits as they prove that all changes can be inspected, supervised and tracked back. These log files can be used for complience reports as well as approval reports where certain activities need to be approved. While there are modules like the `Workflow` module which allow pre-approval in some cases a post-approval may be necessary and in these situations these logs can be used to generate a report which then can be approved.

## External
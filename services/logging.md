# Logging

The core provides two different logging outputs, one is a file output for low level logging such as exceptions, warnings and errors as well as a database logging for activity logging and higher level problems.

## File Logging

The file logging should only be used for database and application problems. The file logging is part of the framework and is always available.

## Database Logging

The database logging is recommended for activity logs and abstract high level issues that are not related to the application itself. The database logging is part of the monitoring module which is a core module and should be always installed.
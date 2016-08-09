# Sessions

Sessions are handled via the `SessionManager`. Sessions can be set and manipulated from the web application as well as the socket or console application. 

## HTTP

The Http session will be saved automatically, there is no need to access the super global `$_SESSION`. Make sure to only modify session data using the SessionManager

## Socket & Console

The session will be stored and assoziated with the logged in user in memory. A disconnect or quit is considered as a logout and therefor results in the destruction of the session object of this user and will be empty for the next login.

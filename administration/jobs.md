# Jobs

Depending on the server environment it's possible to setup automated jobs/tasks that run at a specific time or interval. This can be useful for automatic updates, backups etc. The application provides a list of default jobs that it can setup. Other modules may provide additional jobs which can also be monitored in the jobs overview.

Simple web servers usually don't allow to register automated jobs. For this purpose jobs can get registered on our own servers which then in return call your application thorugh an api interface. While this enables the use of automated jobs/tasks in situations where this usually wouldn't be possible also is highly dependent on a stable internet connection and server. If possible the local registration of jobs is always prefered. 

Jobs don't have to be used they simply provide a convenient way to automate certain tasks that otherwise have to be performed manually.

Jobs work on all operating systems that are supported by the application. Jobs either rely on the operating system or they can also get executed by the server/socket application. Which of the jobs should get executed by the operating system and which by the socket application can be configured on a job basis.

Failures in jobs are automatically documented and stored on the server. The documentation can be found and downloaded in the jobs.

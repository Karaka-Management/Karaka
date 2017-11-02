# Introduction

The **Job** module allows to create Linux or Windows jobs/tasks/schedules. This can be used by many modules to register and run a job at a specific date, time and or interval. This can be helpful for backups, updates and much more.

## Target Group

The target group for this module is everyone who wants to automize certain tasks without manually starting them. Mainly administrators should have direct access and modifcation permissions for this module. Other modules can use this module in order to register jobs (e.g. automatic reporting and email generation at month-end).

# Setup

This module uses partly the console application for executing system commands. This way the web application doesn't require additional system access and execution permissions an only the console application needs those.

The module can be installed through the integrated module downloader and installer or by uploading the module into the `Modules/` directory and executing the installation through the module installer.

# Features

The purpose of this module is straight forward to monitor jobs, register and modify them. In the backend other modules may use this module to register jobs related to themselves (e.g. automatic reporting and email generation at month-end).

# Recommendation

Other modules that work great with this one together are:

* [Backup](Backup)
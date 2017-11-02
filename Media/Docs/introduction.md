# Introduction

The **Media** module is used for uploading and managing all files. This makes the module a core module which is installed upon application installation.

## Target Group

The target group for this module is everyone, since every application musst have this module. Depending on the configuration every user can use this module to upload files.

# Setup

The module can be installed through the integrated module downloader and installer or by uploading the module into the `Modules/` directory and executing the installation through the module installer.

# Features

## Media Upload

This module is always used to upload files to the application. All other modules that have to handle files have to use this module in order to upload and provide files. If no connection to the application is available the upload will begin as soon as a connection is made. Even files that stopped uploading due to connection loss will continue the upload once a connection is re-established.

Instead of manually uploading files it's also possible to link directories on the hard drive of the application. This enables organizations to share large amounts of files without uploading them to the application.

## Media Management

The module allows to group files (collection) together for easier sharing and management. This grouping is different from traditional directories since multiple groups can contain a reference to the same file. It's also possible to organize files in traditional directories and manage their permissions. 

Permissions can be on file/collection/directory, user and group level providing full control over who can do what. On top of these permissions it's also possible to assign passwords to them. The permission management allows finely tune how to share files.

# Recommendation

Other modules that work great with this one together are:

* [Draw](Draw)

# Introduction

The **Monitoring** module analyzes the application behaviour such as response times, cache hits, database activites and system activities.

## Target Group

The target group for this module is everyone who wants to know more about the applications and server behaviour. Be aware that for shared hosting not all server information may be available. Mainly administrators should have access permissions to this module since the information provided by this module are rather technical and not meant for everyone.

# Setup

This module uses partly the console application for executing system commands. This way the web application doesn't require additional system access and execution permissions an only the console application needs those.

The module can be installed through the integrated module downloader and installer or by uploading the module into the `Modules/` directory and executing the installation through the module installer.

# Features

## System Benchmarks

Benchmarks regarding CPU, RAM and hard drive activity. These figures might not be available or incorrect on shared hosting depending on the configuration of the shared hosting.

## Application Benchmarks

### Performance

Analysis of critical application behavior as well as total request/response times.

### Cache

Analysis about cache hits and misses which is also useful for developers in order to optimize their caching behavior. 

### Database

Database size, reads, writes, updates for analysing database activities.

# Recommendation

Other modules that work great with this one together are:

* [Job](Job)
* [Backup](Backup)
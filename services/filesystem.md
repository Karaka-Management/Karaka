# Filesystem

The file system provides a simple way to handle operations on the file system. Supported environments are `local`, `ftp`, `git` as well as `aws`. The functionality is for all environments the same.

## Functions

* `exists()`
* `delete()`
* `create()`
* `put()`
* `get()`
* `size()`
* `createdAt()`
* `modifiedAt()`
* `move()`
* `copy()`
* `list()`
* `directories()`
* `files()`

## Custom Implementations

Custom implementations can be created by extending the StorageAbstract. These implementations must get registered in the file system and can be used afterwards as the pre-defined implementations.

```
Storage::register('custom1', '\implementation\namespace');
Storage::env('custom1')->list();
```
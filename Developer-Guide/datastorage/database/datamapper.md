# DataMapper

## Models

Models can be constructed in what ever way you like, all of the mapping logic is defined in the data mapper itself. It is however recommended to provide the following member variables if applicable (names can be different):

```php
private $id = 0;
private $createdAt = null;
private $createdBy = null;
```

The `$id` can be used as primary key. For this member variable no setter method should be present. For the `$createdAt` as well as the `$createdBy` member variables both getter and setter methods are possible. It's also possible to make these variables immutable since both should be known during the initialization point of a new model.

## DataMapper

The data mapper itself is where all the magic happens, from inserts, updates, to selects etc. 

### Primary key

The primary key can be indicated with the variable `$primaryField`. This variable should contain the string representation of the database field name. This variable is compulsory.

### Created at

While it is possible to log user, module and database activities thorugh the logging module it is often necessary to know when a certain entry got created. For that purpose the `$createdAt` can be used to define the string representation of the database field name which contains the date of the insert.

### Created by

In a similar fashion as the `$createdAt` variable often it is also necessary to have a field containing the id of the account creating the entry. The varibale `$createdBy` has to contain the string representation of that database field name.

### Table

One model can only be stored in one table. With the `$table` variable it's possible to specify the table name. This variable is compulsory. It's important to note that by extending a model you also need to implement a data mapper that can access multiple tables. In that case it's also necessary to extend the data mapper of the extended module.

### Columns

In the `$columns` array all columns, respective model variables and data types need to be specified.

```php
protected static $columns = [
    'db_field_name_1' => ['name' => 'db_field_name_1', 'type' => 'int', 'internal' => 'model_var_name_1'],
    'db_field_name_2' => ['name' => 'db_field_name_2', 'type' => 'string', 'internal' => 'model_var_name_2'],
];
```

The `name` contains the field name in the database, the `type` represents the data type and `internal` is the string representation of the model variable name.

#### Types

Possible types are:

* int
* string
* bool
* float
* serializable (will call `serialize()`)
* json (will call `jsonSerialize()`)

### Has many

With the `$hasMany` variable it's possible to specify other models that belong to this model.

```php
protected static $hasMany = [
    'model_var_name_3' => [
        'mapper'         => HasManyMapper::class,
        'table'          => 'relation_table_name',
        'dst'            => 'relation_destinaiton_name',
        'src'            => 'relation_source_name',
    ],
];
```

The `mapper` contains the class name of the mapper responsible for the many models that belong to this model. The `table` contains the name of the table where the relations are defined (this can be the same table as the source model or a relation table). If a model is only in relation with one other model this relation can be defined in the same table as the model and this `table` field can be `null`. The `dst` field contains the name of field where the primary key of the destination is defined. The `src` field is only required for models which have a relation table. This field contains the name of the field where the primary key of the source model is defined.

A one to many relation would look like the following:

```php
protected static $hasMany = [
    'model_var_name_3' => [
        'mapper'         => HasManyMapper::class,
        'table'          => null,
        'dst'            => 'relation_destinaiton_name',
        'src'            => null,
    ],
];
```

A many to many relation which can only be defined in a relation table looks like the following:

```php
protected static $hasMany = [
    'model_var_name_3' => [
        'mapper'         => HasManyMapper::class,
        'table'          => 'relation_table_name',
        'dst'            => 'relation_destinaiton_name',
        'src'            => 'relation_source_name',
    ],
];
```

### Has one

It's possible to also define a relation in the destination module itself. This can be acomplished by using the `$hasOne` variable. In this case the model itself has to specify a field where the primary key of the source model is defined.

```php
protected static $hasOne = [
    'model_var_name_4' => [
        'mapper' => HasOneMapper::class,
        'src'    => 'relation_source_name',
    ],
];
```

The `mapper` field contains the class name of the mapper of the source model. The `src` field contains the database field name where the primary key is stored that is used for the realation.

### Belongs to

The reverse of a has one/has many is a belongs to. This allows to also load models that a specific model belongs to. This can be acomplished by using the `$belongsTo` variable. In this case the model itself has to specify a field where the primary key of the source model is defined.

```php
protected static $belongsTo = [
    'model_var_name_5' => [
        'mapper' => BelongsToMapper::class,
        'dest'   => 'relation_destination_name',
    ],
];
```

The `mapper` field contains the class name of the mapper of the destination model. The `dest` field contains the database field name where the primary key is stored that this model belongs to.
# Crow template engine - options

{% include menu.html %}

Here we will see the complete options list

## Default path

**[Required]** Where you will create your templates by default

```php 
Crow::setDefaultPath('/path/to/templates/folder');
```

## Components namespace

The namespace of your component classes

```php
Crow::setComponentsNamespace('Project\MyComponents');
```

## Caching

Specify cache directory. Remember to give write permission

```php
Crow::setCacheFolder('/path/to/templates/cache');
```


## Disable minifying

Disable code minifying. Not recommended. Use only if you're having issues

```php
Crow::disableCodeMinifying();
```

## Templates extension

Don't like `.crow.php` extension?

```php
Crow::setExtension($extension);
```
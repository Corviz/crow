# Crow template engine

Yet another php template engine

{% include menu.html %}

{% raw %}
Features:

* Easily extensible - You can create new methods to satisfy your needs
* Wide spread syntax (similar to Blade)
* Framework agnostic - You can use it in any project
* Easy to configure - It takes literally 2 commands to make a basic configuration (1 if you won't use components/custom 
tags)
* MIT license. Free for commercial and non-commercial use

## Installation with composer

```
composer require corviz/crow
```

## Quickstart

In your main script:
```php
use Corviz\Crow\Crow;

Crow::setDefaultPath('/path/to/templates/folder');
Crow::setComponentsNamespace('MyComponents'); //Required only if you will use components/custom tags

Crow::render('index');
```

In /path/to/templates/folder/index.crow.php:

```html
<!DOCTYPE html>
<html>
    <head>
        <title>Index</title>
    </head>
    <body>
        {{ 'Hello world' }}
    </body>
</html>
```

## Basic loop example

In your main script:
```php 
$todoList = ['Work', 'Clean house', 'Relax'];
```

Template file

```html
<h1>Todo:</h1>
<ul>
    @foreach($todoList as $task)
        <li>{{ $task }}</li>
    @endforeach
</ul>
```

{% endraw %}

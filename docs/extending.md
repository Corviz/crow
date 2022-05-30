{% include menu.html %}

# Crow template engine - extending

{% raw %}
Sometimes, you will want to create your own methods.
To do so, follow the steps bellow:

## 1 - Create your method class:

You can create your class wherever you like in your application. The only requisite is that you extend `Corviz\Crow\Method`
```php
namespace App\Template\CustomMethods;

use Corviz\Crow\Method;

class TestMethod extends Method
{
    /**
     * @inheritDoc
     */
    public function toPhpCode(?string $parametersCode = null): string
    {
        return "<?php echo 'This is just a test!'; ?>";
    }
}
```

**$parametersCode** will carry the provided php code between parenthesis in your template. For example, if you have a _@if_
call in your template:
```html
@if ($variable == 'value')
...
```

The variable $parametersCode will contain the string `$variable == 'value'`

## 2 - Register your method

The first parameter will be the method signature, the second the name of the class that will be used:

```php
Crow::addMethod('mytestmethod', \App\Template\CustomMethods::class);
```

## 3 - Use it!

```html
<div class="contents">
    @mytestmethod
</div>
```

As simple as that :)

{% endraw %}



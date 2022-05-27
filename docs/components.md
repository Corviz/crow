# Crow template engine - components

{% include menu.html %}

## Set up

### 1 - Define your component classes namespace

Namespaces MUST begin and end with **\\**

Example:
```php
$componentsNamespace = '\\App\\View\\Components\\';
Crow::setComponentsNamespace($componentsNamespace);
```

### 2 - Create your component class:

```php
 
namespace App\View\Components;

use Corviz\Crow\Component;

class AlertComponent extends Component
{
    /**
     * Draw component
     *
     * @return void
     */
    public function render(): void
    {        
        $this->view('components/alert');
    }
}
```
**IMPORTANT!** All components classes MUST end with the word "Component" (BradcrumbsComponent, AlertComponent, SlideshowComponent and so on...)

### 3 - Create your component template file

_alert.crow.php_
```
<div class="alert alert-{{ $attributes['level'] }}">
    {!! $contents !!}
</div>
```

### 4 - Use it as a html class inside a template

Component tags are preceded with "x-". It uses dash case (Eg.: <x-my-cuscom-tag /> will lookup to MyCustomTagComponent class)

```
{{-- Template contents... --}}

<x-alert level="info">
    You have a new message!
</x-alert>

{{-- More contents... --}}
```

This will produce the following html:

```html
<div class="alert alert-info">
    You have a new message!
</div>
```


## Additional info

### 1 - Predefined data

**$attributes** and **$contents** are fed by default to you component template. 
They contain the attribute values in an array and the component's body contents respectively.

It is also possible to read this data through `getContents()` and `getAttributes()` methods inside your component class.

```php
public function render(): void
{
    $attrs = $this->getAttributes();
    $contents = $this->getContents();
    
    //do something...
            
    $this->view('components/display-numbers');
}
```

### 2 - You can define new variables inside your component class and read it as usual in you template file:

```php
public function render(): void
{
    $sum = 1 + 1;
    $sub = 10 - 1;
            
    $this->view('components/display-numbers', compact('sum', 'sub'));
}
```

### 3 - To feed php variables or operation results into your component in a template, use ":" before an attribute:

```html
<x-alert :level="$level">
    Message
</x-alert>
```

or

```html
<x-alert :level="$message->type == 'error' ? 'danger' : 'info'">
    {{ $alertMessage }}
</x-alert>
```

### 4 - Components can be short tags:

```html
<x-my-component something="..." />
```

Enjoy!
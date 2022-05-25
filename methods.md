# Crow template engine - methods
{% raw %}
## Printing

There are two ways of printing values:

* `{{ $value }}` for escaping output.
* `{!! $value !!}` for raw value output.

## Commentaries

`{{-- My comment --}}`

This will work for single and multiline commentaries

## Condition

### @if

Simple if statement:

```
@if ($some == 'condition')
    <span>Condition is true</span>
@endif
```

If/else condition

```
@if ($some == 'condition')
    <span>Condition is true</span>
@else
    <span>Condition is false</span>
@endif
```

Nested if conditions (aka. elseif)

```
@if ($condition1)
    <span>Condition 1 is true</span>
@elseif ($condition2)
    <span>Condition 2 is true</span>
@elseif ($condition3)
    <span>Condition 3 is true</span>
@elseif ($condition4)
    <span>Condition 4 is true</span>
@else
    <span>All conditions were false</span>
@endif
```

### @switch

```
@switch ($value)
    @case (1)
        Value is 1
    @break

    @case (2)
        Value is 2
    @break

    @default
        Value is neither 1 or 2
@endswitch
```

### @empty

```
@empty ($value)
    Value is empty
@endempty
```

### @unless

```
@unless ($condition)
    Condition is false
@endunless
```

## Loops

### @for

```
@for ($i = 1; $i <= 10; $i++)
    Counting {{ $i }}
@endfor
```

### @foreach

```
@foreach ($todoList as $todo)
    {{ $todo }}
@endfor
```

### @while

```
@while ($condition)
    Condition still true
@endwhile
```

### @forelse

```
@forelse ($list as $item)
    Current item: {{ $item }}
@empty
    List is empty
@endforelse
```

### Breaking or continuing loop iteration

`@break` and `@continue` works with all loop methods

Simple breaking
```
@for ($i = 1; $i <= 10; $i++)
    Current item {{ $i }}
                      
    @break
                      
    End of iteration
@endfor
```

Simple continuing
```
@for ($i = 1; $i <= 10; $i++)
    Current item {{ $i }}
                      
    @continue
                      
    End of iteration
@endfor
```

Conditional breaking
```
@for ($i = 1; $i <= 10; $i++)
    Current item {{ $i }}
                      
    @break ($i == 5)
                      
    End of iteration
@endfor
```

Conditional continuing
```
@for ($i = 1; $i <= 10; $i++)
    Current item {{ '{{ $i }}' }}
                      
    @continue ($i == 5)
                      
    End of iteration
@endfor
```

## Sections (@section/@yield)

Sections are parts of the template that wont be printed immediately but when `@yield('secion_name')` is encountered. Example:

```
@section ('section1')
    This is a section
@endsection

{{-- Some code here --}}

@yield ('section1')
```

## @include

To include other templates:
```
<div class="contents">
    {{ '{{-- This will search for othertemplate.crow.php in the templates directory --}}' }}
    @include('othertemplate')
</div>
```

## @extends

Lets say you have a base template file:

*base.crow.php:*
```
<!DOCTYPE html>
<html>
    <head>
        <title>My project</title>
    </head>
    <body>
        @yield ('contents')
    </body>
</html>
```

All you have to do to extend it is:

*login-form.crow.php:*
```
@extends ('base')

@section ('contents')
<form action="login.php">
    <label>Username</label>
    <input type="text" name="username"/>
    
    
    <label>Password</label>
    <input type="password" name="password"/>
    
    <button type="submit">OK</button>
</form>
@endsection
```

## Attributes

### @disabled
```
<input type="text" name="something" @disabled($condition)/>
```

### @readonly
```
<input type="text" name="something" @readonly($condition)/>
```

### @selected
```
<select name="my_select">
    <option value="1" @selected($option == 1)>Option 1</option>
    <option value="2" @selected($option == 2)>Option 2</option>
    <option value="2" @selected($option == 3)>Option 3</option>
</select>
```

### @checked
```
<input type="checkbox" value="1" name="something" @checked($value == 1)/>
```

### @class

Each item will be included to class attribute as it's value is true

```
<div @class(['class1' => true, 'class2' => false, 'class3' => true])>
    contents...
</div>
```

## Runing php code:
```
@php
    //This is php code
    $from = 10;
    $to = $from + 10;
@endphp
```

{% endraw %}

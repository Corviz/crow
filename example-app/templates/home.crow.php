<!DOCTYPE html>
<html>
    <head>
        <title>Example index</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <style>
            * { box-sizing: border-box; }

            html, body {
                width: 100%;
                height: 100%;
                margin: 0;
                padding: 0;
                font-family: sans-serif;
            }

            body {
                background: #515ada;
                background: linear-gradient(90deg, #efd5ff 0%, #515ada 100%);
                color: #2c1f73;
                display: flex;
                flex-wrap: wrap;
                flex-direction: column;
                justify-content: center;
                align-items: center;
            }

            div.hello {
                text-align: center;
                font-size: 1.5em;
            }

            div.components-row {
                margin: 20px 0;
                display: flex;
                flex-wrap: wrap;
                width: 100%;
                justify-content: center;
            }

            div.links,
            div.component-container {
                background: rgba(255, 255, 255, 0.4);
                padding: 10px;
                border-radius: 5px;
            }

            div.component-container {
                margin: 0 5px;
                width: calc(40% - 10px);
            }

            div.links {
                width: 50%;
                text-align: center;
            }

            div.links a:after{
                content: ' | '
            }

            div.links a:last-child:after {
                content: '';
            }

            a {
                color: inherit;
                text-decoration: none;
            }
            a:hover {
                text-decoration: underline;
            }

            img {
                max-height: 100%;
                max-width: 100%;
            }
        </style>
    </head>
    <body>
        <div class="hello">
            <h1>Hello World!</h1>
            <p>{{ $message }}</p>
        </div>
        <div class="components-row">
            <div class="component-container">
                <x-example-component title="This is a component">
                    This content was set in the parent template.
                </x-example-component>
            </div>
            <div class="component-container">
                <x-example-package.random-image />
            </div>
        </div>
        <div class="links">
            @foreach($links as $link)
                <a href="{{ $link['url'] }}" target="_blank">{{ $link['label'] }}</a>
            @endforeach
        </div>
    </body>
</html>
# Antidot Framework Phug Template Renderer

## Install

Using composer

```bash
composer require antidot-fw/phug-template-renderer
```

### Antidot framework

It will work out of the box, the only thing you need is to inject the TemplateRenderer interface in your request handler constructor

### As standalone component

See factory classes at `src/Container`.

## Config

```php
<?php

declare(strict_types=1);

$config = [
    'pug' => [
        'pretty' => true,
        'expressionLanguage' => 'js',
        'pugjs' => false,
        'localsJsonFile' => false,
        'cache' => 'var/cache/pug',
        'template_path' => 'templates/',
        'globals' => [],
        'filters' => [],
        'keywords' => [],
        'helpers' => [],
        'default_params' => [],
    ],
];
```

## Usage

See full [PHP Pug documentation](https://www.phug-lang.com/) for more detail.

### In a request handler

```php
<?php

declare(strict_types=1);

use Antidot\Render\TemplateRenderer;
use Laminas\Diactoros\Response\HtmlResponse;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

class SomeHandler implements RequestHandlerInterface
{
    private TemplateRenderer $template;

    public function __construct(TemplateRenderer $template) 
    {
        $this->template = $template;
    }

    public function handle(ServerRequestInterface $request) : ResponseInterface
    {
        return new HtmlResponse(
            $this->template->render('index', [
                'name' => 'Koldo ;-D',
            ])
        );
    }
}
```

```pug
// templates/index.pug
html
    head
        title Antidot Todo List app
        link(rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css")
        link(href="//fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet")
    body
        main
            section(class="container")
                h1 Hello #{name} 

    script(type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js")
    block scripts

```

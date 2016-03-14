Silex-Markdown
==============

[![Build Status](https://travis-ci.org/bretrzaun/Silex-Markdown.svg?branch=master)](https://travis-ci.org/bretrzaun/Silex-Markdown)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/bretrzaun/Silex-Markdown/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/bretrzaun/Silex-Markdown/?branch=master)

A lightweight markdown service provider for Silex. Uses the
[michelf/php-markdown](https://packagist.org/packages/michelf/php-markdown) markdown parser.

Based on: [nicl/silex-markdown](https://github.com/nicl/Silex-Markdown)

Installation
------------

Recommended installation is [through composer](http://getcomposer.org). Just add
the following to your `composer.json` file:

    {
        "require": {
            "bretrzaun/silex-markdown": "^1.0"
        }
    }

Usage
-----

To use the service provider first register it:

    $app->register(new MarkdownServiceProvider());

You can then use the markdown filter in Twig files. For example:

    {{ '#Hello World'|markdown }}

In addition, you also have access to the Markdown parser itself. Simply
instantiate it and call the `transform` method as follows:

    $app['markdown']->transform($txt);

Configuration
-------------

### Parameters

 * **markdown.factory**: Name of the service that will create `Michelf\MarkdownInterface` instances, string.
 * **markdown.parser**: Name of the built-in parser to use, string.
   *Default: markdown*

   Available options:
   * **markdown**:
     Standard Markdown parser
   * **extra**:
     Markdown Extra parser

### Services

 * **markdown**:
   Markdown parser, instance of `Michelf\MarkdownInterface`.

Tests
-----

If you wish to run the tests then, from the silex-markdown root directory run:

    composer test


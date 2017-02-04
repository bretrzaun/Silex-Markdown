<?php

namespace BretRZaun\Silex\Tests;

use PHPUnit\Framework\TestCase;
use Silex\Application;
use Silex\Provider\TwigServiceProvider;
use BretRZaun\Silex\MarkdownServiceProvider;

/**
 * Tests for markdown service provider
 */
class MarkdownServiceProviderTest extends TestCase
{

    /**
     * @var Application
     */
    private $app;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->app = new Application();
        $this->app->register(new TwigServiceProvider());
        $this->app->register(new MarkdownServiceProvider());
    }

    /**
     * Basic test case of service provider
     */
    public function testMarkdownTwigFilter()
    {
        $template = $this->app['twig']->createTemplate("{{ '#Hello World'|markdown }}");
        $output = $template->render([]);

        $this->assertEquals("<h1>Hello World</h1>\n", $output);
    }

    /**
     * Test custom markdown factory works
     *
     * @param string $expectedClass   If successful, which class name should our object be an instance of?
     * @param bool   $expectException Should an exception be expected?
     * @param string $name            Name passed as the parser name
     *
     * @dataProvider builtInMarkdownParsersProvider
     */
    public function testBuiltInMarkdownParsers($expectedClass = null, $expectException = null, $name = null)
    {
        if (null !== $name) {
            $this->app['markdown.parser'] = $name;
        }

        try {
            $markdown = $this->app['markdown'];

            if ($expectException) {
                $this->fail('Expected an exception to be thrown');
            }

            $this->assertInstanceOf($expectedClass, $markdown);
        } catch (\RuntimeException $e) {
            if ($expectException) {
                $this->assertContains("Unknown Markdown parser '$name' specified", $e->getMessage());
            } else {
                $this->fail('Expected a different exception');
            }
        }
    }

    /**
     * Provide data for testBuiltInMarkdownParsers
     *
     * @return array
     */
    public function builtInMarkdownParsersProvider()
    {
        return array(
            array(\Michelf\Markdown::class, false),
            array(\Michelf\Markdown::class, false, 'markdown'),
            array(\Michelf\MarkdownExtra::class, false, 'extra'),
            array(null, true, 'INVALID'),
        );
    }

    /**
     * Test custom markdown factory works
     */
    public function testCustomMarkdownFactory()
    {
        $app = $this->app;

        $markdownParser = $this->createMock(\Michelf\Markdown::class);

        $app['test.markdown.factory'] = function($app) use ($markdownParser) {
            return $markdownParser;
        };

        $app['markdown.factory'] = 'test.markdown.factory';

        $this->assertEquals($markdownParser, $app['markdown']);
    }
}

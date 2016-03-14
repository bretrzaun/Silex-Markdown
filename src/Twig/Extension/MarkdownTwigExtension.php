<?php

namespace BretRZaun\Twig\Extension;

use Michelf\MarkdownInterface;

/**
 * Twig Markdown extension
 */
class MarkdownTwigExtension extends \Twig_Extension
{
    protected $parser;

    /**
     * Public constructor
     *
     * @param MarkdownInterface $parser
     */
    public function __construct(MarkdownInterface $parser)
    {
        $this->parser = $parser;
    }

    /**
     * {@inheritdoc}
     */
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('markdown', [$this, 'markdown'], array('is_safe' => array('html')))
        );
    }

    /**
     * Transform markdown text to html
     *
     * @param string $txt
     *
     * @return string
     */
    public function markdown($txt)
    {
        return $this->parser->transform($txt);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'markdown';
    }
}

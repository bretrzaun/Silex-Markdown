<?php

namespace BretRZaun\Silex;

use BretRZaun\Twig\Extension\MarkdownTwigExtension;
use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Silex\Application;

/**
 * Simple markdown service provider
 */
class MarkdownServiceProvider implements ServiceProviderInterface
{
    /**
     * {@inheritdoc}
     */
    public function register(Container $pimple)
    {
        $pimple['markdown'] = function () use ($pimple) {
            if (!empty($pimple['markdown.factory'])) {
                return $pimple[$pimple['markdown.factory']];
            }

            $parser = !(empty($pimple['markdown.parser'])) ? $pimple['markdown.parser'] : 'markdown';

            switch ($parser) {
                case 'markdown':
                    return new \Michelf\Markdown;
                case 'extra':
                    return new \Michelf\MarkdownExtra;
                default:
                    throw new \RuntimeException("Unknown Markdown parser '$parser' specified");
            }
        };

        if (isset($pimple['twig'])) {
            $pimple['twig'] = $pimple->extend('twig', function ($twig, $pimple) {
                $twig->addExtension(new MarkdownTwigExtension($pimple['markdown']));

                return $twig;
            });
        }
    }
}

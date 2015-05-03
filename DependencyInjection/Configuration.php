<?php

namespace Citrax\Bundle\DatabaseSwiftMailerBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('citrax_database_swift_mailer');


        $rootNode
            ->children()
            ->scalarNode("max_retries")->defaultValue('10')->end()
            ->scalarNode("delete_sent_messages")->defaultFalse()->end()
            ->end()
        ;

        return $treeBuilder;
    }
}

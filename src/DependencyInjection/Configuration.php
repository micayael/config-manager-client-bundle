<?php

namespace ConfigManager\Bundle\ClientBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('config_manager_client_config');

        $rootNode = $treeBuilder->getRootNode();

        $rootNode
            ->addDefaultsIfNotSet()
            ->children()
                ->scalarNode('host')
                    ->info('URL de la aplicación config manager')
                    ->isRequired()
                ->end()
                ->scalarNode('entrypoint')
                    ->defaultValue('/api/get_configs')
                    ->info('Entrypoint del servicio para obtener parámetros')
                ->end()
                ->scalarNode('app_token')
                    ->info('Token de la aplicación de la cual se obtendrán los parámetros')
                    ->isRequired()
                ->end()
                ->scalarNode('cache_timeout')
                    ->defaultValue(86400)
                    ->info('Tiempo de expiración automático de la cache')
                ->end()
                ->booleanNode('cache')
                    ->defaultValue(true)
                    ->info('Indica si las configuraciones deben ser cacheadas o no en la aplicación consumidora')
                ->end()
            ->end()
        ->end();

        return $treeBuilder;
    }
}

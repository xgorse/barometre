<?php

namespace Afup\BarometreBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class FilterCollectionPass implements CompilerPassInterface
{
    /**
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        $definition = $container->getDefinition('afup.barometre.filter_collection');

        foreach ($container->findTaggedServiceIds('barometre.filter') as $id => $attributes) {
            $definition->addMethodCall('addFilter', array(new Reference($id)));
        }
    }
}

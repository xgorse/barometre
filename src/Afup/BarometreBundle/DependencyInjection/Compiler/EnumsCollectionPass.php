<?php

namespace Afup\BarometreBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class EnumsCollectionPass implements CompilerPassInterface
{
    /**
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        $enums = $container->getDefinition('afup.barometre.enums_collection');

        foreach ($container->findTaggedServiceIds('barometre.enums') as $id => $attributes) {
            $enums->addMethodCall('addEnums', array(new Reference($id), $attributes[0]['alias']));
        }
    }
}

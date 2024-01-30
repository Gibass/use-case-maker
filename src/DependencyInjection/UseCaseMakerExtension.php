<?php

namespace Gibass\UseCaseMakerBundle\DependencyInjection;

use Gibass\UseCaseMakerBundle\Maker\MakerUseCase;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;

class UseCaseMakerExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container): void
    {
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.xml');

        $configuration = $this->getConfiguration($configs, $container);
        $config = $this->processConfiguration($configuration, $configs);

        if (!empty($config['parameters'])) {
            foreach ($config['parameters'] as $key => $value) {
                $this->setParams($container, $key, $value);
            }

            $rootNamespace = trim($config['parameters']['root_namespace'], '\\');

            $makerCommandDefinition = $container->getDefinition('maker.maker.maker_use_case');
            $makerCommandDefinition->replaceArgument(0, $rootNamespace);
        }
    }

    private function setParams(ContainerBuilder $container, string $key, $value): void
    {
        if (\is_array($value)) {
            foreach ($value as $ikey => $iValue) {
                $this->setParams($container, $key . '.' . $ikey, $iValue);
            }
        } else {
            $container->setParameter('use_case_maker.' . $key, $value);
        }
    }
}

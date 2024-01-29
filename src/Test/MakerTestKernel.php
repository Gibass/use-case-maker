<?php

namespace Gibass\UseCaseMakerBundle\Test;

use Gibass\UseCaseMakerBundle\UseCaseMakerBundle;
use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Bundle\MakerBundle\MakerBundle;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Kernel;

class MakerTestKernel extends Kernel
{
    use MicroKernelTrait;

    public const TMP_DIR = __DIR__ . '/../../tests/tmp';

    public function registerBundles(): iterable
    {
        return [
            new FrameworkBundle(),
            new MakerBundle(),
            new UseCaseMakerBundle(),
        ];
    }

    protected function configureContainer(ContainerBuilder $container, LoaderInterface $loader): void
    {
        $container->loadFromExtension('use_case_maker', [
            'parameters' => [
                'dir' => [
                    'domain' => self::TMP_DIR . '/Domain',
                    'test' => self::TMP_DIR . '/tests',
                ],
            ],
        ]);
    }
}

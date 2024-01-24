<?php

namespace Gibass\UseCaseMakerBundle\Structure;

class StructureConfig
{
    public const CONFIG = [
        'Request' => [
            'suffix' => 'Request',
            'tpl' => 'request',
            'params' => [],
        ],
        'Response' => [
            'suffix' => 'Response',
            'tpl' => 'response',
            'params' => [],
        ],
        'Presenter' => [
            'suffix' => 'PresenterInterface',
            'tpl' => 'presenter',
            'params' => [
                'responseClassName' => 'Response',
            ],
        ],
        'UseCase' => [
            'suffix' => '',
            'tpl' => 'use_case',
            'params' => [
                'requestClassName' => 'Request',
                'responseClassName' => 'Response',
            ],
        ],
        'Test' => [
            'suffix' => 'Test',
            'tpl' => 'test',
            'params' => [
                'useCaseClassName' => 'UseCase',
                'requestClassName' => 'Request',
                'responseClassName' => 'Response',
                'requestNamespace' => 'RequestNamespace',
                'responseNamespace' => 'ResponseNamespace',
                'useCaseNamespace' => 'UseCaseNamespace',
            ],
        ],
    ];

    public function __construct(
        private readonly string $domainDir,
        private readonly string $testDir,
        private readonly string $domainNamespacePrefix,
        private readonly string $testNamespacePrefix
    ) {}

    public function getDomainDir(): string
    {
        return $this->domainDir;
    }

    public function getTestDir(): string
    {
        return $this->testDir;
    }

    public function loadKeys(): array
    {
        return array_keys(self::CONFIG);
    }

    public function getNamespace(string $key, string $domain): string
    {
        return $key === 'Test' ?
            sprintf("$this->testNamespacePrefix\\%s", $domain) :
            sprintf("$this->domainNamespacePrefix\\%s\\%s", $domain, $key);
    }

    public function get(string $key, string $type): string
    {
        return self::CONFIG[$key][$type] ?? '';
    }

    public function getParams(string $key, bool $hasPresenter): array
    {
        $params = self::CONFIG[$key]['params'] ?? [];

        if ($hasPresenter && ($key === 'UseCase' || $key === 'Test')) {
            $params['presenterInterfaceName'] = 'Presenter';
        }

        if ($hasPresenter && $key === 'Test') {
            $params['presenterNamespace'] = 'PresenterNamespace';
        }

        return $params;
    }

    public function getTemplate(string $key, bool $hasPresenter): string
    {
        $tpl = self::CONFIG[$key]['tpl'] ?? '';

        if ($hasPresenter && ($key === 'UseCase' || $key === 'Test')) {
            $tpl .= '_presenter';
        }

        return __DIR__ . "/../Resources/skeleton/{$tpl}.tpl.php";
    }
}

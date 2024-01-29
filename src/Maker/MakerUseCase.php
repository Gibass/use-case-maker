<?php

namespace Gibass\UseCaseMakerBundle\Maker;

use Gibass\UseCaseMakerBundle\Structure\StructureConfig;
use Symfony\Bundle\MakerBundle\ConsoleStyle;
use Symfony\Bundle\MakerBundle\DependencyBuilder;
use Symfony\Bundle\MakerBundle\Generator;
use Symfony\Bundle\MakerBundle\InputConfiguration;
use Symfony\Bundle\MakerBundle\Maker\AbstractMaker;
use Symfony\Bundle\MakerBundle\Str;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;

/**
 * @method string getCommandDescription()
 */
class MakerUseCase extends AbstractMaker
{
    private array $details = [];

    public function __construct(
        private readonly string $rootNamespace,
        private readonly StructureConfig $config
    ) {
    }

    public static function getCommandName(): string
    {
        return 'maker:use-case';
    }

    public function configureCommand(Command $command, InputConfiguration $inputConfig): void
    {
        $command
            ->setDescription('Create a new use case.')
            ->addArgument('domain', InputArgument::OPTIONAL, 'Select the domain name.')
            ->addArgument('name', InputArgument::OPTIONAL, 'Choose a name for your new use case.')
            ->addOption('presenter', null, InputArgument::OPTIONAL, 'Does the UseCase need a presenter ?')
        ;
    }

    public function configureDependencies(DependencyBuilder $dependencies): void
    {
    }

    public function interact(InputInterface $input, ConsoleStyle $io, Command $command): void
    {
        if (!$input->getOption('presenter')) {
            $description = $command->getDefinition()->getOption('presenter')->getDescription();
            $question = new ConfirmationQuestion($description, false);
            $needPresenter = $io->askQuestion($question);

            $input->setOption('presenter', $needPresenter);
        }
    }

    public function generate(InputInterface $input, ConsoleStyle $io, Generator $generator): void
    {
        $domainPath = $this->config->getDomainDir() . '/' . Str::asCamelCase($input->getArgument('domain'));
        $domainTestPath = $this->config->getTestDir() . '/' . Str::asCamelCase($input->getArgument('domain'));

        if (!is_dir($domainPath)) {
            mkdir($domainPath, 0777, true);
        }

        if (!is_dir($domainTestPath)) {
            mkdir($domainTestPath, 0777, true);
        }

        foreach ($this->config->loadKeys() as $key) {
            if (!$input->getOption('presenter') && $key === 'Presenter') {
                continue;
            }

            $namespace = $this->config->getNamespace($key, Str::asCamelCase($input->getArgument('domain')));
            $path = $key === 'Test' ? $domainTestPath : $domainPath . '/' . $key;

            $this->details[$key] = $generator->createClassNameDetails(
                $input->getArgument('name'),
                $namespace,
                $this->config->get($key, 'suffix')
            );

            $generator->generateFile(
                sprintf('%s/%s.php', $path, $this->details[$key]->getShortName()),
                $this->config->getTemplate($key, $input->getOption('presenter')),
                array_merge([
                    'namespace' => $namespace,
                    'className' => $this->details[$key]->getShortName(),
                ], array_map($this->returnDetails(...), $this->config->getParams($key, $input->getOption('presenter'))))
            );
        }

        $generator->writeChanges();

        $this->writeSuccessMessage($io);
    }

    private function returnDetails($key): string
    {
        if (str_contains($key, 'Namespace')) {
            $fullName = $this->details[str_replace('Namespace', '', $key)]->getFullName();

            return substr_replace($fullName, '', 0, mb_strlen($this->rootNamespace . '\\'));
        }

        return $this->details[$key]->getShortName();
    }
}

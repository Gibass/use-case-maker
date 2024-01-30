<?php

namespace Gibass\UseCaseMakerBundle\Maker;

use Gibass\UseCaseMakerBundle\Exception\FileAlreadyExistException;
use Gibass\UseCaseMakerBundle\Test\MakerTestCase;
use Gibass\UseCaseMakerBundle\Test\MakerTestContent;
use Gibass\UseCaseMakerBundle\Test\MakerTestFailed;
use Gibass\UseCaseMakerBundle\Test\MakerTestGenerate;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

class MakerUseCaseTest extends MakerTestCase
{
    private CommandTester $commandTester;

    protected function setUp(): void
    {
        $kernel = self::bootKernel();

        $application = new Application($kernel);
        $command = $application->find('maker:use-case');
        $this->commandTester = new CommandTester($command);
    }

    /**
     * @dataProvider dataTestGenerateProvider
     */
    public function testGenerateSuccessful(MakerTestGenerate $generate): void
    {
        $this->commandTester->execute([
            'domain' => $generate->getDomain(),
            'name' => $generate->getUseCase(),
            '--presenter' => $generate->isHavePresenter(),
        ]);

        $this->commandTester->assertCommandIsSuccessful();

        $this->assertFilesGenerated($generate->getDomain(), $generate->getFiles());
    }

    /**
     * @dataProvider dataTestContentProvider
     */
    public function testContentSuccessful(MakerTestContent $content): void
    {
        $this->assertFileContent($content->getDomain(), $content->getFiles());
    }

    /**
     * @dataProvider dataTestFailedProvider
     */
    public function testFailedGenerate(MakerTestFailed $failed): void
    {
        $this->expectException($failed->getException());
        $this->expectExceptionMessage($failed->getMessage());

        $this->commandTester->execute([
            'domain' => $failed->getDomain(),
            'name' => $failed->getUseCase(),
            '--presenter' => $failed->isHavePresenter(),
        ]);
    }

    public static function dataTestGenerateProvider(): \Generator
    {
        yield 'create_domain_and_useCase_without_presenter' => [
            static::createTestGenerate('Action', 'DoAction')
            ->setFiles([
                'UseCase' => 'DoAction.php',
                'Response' => 'DoActionResponse.php',
                'Request' => 'DoActionRequest.php',
            ]),
        ];

        yield 'create_useCase_on_Domain_already_exist_without_presenter' => [
            static::createTestGenerate('Action', 'Article')
                ->setFiles([
                    'UseCase' => 'Article.php',
                    'Response' => 'ArticleResponse.php',
                    'Request' => 'ArticleRequest.php',
                ]),
        ];

        yield 'create_domain_and_useCase_with_presenter' => [
            static::createTestGenerate('Blog', 'DoAction')
                ->setHavePresenter(true)
                ->setFiles([
                    'UseCase' => 'DoAction.php',
                    'Response' => 'DoActionResponse.php',
                    'Request' => 'DoActionRequest.php',
                    'Presenter' => 'DoActionPresenterInterface.php',
                ]),
        ];

        yield 'create_domain_and_useCase_with_snakeCase_input' => [
            static::createTestGenerate('Blog', 'do_create')
                ->setHavePresenter(true)
                ->setFiles([
                    'UseCase' => 'DoCreate.php',
                    'Response' => 'DoCreateResponse.php',
                    'Request' => 'DoCreateRequest.php',
                    'Presenter' => 'DoCreatePresenterInterface.php',
                ]),
        ];

        yield 'create_domain_and_useCase_with_space_input' => [
            static::createTestGenerate('Auth', 'do create')
                ->setHavePresenter(true)
                ->setFiles([
                    'UseCase' => 'DoCreate.php',
                    'Response' => 'DoCreateResponse.php',
                    'Request' => 'DoCreateRequest.php',
                    'Presenter' => 'DoCreatePresenterInterface.php',
                ]),
        ];
    }

    public static function dataTestContentProvider(): \Generator
    {
        yield 'check_content_with_no_presenter' => [
            static::createTestContent('Action')
                ->addContent('UseCase', 'DoAction.php', 'namespace App/Domain/Action/UseCase')
                ->addContent('UseCase', 'DoAction.php', 'use App\Domain\Action\Response\DoActionResponse')
                ->addContent('UseCase', 'DoAction.php', 'class DoAction')
                ->addContent('UseCase', 'DoAction.php', 'public function execute(DoActionRequest $request): DoActionResponse')
                ->addContent('Response', 'DoActionResponse.php', 'namespace App/Domain/Action/Response')
                ->addContent('Response', 'DoActionResponse.php', 'class DoActionResponse')
                ->addContent('Request', 'DoActionRequest.php', 'namespace App/Domain/Action/Request')
                ->addContent('Request', 'DoActionRequest.php', 'class DoActionRequest'),
        ];

        yield 'check_content_with_presenter' => [
            static::createTestContent('Blog')
                ->addContent('UseCase', 'DoAction.php', 'class DoAction')
                ->addContent('UseCase', 'DoAction.php', 'use App\Domain\Action\Presenter\DoActionPresenterInterface')
                ->addContent('UseCase', 'DoAction.php', 'public function execute(DoActionRequest $request, DoActionPresenterInterface $presenter): mixed')
                ->addContent('Presenter', 'DoActionPresenterInterface.php', 'interface DoActionPresenterInterface')
                ->addContent('Presenter', 'DoActionPresenterInterface.php', 'use App\Domain\Blog\Response\DoActionResponse')
                ->addContent('Presenter', 'DoActionPresenterInterface.php', 'public function present(DoActionResponse $response): mixed;'),
        ];
    }

    public static function dataTestFailedProvider(): \Generator
    {
        yield 'test_with_file_already_exist_throwing_Exception' => [
            static::createTestFailedGenerate('Action', 'DoAction')
                ->setException(FileAlreadyExistException::class, 'Domain/Action/Request/DoActionRequest.php" is already exist.'),
        ];
    }
}

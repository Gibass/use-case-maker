<?php

namespace Gibass\UseCaseMakerBundle\Test;

use PHPUnit\Framework\Assert;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Filesystem\Filesystem;

class MakerTestCase extends KernelTestCase
{
    public const RELATIVE_TMP_DIR = 'tests/tmp';

    public static function tearDownAfterClass(): void
    {
        self::removeTmpDir();
    }

    protected static function getKernelClass(): string
    {
        return MakerTestKernel::class;
    }

    protected static function createTestGenerate(string $domain, string $useCase): MakerTestGenerate
    {
        return new MakerTestGenerate($domain, $useCase);
    }

    protected static function createTestContent(string $domain): MakerTestContent
    {
        return new MakerTestContent($domain);
    }

    protected static function createTestFailedGenerate(string $domain, string $useCase): MakerTestFailed
    {
        return new MakerTestFailed($domain, $useCase);
    }

    protected function assertFilesGenerated(string $domain, array $files): void
    {
        foreach ($files as $key => $file) {
            $path = '/Domain/' . $domain . '/' . $key . '/' . $file;

            if (!file_exists(MakerTestKernel::TMP_DIR . $path)) {
                Assert::fail('Failed asserting that ' . $key . ' file "' . self::RELATIVE_TMP_DIR . $path . '" exists');
            }
        }

        Assert::assertTrue(true);
    }

    protected function assertFileContent(string $domain, array $files): void
    {
        foreach ($files as $key => $file) {
            $path = '/Domain/' . $domain . '/' . $key . '/' . $file['name'];
            $message = 'No string "' . $file['content'] . '" found in ' . self::RELATIVE_TMP_DIR . $path;

            Assert::assertStringContainsStringIgnoringCase($file['content'], file_get_contents(MakerTestKernel::TMP_DIR . $path), $message);
        }
    }

    private static function removeTmpDir(): void
    {
        if (file_exists(MakerTestKernel::TMP_DIR)) {
            (new Filesystem())->remove(MakerTestKernel::TMP_DIR);
        }
    }
}

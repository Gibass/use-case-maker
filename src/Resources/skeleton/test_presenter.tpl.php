<?php echo "<?php\n"; ?>

namespace <?php echo $namespace; ?>;

use <?php echo $presenterNamespace; ?>;
use <?php echo $requestNamespace; ?>;
use <?php echo $responseNamespace; ?>;
use <?php echo $useCaseNamespace; ?>;
use PHPUnit\Framework\TestCase;

class <?php echo $className; ?> extends TestCase
{
    private <?php echo $useCaseClassName; ?> $useCase;

    /**
     * @var <?php echo $presenterInterfaceName; ?>
     */
    private $presenter;

    protected function setUp(): void
    {
        $this->presenter = new class() implements <?php echo $presenterInterfaceName; ?> {
            public function present(<?php echo $responseClassName; ?> $response): string
            {
                return 'view';
            }
        };

        $this->useCase = new <?php echo $useCaseClassName; ?>();
    }

    public function testSuccessful(): void
    {
        $request = new <?php echo $requestClassName; ?>();

        $response = $this->useCase->execute($request, $this->presenter);
        $this->assertSame('view', $response);
    }
}

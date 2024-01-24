<?php echo "<?php\n"; ?>

namespace <?php echo $namespace; ?>;

use <?php echo $requestNamespace; ?>;
use <?php echo $responseNamespace; ?>;
use <?php echo $useCaseNamespace; ?>;
use PHPUnit\Framework\TestCase;

class <?php echo $className; ?> extends TestCase
{
    private <?php echo $useCaseClassName; ?> $useCase;

    protected function setUp(): void
    {
        $this->useCase = new <?php echo $useCaseClassName; ?>();
    }

    public function testSuccessful(): void
    {
        $request = new <?php echo $requestClassName; ?>();

        $response = $this->useCase->execute($request);
        $this->assertSame('view', $response);
    }
}

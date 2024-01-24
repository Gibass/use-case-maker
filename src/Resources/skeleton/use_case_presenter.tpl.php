<?php echo "<?php\n"; ?>

namespace <?php echo $namespace; ?>;

use <?php echo str_replace('UseCase', 'Request', $namespace); ?>\<?php echo $requestClassName; ?>;
use <?php echo str_replace('UseCase', 'Response', $namespace); ?>\<?php echo $responseClassName; ?>;
use <?php echo str_replace('UseCase', 'Presenter', $namespace); ?>\<?php echo $presenterInterfaceName; ?>;

class <?php echo $className; ?><?php echo "\n"; ?>
{
    public function execute(<?php echo $requestClassName; ?> $request, <?php echo $presenterInterfaceName; ?> $presenter): mixed
    {
        $response = new <?php echo $responseClassName; ?>();

        return $presenter->present($response);
    }
}

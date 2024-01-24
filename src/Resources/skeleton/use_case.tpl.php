<?php echo "<?php\n"; ?>

namespace <?php echo $namespace; ?>;

use <?php echo str_replace('UseCase', 'Request', $namespace); ?>\<?php echo $requestClassName; ?>;
use <?php echo str_replace('UseCase', 'Response', $namespace); ?>\<?php echo $responseClassName; ?>;

class <?php echo $className; ?><?php echo "\n"; ?>
{
    public function execute(<?php echo $requestClassName; ?> $request): <?php echo $responseClassName; ?><?php echo "\n"; ?>
    {
        return new <?php echo $responseClassName; ?>();
    }
}

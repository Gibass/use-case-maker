<?php

namespace Gibass\UseCaseMakerBundle\Exception;

class FileAlreadyExistException extends \Exception
{
    public function __construct(string $path, int $code = 0, \Throwable $previous = null)
    {
        $message = 'The file "' . $path . '" is already exist.';

        parent::__construct($message, $code, $previous);
    }
}

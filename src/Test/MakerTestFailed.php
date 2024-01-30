<?php

namespace Gibass\UseCaseMakerBundle\Test;

class MakerTestFailed extends MakerTestGenerate
{
    private string $exception;
    private string $message;

    public function getException(): string
    {
        return $this->exception;
    }

    public function setException(string $exception, string $message = ''): MakerTestFailed
    {
        $this->exception = $exception;

        if ($message) {
            $this->message = $message;
        }

        return $this;
    }

    public function getMessage(): string
    {
        return $this->message;
    }
}

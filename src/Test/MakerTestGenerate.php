<?php

namespace Gibass\UseCaseMakerBundle\Test;

class MakerTestGenerate
{
    public function __construct(
        private string $domain,
        private string $useCase,
        private bool $havePresenter = false,
        private array $files = []
    ) {
    }

    public function getDomain(): string
    {
        return $this->domain;
    }

    public function setDomain(string $domain): MakerTestGenerate
    {
        $this->domain = $domain;

        return $this;
    }

    public function getUseCase(): string
    {
        return $this->useCase;
    }

    public function setUseCase(string $useCase): MakerTestGenerate
    {
        $this->useCase = $useCase;

        return $this;
    }

    public function isHavePresenter(): bool
    {
        return $this->havePresenter;
    }

    public function setHavePresenter(bool $havePresenter): MakerTestGenerate
    {
        $this->havePresenter = $havePresenter;

        return $this;
    }

    public function getFiles(): array
    {
        return $this->files;
    }

    public function setFiles(array $files): MakerTestGenerate
    {
        $this->files = $files;

        return $this;
    }
}

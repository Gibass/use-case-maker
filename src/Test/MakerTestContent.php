<?php

namespace Gibass\UseCaseMakerBundle\Test;

class MakerTestContent
{
    public function __construct(
        private string $domain,
        private bool $havePresenter = false,
        private array $files = []
    ) {
    }

    public function getDomain(): string
    {
        return $this->domain;
    }

    public function setDomain(string $domain): MakerTestContent
    {
        $this->domain = $domain;

        return $this;
    }

    public function isHavePresenter(): bool
    {
        return $this->havePresenter;
    }

    public function setHavePresenter(bool $havePresenter): MakerTestContent
    {
        $this->havePresenter = $havePresenter;

        return $this;
    }

    public function getFiles(): array
    {
        return $this->files;
    }

    public function setFiles(array $files): MakerTestContent
    {
        $this->files = $files;

        return $this;
    }

    public function addContent(string $key, string $file, string $content): MakerTestContent
    {
        $this->files[$key] = [
            'name' => $file,
            'content' => $content,
        ];

        return $this;
    }
}

<?php

namespace Dbseller\Aluraplay\Domain\Model;

class Video
{
    private ?int $id;
    private string $url;
    private string $title;
    private ?string $filePath = null;

    public function __construct(?int $id, string $url, string $title)
    {
        $this->id = $id;
        $this->url = $url;
        $this->title = $title;
    }

    public function defineId(int $id): void
    {
        if (!is_null($this->id)) {
            throw new \DomainException('Você só pode definir o id uma vez');
        }

        $this->id = $id;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getFilePath(): ?string
    {
        return $this->filePath;
    }

    public function setFilePath(string $filePath): void 
    {
        $this->filePath = $filePath;
    }
}

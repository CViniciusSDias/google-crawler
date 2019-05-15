<?php
namespace CViniciusSDias\GoogleCrawler;

use CViniciusSDias\GoogleCrawler\Exception\InvalidUrlException;

/**
 * Class that represents a Google Result
 *
 * @package CViniciussDias\GoogleCrawler
 * @author Vinicius Dias
 */
class Result
{
    /** @var string $title */
    private $title;
    /** @var string $url */
    private $url;
    /** @var string $description */
    private $description;

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): Result
    {
        $this->title = $title;
        return $this;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @throws InvalidUrlException
     */
    public function setUrl(string $url): Result
    {
        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            throw new InvalidUrlException();
        }

        $this->url = $url;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): Result
    {
        $description = trim(str_replace("\n", ' ', $description));
        $this->description = $description;
        return $this;
    }
}

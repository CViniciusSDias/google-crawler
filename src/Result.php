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

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return Result
     */
    public function setTitle(string $title): Result
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @param string $url
     * @return Result
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

    /**
     * @return string
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return Result
     */
    public function setDescription(string $description): Result
    {
        $description = trim(str_replace("\n", ' ', $description));
        $this->description = $description;
        return $this;
    }
}

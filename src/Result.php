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
     */
    public function setUrl(string $url): Result
    {
        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            throw new InvalidUrlException();
        }

        $this->url = $url;
        return $this;
    }
}

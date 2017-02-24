<?php
namespace CViniciusSDias\GoogleCrawler;

class SearchTerm
{
    protected $searchTerm;

    /**
     * Initializes the search term
     *
     * @param string $searchTerm
     */
    public function __construct(string $searchTerm)
    {
        $searchTerm = $this->normalize($searchTerm);
        $this->searchTerm = $searchTerm;
    }

    /**
     * Returns the normalized search term
     *
     * @return string
     */
    public function __toString(): string
    {
        return $this->searchTerm;
    }

    /**
     * Normalizes the search term removing its spaces
     *
     * @param $searchTerm
     * @return string
     */
    protected function normalize($searchTerm): string
    {
        return preg_replace('/\s/', '+', $searchTerm);
    }
}

<?php
namespace CViniciusSDias\GoogleCrawler;

/**
 * Class that represents a search term and makes sure that no spaces are used
 *
 * @package CViniciusSDias\GoogleCrawler
 * @author Vinicius Dias
 */
class SearchTerm implements SearchTermInterface
{
    /** @var string $searchTerm */
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
     * @param string $searchTerm
     * @return string
     */
    protected function normalize(string $searchTerm): string
    {
        return rawurlencode($searchTerm);
    }
}

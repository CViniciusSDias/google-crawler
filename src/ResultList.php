<?php
namespace CViniciusSDias\GoogleCrawler;

use Ds\Vector;

/**
 * List of Results
 *
 * @package CViniciusSDias\GoogleCrawler
 * @author Vinicius Dias
 */
class ResultList implements \IteratorAggregate
{
    /** @var Vector $results */
    private $results;

    /**
     * Initializes the result Vector
     *
     * @param int|null $capacity If informed, the vector is initialized with this capacity
     */
    public function __construct(int $capacity = null)
    {
        $this->results = new Vector();

        if (!is_null($capacity)) {
            $this->results->allocate($capacity);
        }
    }

    /**
     * Adds a result to the list
     *
     * @param Result $result
     */
    public function addResult(Result $result)
    {
        $this->results->push($result);
    }

    /**
     * Gets all the results.
     * This method returns a unmodifiable copy of the original collection
     *
     * @return Vector
     */
    public function getResults(): Vector
    {
        /** @var Vector $copy */
        $copy = $this->results->copy();
        return $copy;
    }

    /** {@inheritdoc} */
    public function getIterator(): \Iterator
    {
        return new \IteratorIterator($this->results);
    }
}

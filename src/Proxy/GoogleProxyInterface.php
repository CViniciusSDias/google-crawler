<?php
namespace CViniciusSDias\GoogleCrawler\Proxy;

use CViniciusSDias\GoogleCrawler\Exception\InvalidResultException;
use Psr\Http\Message\ResponseInterface;

/**
 * Interface that represents an online proxy service.
 * Every class that implement it must know how to return the apropriate ResponseInterface to an url based on what
 * the proxy service needs, and must know how to parse an url used within its pages.
 *
 * @package CViniciussDias\GoogleCrawler\Proxy
 * @author Vinicius Dias
 */
interface GoogleProxyInterface
{
    /**
     * Gets the ResponseInterface for the informed URL based on all the information that
     * the proxy service needs
     *
     * @param string $url
     * @return ResponseInterface
     */
    public function getHttpResponse(string $url): ResponseInterface;

    /**
     * Parses an URL based on how they are encoded in the proxy service
     *
     * @param string $url
     * @return string
     * @throws InvalidResultException
     */
    public function parseUrl(string $url): string;
}

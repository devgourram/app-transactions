<?php

namespace Ositel\TransactionBundle\Service;

/**
 * Class ParamFetcher
 *
 * @package Ositel\TransactionBundle\Service
 */
class ParamFetcher
{
    /**
     * @param array  $params
     * @param string $paramName
     *
     * @return int|null
     */
    public function fetchPage(array $params, string $paramName): ?int
    {
        return $params[$paramName] ?? 1;
    }

    /**
     * @param array $params
     *
     * @return array
     */
    public function fetchFilters(array $params): array
    {
        return [];
    }
}
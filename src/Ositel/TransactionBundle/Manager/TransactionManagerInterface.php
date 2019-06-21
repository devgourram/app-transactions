<?php
namespace Ositel\TransactionBundle\Manager;

use Ositel\TransactionBundle\Entity\Transaction;

/**
 * Interface TransactionManagerInterface
 *
 * @package Ositel\TransactionBundle\Manager
 */
interface TransactionManagerInterface
{
    /**
     * @param array $params
     *
     * @return array
     */
    public function fetchPagedTransactions(array $params): array;

    /**
     * @return array
     */
    public function fetchAll(): array;

    /**
     * @param int $id
     *
     * @return Transaction|null
     */
    public function find(int $id): ?Transaction;

    /**
     * @param array $params
     *
     * @return array
     */
    public function search(array $params): array ;

    /**
     * @param array $params
     *
     * @return array
     */
    public function filter(array $params): array ;

    /**
     * @param array $transactions
     *
     * @return float
     */
    public function calculateTotalInputOutput(array $transactions): float;
}

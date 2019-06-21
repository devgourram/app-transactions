<?php

namespace Ositel\TransactionBundle\Manager;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Ositel\TransactionBundle\Entity\Transaction;
use Ositel\TransactionBundle\Repository\TransactionRepository;
use Ositel\TransactionBundle\Service\ParamFetcher;

/**
 * Class TransactionManager
 *
 * @package Ositel\TransactionBundle\Manager
 */
class TransactionManager implements TransactionManagerInterface
{
    const MAX_PEER_PAGE = 5;
    const FETCH_OFFSET = 5;
    const FILERS_PARAMS = [

    ];

    const PAGINATOR_PARAM = 'page';


    /**
     * @var TransactionRepository
     */
    private $transactionRepository;

    /**
     * @var ParamFetcher
     */
    private $paramFetcher;

    /**
     * TransactionManager constructor.
     *
     * @param EntityManagerInterface $entityManager
     * @param ParamFetcher           $paramFetcher
     */
    public function __construct(EntityManagerInterface  $entityManager, ParamFetcher $paramFetcher)
    {
        $this->transactionRepository = $entityManager->getRepository(Transaction::class);
        $this->paramFetcher = $paramFetcher;
    }

    /**
     * @param array $params
     *
     * @return array
     */
    public function fetchPagedTransactions(array $params): array
    {
        return $this->transactionRepository->findBy(
            $this->paramFetcher->fetchFilters($params),
            [],
            self::MAX_PEER_PAGE,
            ($this->paramFetcher->fetchPage($params, self::PAGINATOR_PARAM) - 1) * self::FETCH_OFFSET
        );
    }

    /**
     * @return array
     */
    public function fetchAll(): array
    {
        return $this->transactionRepository->findAll();
    }

    /**
     * @param int $id
     *
     * @return Transaction|null
     */
    public function find(int $id): ?Transaction
    {
        return $this->transactionRepository->find($id);
    }

    /**
     * @param array $params
     *
     * @return array
     */
    public function search(array $params): array
    {
        return $this->transactionRepository->search($params);
    }

    /**
     * @param array $params
     *
     * @return array
     */
    public function filter(array $params): array
    {
        return $this->transactionRepository->filter($params);
    }

    /**
     * @param array $transactions
     *
     * @return float
     */
    public function calculateTotalInputOutput(array $transactions): float
    {
        $sum = 0.00;

        /** @var Transaction $transaction */
        foreach ($transactions as $transaction) {
            $sum += $transaction['amount'];
        }

        return $sum;
    }
}
<?php

namespace Ositel\TransactionBundle\Controller\V1;

use Ositel\TransactionBundle\Manager\TransactionManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class TransactionApiController
 *
 * @package Ositel\TransactionBundle\Controller\V1
 */
class TransactionApiController extends Controller
{
    /**
     * @var TransactionManagerInterface
     */
    private $transactionManager;

    /**
     * TransactionController constructor.
     *
     * @param TransactionManagerInterface $transactionManager
     */
    public function __construct(TransactionManagerInterface $transactionManager)
    {
        $this->transactionManager = $transactionManager;
    }

    /**
     * @param Request $request
     *
     * @throws \Exception
     *
     * @return JsonResponse
     */
    public function getAction(Request $request)
    {
        $now = new \DateTime();
        $params = $request->query->all();
        $month = (isset($params['month'])) ? $params['month'] : $now->format('m');
        $year = $now->format('Y');

        $transactions = $this->transactionManager->filter(['month' => $month, 'year' => $year]);
        $totalInput = $this->transactionManager->calculateTotalInput($transactions);
        $totalOutput = $this->transactionManager->calculateTotalOutput($transactions);

        return new JsonResponse([
            'transactions' => $transactions,
            'total_amount' => $totalInput + $totalOutput,
            'total_output' => $totalOutput,
            'total_input' => $totalInput
        ]);
    }
}

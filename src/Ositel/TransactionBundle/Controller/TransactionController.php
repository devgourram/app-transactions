<?php

namespace Ositel\TransactionBundle\Controller;

use Ositel\TransactionBundle\Form\SearchType;
use Ositel\TransactionBundle\Form\TransactionType;
use Ositel\TransactionBundle\Manager\TransactionManager;
use Ositel\TransactionBundle\Manager\TransactionManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class TransactionController
 *
 * @package Ositel\TransactionBundle\Controller
 */
class TransactionController extends Controller
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
     * @return Response
     */
    public function indexAction(Request $request)
    {
        $transactions = $this->transactionManager->fetchPagedTransactions($request->query->all());
        $countTransactions = count($this->transactionManager->fetchAll());
        $pages = round($countTransactions / TransactionManager::MAX_PEER_PAGE);
        $searchForm = $this->createForm(SearchType::class);

        $searchForm->handleRequest($request);
        if ($searchForm->isSubmitted() && $searchForm->isValid()) {
            $searchParams = $searchForm->getData();
            $transactions = $this->transactionManager->search($searchParams);
        }

        return $this->render('@Transaction/transaction/list.html.twig', [
            'transactions' => $transactions,
            'pages' => $pages,
            'current_page' => $request->query->get(TransactionManager::PAGINATOR_PARAM) ?? 1,
            'total_items' => $countTransactions,
            'search_form' => $searchForm->createView()
        ]);
    }

    /**
     * @param Request $request
     * @param         $id
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function editAction(Request $request, $id)
    {
        $transaction = $this->transactionManager->find($id);

        if (!$transaction) {
            throw new NotFoundHttpException(sprintf('Transaction with id [%s] not found', $id));
        }

        $form = $this->createForm(TransactionType::class, $transaction);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('app.transaction.get');
        }

        return $this->render('@Transaction/transaction/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function newAction(Request $request)
    {
        $form = $this->createForm(TransactionType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->persist($form->getData());
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('app.transaction.get');
        }

        return $this->render('@Transaction/transaction/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @param Request $request
     * @param int $id
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(Request $request, int $id)
    {
        $transaction = $this->transactionManager->find($id);

        if (!$transaction) {
            throw new NotFoundHttpException(sprintf('Transaction with id [%s] not found', $id));
        }

        $this->getDoctrine()->getManager()->remove($transaction);
        $this->getDoctrine()->getManager()->flush();

        return $this->redirectToRoute('app.transaction.get');
    }

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function reportAction(Request $request)
    {
        return $this->render('@Transaction/transaction/api.report.html.twig');
    }
}

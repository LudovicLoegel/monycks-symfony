<?php

namespace App\Controller\Admin;

use App\Entity\Transaction;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class TransactionController extends Controller
{
    /**
     * @Route("/admin/transaction/{id}/delete", name="transaction_delete")
     */
    public function deleteTransactionAction(Transaction $transaction)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($transaction);
        $em->flush();

        return $this->redirectToRoute('admin');
    }
}

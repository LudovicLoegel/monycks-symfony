<?php

namespace App\Controller;

use App\Entity\Skill;
use App\Entity\Transaction;
use App\Form\SkillType;
use App\Form\TransactionType;
use App\Repository\OfferRepository;
use App\Repository\SkillRepository;
use App\Repository\TicketRepository;
use App\Repository\TransactionRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;


class AdminController extends Controller
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(Request $request,OfferRepository $offerRepository ,TicketRepository $ticketRepository,SkillRepository $skillRepository, TransactionRepository $transactionRepository, UserRepository $userRepository)
    {
        $skills = $skillRepository->findAll();
        $users = $userRepository->findAll();
        $transactions = $transactionRepository->findAll();
        $tickets = $ticketRepository->findAll();
        $offers = $offerRepository->findAll();
        // 1) build the skillForm
        $skill = new Skill();
        $transaction = new Transaction();
        $skillForm = $this->createForm(SkillType::class, $skill);
        $transForm = $this->createForm(TransactionType::class, $transaction);

        // 2) handle the submit (will only happen on POST)
        $skillForm->handleRequest($request);
        $transForm->handleRequest($request);


        if ($skillForm->isSubmitted() && $skillForm->isValid()) {

            // 4) save the User!
            $em = $this->getDoctrine()->getManager();
            $em->persist($skill);
            $em->flush();

            // ... do any other work - like sending them an email, etc
            // maybe set a "flash" success message for the skill

            return $this->redirectToRoute('admin');
        }

        if ($transForm->isSubmitted() && $transForm->isValid()) {

            // 4) save the User!
            $em = $this->getDoctrine()->getManager();
            $em->persist($transaction);
            $em->flush();

            // ... do any other work - like sending them an email, etc
            // maybe set a "flash" success message for the skill

            return $this->redirectToRoute('admin');
        }


        return $this->render(
            'admin/admin.html.twig',
            array(
                'users' => $users,
                'skills' => $skills,
                'transactions' => $transactions,
                'tickets' => $tickets,
                'offers' => $offers
            )
        );
    }

}

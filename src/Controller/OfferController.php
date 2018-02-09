<?php
/**
 * Created by PhpStorm.
 * User: loegel
 * Date: 19/01/18
 * Time: 15:23
 */

namespace App\Controller;

use App\Entity\Ticket;
use App\Entity\Offer;
use App\Form\OfferType;
use App\Repository\UserRepository;
use App\Repository\TicketRepository;
use App\Repository\OfferRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class OfferController extends Controller
{
    /**
     * @Route("/offer", name="offer_list")
     */
    public function index(Request $request, TicketRepository $ticketRepository,OfferRepository $offerRepository)
    {
        // 1) build the skillForm
        $offer = new Offer();
        $offerForm = $this->createForm(OfferType::class, $offer);
        $offers = $offerRepository->findAll();
        $tickets = $ticketRepository->findAll();

        // 2) handle the submit (will only happen on POST)
        $offerForm->handleRequest($request);


        if ($offerForm->isSubmitted() && $offerForm->isValid()) {

            // 4) save the User!
            $em = $this->getDoctrine()->getManager();
            $em->persist($offer);
            $em->flush();

            // ... do any other work - like sending them an email, etc
            // maybe set a "flash" success message for the skill

            return $this->redirectToRoute('offer_list');
        }

        return $this->render(
            'offer/list.html.twig',
            array(
                "form"=> $offerForm->createView(),
                'tickets' => $tickets,
                'offers' => $offers,
            )
        );
    }

    /**
     * @Route("/offer/{id}", name="offer_add",
     *     requirements={
     *         "id": "\d+"
     *     })
     */
    public function newOffer($id, Request $request, TicketRepository $ticketRepository,OfferRepository $offerRepository)
    {
        // 1) build the skillForm
        $offer = new Offer();
        $offerForm = $this->createForm(OfferType::class, $offer);
        $ticket = $ticketRepository->find($id);

        // 2) handle the submit (will only happen on POST)
        $offerForm->handleRequest($request);


        if ($offerForm->isSubmitted() && $offerForm->isValid()) {

            // 4) save the User!
            $em = $this->getDoctrine()->getManager();
            $em->persist($offer);
            $em->flush();

            // ... do any other work - like sending them an email, etc
            // maybe set a "flash" success message for the skill

            return $this->redirectToRoute('offer_list');
        }

        return $this->render(
            'offer/add.html.twig',
            array(
                "form"=> $offerForm->createView(),
                'ticket' => $ticket,
            )
        );
    }
}
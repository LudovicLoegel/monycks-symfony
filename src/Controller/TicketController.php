<?php

namespace App\Controller;

use App\Entity\Ticket;
use App\Form\TicketType;
use App\Repository\SkillRepository;
use App\Repository\TicketRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class TicketController extends Controller
{
    /**
     * @Route("/ticket", name="ticket_list")
     */
    public function index(Request $request, TicketRepository $ticketRepository,SkillRepository $skillRepository)
    {
        // 1) build the skillForm
        $ticket = new Ticket();
        $ticketForm = $this->createForm(TicketType::class, $ticket);
        $ticketsProgress = $ticketRepository->findTicketProgress();
        $ticketsWaiting = $ticketRepository->findBy(['status' => NULL]);
        $skills = $skillRepository->findAll();


        // 2) handle the submit (will only happen on POST)
        $ticketForm->handleRequest($request);


        if ($ticketForm->isSubmitted() && $ticketForm->isValid()) {

            // 4) save the User!
            $em = $this->getDoctrine()->getManager();
            $em->persist($ticket);
            $em->flush();

            // ... do any other work - like sending them an email, etc
            // maybe set a "flash" success message for the skill

            return $this->redirectToRoute('ticket_list');
        }

        return $this->render(
            'ticket/list.html.twig',
            array(
                'ticketForm'=> $ticketForm->createView(),
                'ticketsP' => $ticketsProgress,
                'ticketsW' => $ticketsWaiting,
                'skills' => $skills,
            )
        );
    }

    /**
     * @Route("/ticket/see/{id}", name="ticket_see",
     *     requirements={
     *         "id": "\d+"
     *     }))
     */
    public function ticketSee($id, TicketRepository $ticketRepository)
    {
        $ticket = $ticketRepository->find($id);

        return $this->render(
            'ticket/see.html.twig',
            array(
                'ticket' => $ticket,
            )
        );
    }

    /**
     * @Route("/ticket/offer/{idt}/{ido}", name="ticket_offer",
     *     requirements={
     *         "idt": "\d+",
     *         "ido": "\d+"
     *     }))
     */
    public function ticketOffer($idt,$ido, TicketRepository $ticketRepository)
    {
        $ticket = $ticketRepository->find($idt);
        $ticket->setStatus($ido);
        $em = $this->getDoctrine()->getManager();
        $em->persist($ticket);
        $em->flush();
        return $this->redirectToRoute('ticket_list');
    }
}

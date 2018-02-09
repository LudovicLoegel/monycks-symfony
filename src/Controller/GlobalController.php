<?php

namespace App\Controller;

use App\Repository\SkillRepository;
use App\Repository\TicketRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class GlobalController extends Controller
{
    /**
     * @Route("/",name="homepage")
     */
    public function indexAction(TicketRepository $ticketRepository)
    {
        $tickets = $ticketRepository->findAll();
        return $this->render('base.html.twig',array(
            'tickets' => $tickets
        ));
    }

    /**
     * @Route("/ticket",name="ticket_list")
     */
    public function ticketListAction(SkillRepository $skillRepository,TicketRepository $ticketRepository)
    {
        $skills = $skillRepository->findAll();
        $tickets = $ticketRepository->findAll();
        return $this->render('ticket/add.html.twig',array(
            'skills' => $skills,
            'tickets' => $tickets
        ));
    }
}

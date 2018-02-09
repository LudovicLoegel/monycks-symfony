<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SkillRepository")
 */
class Skill
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     */
   private $name;

    /**
     * @ORM\OneToMany(targetEntity="User",mappedBy="skills",cascade={"persist", "remove"})
     */
   private $users;

    /**
     * @ORM\OneToMany(targetEntity="Ticket",mappedBy="skill")
     */
   private $tickets;

    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->tickets = new ArrayCollection();
    }

    public function addUser(User $user)
    {
        if (!$this->users->contains($user))
            $this->users->add($user);
    }

    public function addTicket(Ticket $ticket)
    {
        if (!$this->tickets->contains($ticket))
            $this->tickets->add($ticket);
    }

    /**
     * @return Ticket[]
     */
    public function getTickets()
    {
        return $this->tickets->toArray();
    }

    /**
     * @return User[]
     */
    public function getUsers()
    {
        return $this->users->toArray();
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }


    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }



}

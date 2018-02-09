<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TransactionRepository")
 */
class Transaction
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="senders")
     * @ORM\JoinColumn(nullable=true)
     */
    private $sender;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="receivers")
     * @ORM\JoinColumn(nullable=true)
     */
    private $receiver;

    /**
     * @ORM\Column(type="integer")
     */
    private $amount;

    /**
     * @ORM\Column(type="datetime",nullable=true)
     */
    private $date;

    /**
     * @ORM\Column(type="text")
     */
    private $comment;

    public function getSender()
    {
        return $this->sender;
    }

    public function setSender(User $user)
    {
        $this->sender = $user;
    }


    public function getReceiver()
    {
        return $this->receiver;
    }

    public function setReceiver(User $user)
    {
        $this->receiver = $user;
    }

    /**
     * @return mixed
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * @param mixed $comment
     */
    public function setComment($comment): void
    {
        $this->comment = $comment;
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
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param mixed $amount
     */
    public function setAmount($amount): void
    {
        $this->amount = $amount;
    }

    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param mixed
     */
    public function setDate()
    {
        $this->date = new \DateTime("now");
    }


}

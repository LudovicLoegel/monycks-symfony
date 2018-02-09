<?php
// src/Entity/User.php
namespace App\Entity;

use App\Repository\TransactionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use App\Entity\Transaction;

/**
 * @ORM\Entity
 * @UniqueEntity(fields="email", message="Email already taken")
 * @UniqueEntity(fields="username", message="Username already taken")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     * @Assert\NotBlank()
     */
    private $username;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(max=4096)
     */
    private $plainPassword;

    /**
     * The below length depends on the "algorithm" you use for encoding
     * the password, but this works well with bcrypt.
     *
     * @ORM\Column(type="string", length=64)
     */
    private $password;

    /**
     * @var Monycks
     */
    private $monycks = 10000;


    /**
     * @ORM\ManyToOne(targetEntity="Skill",inversedBy="users")
     */
    private $skills;

    /**
     * @ORM\OneToMany(targetEntity="Transaction", mappedBy="receiver")
     */
    private $receivers;

    /**
     * @ORM\OneToMany(targetEntity="Transaction", mappedBy="sender")
     */
    private $senders;

    /**
     * @ORM\OneToMany(targetEntity="Ticket", mappedBy="user")
     */
    private $tickets;

    /**
     * @ORM\OneToMany(targetEntity="Offer", mappedBy="user")
     */
    private $offers;

    public function __construct()
    {
        $this->senders = new ArrayCollection();
        $this->receivers = new ArrayCollection();
        $this->tickets = new ArrayCollection();
        $this->offers = new ArrayCollection();
    }

    /**
     * @return Collection|Ticket[]
     */
    public function getTickets()
    {
        return $this->tickets;
    }

    /**
     * @param mixed $tickets
     */
    public function setTickets($tickets): void
    {
        $this->tickets = $tickets;
    }

    /**
     * @return Collection|Offer[]
     */
    public function getOffers()
    {
        return $this->offers;
    }

    /**
     * @param mixed $offers
     */
    public function setOffers($offers): void
    {
        $this->offers = $offers;
    }



    /**
     * @return mixed
     */
    public function getSkills()
    {
        return $this->skills;
    }

    /**
     * @param mixed $skills
     */
    public function setSkills($skills): void
    {
        $this->skills = $skills;
    }


    /**
     * @return Collection|Transaction[]
     */
    public function getReceivers()
    {
        return $this->receivers;
    }

    /**
     * @return Collection|Transaction[]
     */
    public function getSenders()
    {
        return $this->senders;
    }

    /**
     * @return Monycks
     */
    public function getMonycks()
    {
        $outings = 0;
        foreach ($this->getSenders() as $sender) {
            $outings += $sender->getAmount();
        }
        $income = 0;

        foreach ($this->getReceivers() as $receiver) {
            $income += $receiver->getAmount();
        }
        return ($this->monycks - $outings + $income);
    }

    /**
     * @param Monycks $monycks
     */
    public function setMonycks($monycks): void
    {
        $this->monycks = $monycks;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    // other properties and methods


    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function setUsername($username)
    {
        $this->username = $username;
    }

    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    public function setPlainPassword($password)
    {
        $this->plainPassword = $password;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function getSalt()
    {
        // The bcrypt algorithm doesn't require a separate salt.
        // You *may* need a real salt if you choose a different encoder.
        return null;
    }

    public function getRoles()
    {
        if($this->getUsername()=='admin')
            return array('ROLE_ADMIN', 'ROLE_USER');
        return array('ROLE_USER');
    }


    public function eraseCredentials()
    {
    }

    /** @see \Serializable::serialize() */
    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->username,
            $this->password,
            // see section on salt below
            // $this->salt,
        ));
    }

    /** @see \Serializable::unserialize() */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->username,
            $this->password,
            // see section on salt below
            // $this->salt
            ) = unserialize($serialized);
    }

}

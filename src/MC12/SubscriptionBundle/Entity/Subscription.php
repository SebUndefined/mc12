<?php

namespace MC12\SubscriptionBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Subscription
 *
 * @ORM\Table(name="subscription")
 * @ORM\Entity(repositoryClass="MC12\SubscriptionBundle\Repository\SubscriptionRepository")
 */
class Subscription
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(name="price", type="decimal")
     */
    private $totalPrice;

    /**
     * @ORM\Column(name="creation_date", type="datetime")
     */
    private $creationDate;

    /**
     * @ORM\Column(name="validated", type="boolean")
     */
    private $validated;

    /**
     * @ORM\Column(name="payment_done", type="boolean")
     */
    private $paymentDone;
    /**
     * @ORM\OneToOne(targetEntity="MC12\SubscriptionBundle\Entity\Competitor", cascade={"persist", "remove"})
     */
    private $competitor;

    /**
     * @ORM\ManyToOne(targetEntity="MC12\SubscriptionBundle\Entity\Race", inversedBy="subscriptions")
     */
    private $race;


    /**
     * @ORM\OneToMany(targetEntity="MC12\SubscriptionBundle\Entity\SubscriptionMeal",
     *     mappedBy="subscription", cascade={"persist"}, orphanRemoval=true)
     */
    private $subscriptionMeals;

    public function __construct()
    {
        $this->subscriptionMeals = new ArrayCollection();
        $this->creationDate = new \DateTime();
        $this->validated = false;
        $this->paymentDone = false;
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getTotalPrice()
    {
        return $this->totalPrice;
    }




    /**
     * @param mixed $totalPrice
     */
    public function setTotalPrice($totalPrice)
    {
        $this->totalPrice = $totalPrice;
    }


    /**
     * @return mixed
     */
    public function getCreationDate()
    {
        return $this->creationDate;
    }

    /**
     * @param mixed $creationDate
     */
    public function setCreationDate($creationDate)
    {
        $this->creationDate = $creationDate;
    }

    /**
     * @return mixed
     */
    public function getValidated()
    {
        return $this->validated;
    }

    /**
     * @param mixed $validated
     */
    public function setValidated($validated)
    {
        $this->validated = $validated;
    }

    /**
     * @return mixed
     */
    public function getPaymentDone()
    {
        return $this->paymentDone;
    }

    /**
     * @param mixed $paymentDone
     */
    public function setPaymentDone($paymentDone)
    {
        $this->paymentDone = $paymentDone;
    }



    /**
     * @return mixed
     */
    public function getCompetitor()
    {
        return $this->competitor;
    }

    /**
     * @param mixed $competitor
     */
    public function setCompetitor($competitor)
    {
        $this->competitor = $competitor;
    }

    /**
     * @return mixed
     */
    public function getRace()
    {
        return $this->race;
    }

    /**
     * @param mixed $race
     */
    public function setRace($race)
    {
        $this->race = $race;
    }

    /**
     * @return mixed
     */
    public function getSubscriptionMeals()
    {
        return $this->subscriptionMeals;
    }

    /**
     * @param mixed $subscriptionMeals
     */
    public function setSubscriptionMeals($subscriptionMeals)
    {
        $this->subscriptionMeals = $subscriptionMeals;
    }



}


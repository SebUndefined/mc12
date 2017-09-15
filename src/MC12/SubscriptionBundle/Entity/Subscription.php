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
     * @ORM\OneToOne(targetEntity="MC12\SubscriptionBundle\Entity\Competitor", cascade={"persist"})
     */
    private $competitor;

    /**
     * @ORM\ManyToOne(targetEntity="MC12\SubscriptionBundle\Entity\Race", inversedBy="subscriptions")
     */
    private $race;


    /**
     * @ORM\OneToMany(targetEntity="MC12\SubscriptionBundle\Entity\SubscriptionMeal", mappedBy="subscription")
     */
    private $subscriptionMeals;

    public function __construct()
    {
        $this->subscriptionMeals = new ArrayCollection();
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


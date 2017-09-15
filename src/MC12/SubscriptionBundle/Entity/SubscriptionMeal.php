<?php

namespace MC12\SubscriptionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SubscriptionMeal
 *
 * @ORM\Table(name="subscription_meal")
 * @ORM\Entity(repositoryClass="MC12\SubscriptionBundle\Repository\SubscriptionMealRepository")
 */
class SubscriptionMeal
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
     * @var int
     *
     * @ORM\Column(name="number", type="integer")
     */
    private $number;

    /**
     * @ORM\ManyToOne(targetEntity="MC12\SubscriptionBundle\Entity\Subscription", inversedBy="subscriptionMeals")
     */
    private $subscription;

    /**
     * @ORM\ManyToOne(targetEntity="MC12\SubscriptionBundle\Entity\Meal")
     */
    private $meal;

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
     * Set number
     *
     * @param integer $number
     *
     * @return SubscriptionMeal
     */
    public function setNumber($number)
    {
        $this->number = $number;

        return $this;
    }

    /**
     * Get number
     *
     * @return int
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * @return mixed
     */
    public function getSubscription()
    {
        return $this->subscription;
    }

    /**
     * @param mixed $subscription
     */
    public function setSubscription($subscription)
    {
        $this->subscription = $subscription;
    }

    /**
     * @return mixed
     */
    public function getMeal()
    {
        return $this->meal;
    }

    /**
     * @param mixed $meal
     */
    public function setMeal($meal)
    {
        $this->meal = $meal;
    }



}


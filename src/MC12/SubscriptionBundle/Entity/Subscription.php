<?php

namespace MC12\SubscriptionBundle\Entity;

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
     * @ORM\OneToOne(targetEntity="MC12\SubscriptionBundle\Entity\Competitor", cascade={"persist"})
     */
    private $competitor;

    /**
     * @ORM\ManyToOne(targetEntity="MC12\SubscriptionBundle\Entity\Race", inversedBy="subscriptions")
     */
    private $race;


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


}


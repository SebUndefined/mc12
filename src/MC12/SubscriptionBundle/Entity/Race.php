<?php

namespace MC12\SubscriptionBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Race
 *
 * @ORM\Table(name="race")
 * @ORM\Entity(repositoryClass="MC12\SubscriptionBundle\Repository\RaceRepository")
 */
class Race
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
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     */
    private $name;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateBegin", type="datetime")
     */
    private $dateBegin;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateEnd", type="datetime")
     */
    private $dateEnd;

    /**
     * @ORM\Column(name="open", type="boolean")
     */
    private $open = true;

    /**
     * @ORM\Column(name="competitorSize", type="integer")
     */
    private $competitorSize;

    /**
     * @ORM\Column(name="subscriptionPrice", type="decimal")
     */
    private $subscriptionPrice;
    /**
     * @ORM\Column(name="one_day_licence_price", type="decimal")
     */
    private $oneDayLicencePrice;

    /**
     * @ORM\OneToMany(targetEntity="MC12\SubscriptionBundle\Entity\Subscription", mappedBy="race")
     */
    private $subscriptions;
    /**
     * @ORM\OneToMany(targetEntity="MC12\SubscriptionBundle\Entity\Stage", mappedBy="race")
     */
    private $stages;

    /**
     * @ORM\ManyToMany(targetEntity="MC12\SubscriptionBundle\Entity\Category")
     */
    private $categories;

    public function __construct()
    {
        $this->subscriptions = new ArrayCollection();
        $this->categories = new ArrayCollection();
        $this->stages = new ArrayCollection();
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
     * Set name
     *
     * @param string $name
     *
     * @return Race
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set dateBegin
     *
     * @param \DateTime $dateBegin
     *
     * @return Race
     */
    public function setDateBegin($dateBegin)
    {
        $this->dateBegin = $dateBegin;

        return $this;
    }

    /**
     * Get dateBegin
     *
     * @return \DateTime
     */
    public function getDateBegin()
    {
        return $this->dateBegin;
    }

    /**
     * Set dateEnd
     *
     * @param \DateTime $dateEnd
     *
     * @return Race
     */
    public function setDateEnd($dateEnd)
    {
        $this->dateEnd = $dateEnd;

        return $this;
    }

    /**
     * Get dateEnd
     *
     * @return \DateTime
     */
    public function getDateEnd()
    {
        return $this->dateEnd;
    }

    /**
     * @return mixed
     */
    public function getOpen()
    {
        return $this->open;
    }

    /**
     * @param mixed $open
     */
    public function setOpen($open)
    {
        $this->open = $open;
    }

    /**
     * @return mixed
     */
    public function getCompetitorSize()
    {
        return $this->competitorSize;
    }

    /**
     * @param mixed $competitorSize
     */
    public function setCompetitorSize($competitorSize)
    {
        $this->competitorSize = $competitorSize;
    }

    /**
     * @return mixed
     */
    public function getSubscriptionPrice()
    {
        return $this->subscriptionPrice;
    }

    /**
     * @param mixed $subscriptionPrice
     */
    public function setSubscriptionPrice($subscriptionPrice)
    {
        $this->subscriptionPrice = $subscriptionPrice;
    }

    /**
     * @return mixed
     */
    public function getOneDayLicencePrice()
    {
        return $this->oneDayLicencePrice;
    }

    /**
     * @param mixed $oneDayLicencePrice
     */
    public function setOneDayLicencePrice($oneDayLicencePrice)
    {
        $this->oneDayLicencePrice = $oneDayLicencePrice;
    }


    /**
     * @return mixed
     */
    public function getSubscriptions()
    {
        return $this->subscriptions;
    }

    /**
     * @param mixed $subscriptions
     */
    public function setSubscriptions($subscriptions)
    {
        $this->subscriptions = $subscriptions;
    }

    /**
     * @param Category $category
     */
    public function addCategory(Category $category)
    {
        $this->categories[] = $category;
    }

    /**
     * @param Category $category
     */
    public function removeCategory(Category $category)
    {
        $this->categories->removeElement($category);
    }

    /**
     * @return ArrayCollection
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * @return mixed
     */
    public function getStages()
    {
        return $this->stages;
    }

    /**
     * @param mixed $stages
     */
    public function setStages($stages)
    {
        $this->stages = $stages;
    }




}


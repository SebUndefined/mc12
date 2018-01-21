<?php

namespace MC12\SubscriptionBundle\Entity;


use Doctrine\ORM\Mapping as ORM;

/**
 * Meal
 *
 * @ORM\Table(name="meal")
 * @ORM\Entity(repositoryClass="MC12\SubscriptionBundle\Repository\MealRepository")
 */
class Meal
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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="place", type="string", length=255)
     */
    private $place;

    /**
     *
     *
     * @ORM\Column(name="price", type="decimal", precision=10, nullable=false)
     */
    private $price;

    /**
     * @ORM\ManyToOne(targetEntity="MC12\SubscriptionBundle\Entity\Stage", inversedBy="meals", cascade={"persist"})
     */
    private $stage;
    /**
     * @ORM\OneToMany(targetEntity="MC12\SubscriptionBundle\Entity\SubscriptionMeal",
     *     mappedBy="meal", cascade={"persist"}, orphanRemoval=true)
     */
    private $mealSubscription;


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
     * @return Meal
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
     * Set place
     *
     * @param string $place
     *
     * @return Meal
     */
    public function setPlace($place)
    {
        $this->place = $place;

        return $this;
    }

    /**
     * Get place
     *
     * @return string
     */
    public function getPlace()
    {
        return $this->place;
    }

    /**
     * @return mixed
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param mixed $price
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }

    /**
     * @return mixed
     */
    public function getStage()
    {
        return $this->stage;
    }

    /**
     * @param mixed $stage
     */
    public function setStage($stage)
    {
        $this->stage = $stage;
    }

    /**
     * @return mixed
     */
    public function getMealSubscription()
    {
        return $this->mealSubscription;
    }

    /**
     * @param mixed $mealSubscription
     */
    public function setMealSubscription($mealSubscription)
    {
        $this->mealSubscription = $mealSubscription;
    }


}


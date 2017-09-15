<?php

namespace MC12\SubscriptionBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Category
 *
 * @ORM\Table(name="category")
 * @ORM\Entity(repositoryClass="MC12\SubscriptionBundle\Repository\CategoryRepository")
 */
class Category
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
     * @ORM\OneToMany(targetEntity="MC12\SubscriptionBundle\Entity\Competitor", mappedBy="category")
     */
    private $competitors;

    /**
     * @ORM\OneToMany(targetEntity="MC12\SubscriptionBundle\Entity\CategoryMarking", mappedBy="category")
     */
    private $categoryMarkings;
    /**
     * Category constructor.
     *
     */
    public function __construct()
    {
        $this->competitors = new ArrayCollection();
        $this->categoryMarkings = new ArrayCollection();
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
     * @return Category
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
     * @return mixed
     */
    public function getCompetitors()
    {
        return $this->competitors;
    }

    /**
     * @param mixed $competitors
     */
    public function setCompetitors($competitors)
    {
        $this->competitors = $competitors;
    }

    /**
     * @return mixed
     */
    public function getCategoryMarkings()
    {
        return $this->categoryMarkings;
    }

    /**
     * @param mixed $categoryMarkings
     */
    public function setCategoryMarkings($categoryMarkings)
    {
        $this->categoryMarkings = $categoryMarkings;
    }


}


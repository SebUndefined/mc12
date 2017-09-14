<?php

namespace MC12\SubscriptionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CategoryMarking
 *
 * @ORM\Table(name="category_marking")
 * @ORM\Entity(repositoryClass="MC12\SubscriptionBundle\Repository\CategoryMarkingRepository")
 */
class CategoryMarking
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
     * @ORM\Column(name="proportion", type="integer")
     */
    private $proportion;

    /**
     * @ORM\ManyToOne(targetEntity="MC12\SubscriptionBundle\Entity\Category")
     * @ORM\JoinColumn(nullable=false)
     */
    private $category;

    /**
     * @ORM\ManyToOne(targetEntity="MC12\SubscriptionBundle\Entity\Marking")
     * @ORM\JoinColumn(nullable=false)
     */
    private $marking;

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
     * Set proportion
     *
     * @param integer $proportion
     *
     * @return CategoryMarking
     */
    public function setProportion($proportion)
    {
        $this->proportion = $proportion;

        return $this;
    }

    /**
     * Get proportion
     *
     * @return int
     */
    public function getProportion()
    {
        return $this->proportion;
    }

    /**
     * @return mixed
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param mixed $category
     */
    public function setCategory($category)
    {
        $this->category = $category;
    }

    /**
     * @return mixed
     */
    public function getMarking()
    {
        return $this->marking;
    }

    /**
     * @param mixed $marking
     */
    public function setMarking($marking)
    {
        $this->marking = $marking;
    }


}


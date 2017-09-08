<?php

namespace MC12\SubscriptionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Motorbike
 *
 * @ORM\Table(name="motorbike")
 * @ORM\Entity(repositoryClass="MC12\SubscriptionBundle\Repository\MotorbikeRepository")
 */
class Motorbike
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
     * @ORM\Column(name="brand", type="string", length=255)
     */
    private $brand;

    /**
     * @var int
     *
     * @ORM\Column(name="cylinder", type="integer")
     */
    private $cylinder;

    /**
     * @var string
     *
     * @ORM\Column(name="insuranceCompany", type="string", length=255)
     */
    private $insuranceCompany;

    /**
     * @var string
     *
     * @ORM\Column(name="insuranceNumber", type="string", length=255)
     */
    private $insuranceNumber;

    /**
     * @var string
     *
     * @ORM\Column(name="registrationNumber", type="string", length=50)
     */
    private $registrationNumber;


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
     * Set brand
     *
     * @param string $brand
     *
     * @return Motorbike
     */
    public function setBrand($brand)
    {
        $this->brand = $brand;

        return $this;
    }

    /**
     * Get brand
     *
     * @return string
     */
    public function getBrand()
    {
        return $this->brand;
    }

    /**
     * Set cylinder
     *
     * @param integer $cylinder
     *
     * @return Motorbike
     */
    public function setCylinder($cylinder)
    {
        $this->cylinder = $cylinder;

        return $this;
    }

    /**
     * Get cylinder
     *
     * @return int
     */
    public function getCylinder()
    {
        return $this->cylinder;
    }

    /**
     * Set insuranceCompany
     *
     * @param string $insuranceCompany
     *
     * @return Motorbike
     */
    public function setInsuranceCompany($insuranceCompany)
    {
        $this->insuranceCompany = $insuranceCompany;

        return $this;
    }

    /**
     * Get insuranceCompany
     *
     * @return string
     */
    public function getInsuranceCompany()
    {
        return $this->insuranceCompany;
    }

    /**
     * Set insuranceNumber
     *
     * @param string $insuranceNumber
     *
     * @return Motorbike
     */
    public function setInsuranceNumber($insuranceNumber)
    {
        $this->insuranceNumber = $insuranceNumber;

        return $this;
    }

    /**
     * Get insuranceNumber
     *
     * @return string
     */
    public function getInsuranceNumber()
    {
        return $this->insuranceNumber;
    }

    /**
     * Set registrationNumber
     *
     * @param string $registrationNumber
     *
     * @return Motorbike
     */
    public function setRegistrationNumber($registrationNumber)
    {
        $this->registrationNumber = $registrationNumber;

        return $this;
    }

    /**
     * Get registrationNumber
     *
     * @return string
     */
    public function getRegistrationNumber()
    {
        return $this->registrationNumber;
    }
}


<?php

namespace MC12\SubscriptionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Insurance
 *
 * @ORM\Table(name="insurance")
 * @ORM\Entity(repositoryClass="MC12\SubscriptionBundle\Repository\InsuranceRepository")
 */
class Insurance
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
     * @ORM\Column(name="insuranceCompanyName", type="string", length=255)
     */
    private $insuranceCompanyName;

    /**
     * @var string
     *
     * @ORM\Column(name="insuranceRegistrationNumber", type="string", length=255)
     */
    private $insuranceRegistrationNumber;


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
     * Set insuranceCompanyName
     *
     * @param string $insuranceCompanyName
     *
     * @return Insurance
     */
    public function setInsuranceCompanyName($insuranceCompanyName)
    {
        $this->insuranceCompanyName = $insuranceCompanyName;

        return $this;
    }

    /**
     * Get insuranceCompanyName
     *
     * @return string
     */
    public function getInsuranceCompanyName()
    {
        return $this->insuranceCompanyName;
    }

    /**
     * Set insuranceRegistrationNumber
     *
     * @param string $insuranceRegistrationNumber
     *
     * @return Insurance
     */
    public function setInsuranceRegistrationNumber($insuranceRegistrationNumber)
    {
        $this->insuranceRegistrationNumber = $insuranceRegistrationNumber;

        return $this;
    }

    /**
     * Get insuranceRegistrationNumber
     *
     * @return string
     */
    public function getInsuranceRegistrationNumber()
    {
        return $this->insuranceRegistrationNumber;
    }
}


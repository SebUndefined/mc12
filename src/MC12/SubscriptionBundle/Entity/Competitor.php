<?php

namespace MC12\SubscriptionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Competitor
 *
 * @ORM\Table(name="competitor")
 * @ORM\Entity(repositoryClass="MC12\SubscriptionBundle\Repository\CompetitorRepository")
 */
class Competitor
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
     * @ORM\Column(name="firstName", type="string", length=255)
     */
    private $firstName;

    /**
     * @var string
     *
     * @ORM\Column(name="lastName", type="string", length=255)
     */
    private $lastName;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="birthDate", type="date")
     */
    private $birthDate;

    /**
     * @var string
     *
     * @ORM\Column(name="adressComp", type="string", length=255, nullable=true)
     */
    private $adressComp;

    /**
     * @var string
     *
     * @ORM\Column(name="address", type="string", length=255)
     */
    private $address;

    /**
     * @var string
     *
     * @ORM\Column(name="postalCode", type="string", length=10)
     */
    private $postalCode;

    /**
     * @var string
     *
     * @ORM\Column(name="city", type="string", length=255)
     */
    private $city;

    /**
     * @var string
     *
     * @ORM\Column(name="country", type="string", length=255)
     */
    private $country;

    /**
     * @var string
     *
     * @ORM\Column(name="nationality", type="string", length=255)
     */
    private $nationality;

    /**
     * @var string
     *
     * @ORM\Column(name="phone", type="string", length=50)
     */
    private $phone;
    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=50, nullable=false)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="group", type="string", length=10, nullable=true)
     */
    private $group;

    /**
     * @ORM\OneToOne(targetEntity="MC12\SubscriptionBundle\Entity\Licence", cascade={"persist"})
     */
    private $licence;

    /**
     * @ORM\OneToOne(targetEntity="MC12\SubscriptionBundle\Entity\Motorbike", cascade={"persist"})
     */
    private $motorbike;
    /**
     * @ORM\OneToOne(targetEntity="MC12\SubscriptionBundle\Entity\Club", cascade={"persist"})
     */
    private $club;
    /**
     * @ORM\OneToOne(targetEntity="MC12\SubscriptionBundle\Entity\DriveLicence", cascade={"persist"})
     */
    private $driveLicence;

    /**
     * @ORM\ManyToOne(targetEntity="MC12\SubscriptionBundle\Entity\Category", inversedBy="competitors")
     */
    private $category;
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
     * Set firstName
     *
     * @param string $firstName
     *
     * @return Competitor
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     *
     * @return Competitor
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set birthDate
     *
     * @param \DateTime $birthDate
     *
     * @return Competitor
     */
    public function setBirthDate($birthDate)
    {
        $this->birthDate = $birthDate;

        return $this;
    }

    /**
     * Get birthDate
     *
     * @return \DateTime
     */
    public function getBirthDate()
    {
        return $this->birthDate;
    }

    /**
     * Set adressComp
     *
     * @param string $adressComp
     *
     * @return Competitor
     */
    public function setAdressComp($adressComp)
    {
        $this->adressComp = $adressComp;

        return $this;
    }

    /**
     * Get adressComp
     *
     * @return string
     */
    public function getAdressComp()
    {
        return $this->adressComp;
    }

    /**
     * Set address
     *
     * @param string $address
     *
     * @return Competitor
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set postalCode
     *
     * @param string $postalCode
     *
     * @return Competitor
     */
    public function setPostalCode($postalCode)
    {
        $this->postalCode = $postalCode;

        return $this;
    }

    /**
     * Get postalCode
     *
     * @return string
     */
    public function getPostalCode()
    {
        return $this->postalCode;
    }

    /**
     * Set city
     *
     * @param string $city
     *
     * @return Competitor
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set country
     *
     * @param string $country
     *
     * @return Competitor
     */
    public function setCountry($country)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country
     *
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Set nationality
     *
     * @param string $nationality
     *
     * @return Competitor
     */
    public function setNationality($nationality)
    {
        $this->nationality = $nationality;

        return $this;
    }

    /**
     * Get nationality
     *
     * @return string
     */
    public function getNationality()
    {
        return $this->nationality;
    }

    /**
     * Set phone
     *
     * @param string $phone
     *
     * @return Competitor
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getGroup()
    {
        return $this->group;
    }

    /**
     * @param string $group
     */
    public function setGroup($group)
    {
        $this->group = $group;
    }


    /**
     * @return mixed
     */
    public function getLicence()
    {
        return $this->licence;
    }/**
     * @param mixed $licence
     */
    public function setLicence($licence)
    {
        $this->licence = $licence;
    }

    /**
     * @return mixed
     */
    public function getMotorbike()
    {
        return $this->motorbike;
    }

    /**
     * @param mixed $motorbike
     */
    public function setMotorbike($motorbike)
    {
        $this->motorbike = $motorbike;
    }

    /**
     * @return mixed
     */
    public function getClub()
    {
        return $this->club;
    }

    /**
     * @param mixed $club
     */
    public function setClub($club)
    {
        $this->club = $club;
    }

    /**
     * @return mixed
     */
    public function getDriveLicence()
    {
        return $this->driveLicence;
    }

    /**
     * @param mixed $driveLicence
     */
    public function setDriveLicence($driveLicence)
    {
        $this->driveLicence = $driveLicence;
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






}


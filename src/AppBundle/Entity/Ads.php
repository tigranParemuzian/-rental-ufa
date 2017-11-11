<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Ads
 *
 * @ORM\Table(name="ads")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\AdsRepository")
 */
class Ads
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
     * @ORM\Column(name="price", type="string", length=255)
     */
    private $price;

    /**
     * @var int
     *
     * @ORM\Column(name="state", type="smallint")
     */
    private $state;

    /**
     * @var string
     *
     * @ORM\Column(name="first_name", type="string", length=255)
     */
    private $firstName;

    /**
     * @var string
     *
     * @ORM\Column(name="last_name", type="string", length=255)
     */
    private $lastName;

    /**
     * @var string
     *
     * @ORM\Column(name="father_name", type="string", length=255)
     */
    private $fatherName;

    /**
     * @var string
     *
     * @ORM\Column(name="phone", type="string", length=255)
     */
    private $phone;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="street", type="string", length=255)
     */
    private $street;

    /**
     * @var string
     *
     * @ORM\Column(name="house", type="string", length=255)
     */
    private $house;

    /**
     * @var string
     *
     * @ORM\Column(name="kb", type="string", length=50)
     */
    private $kb;

    /**
     * @var string
     *
     * @ORM\Column(name="sq_meter", type="string", length=255)
     */
    private $sqMeter;

    /**
     * @var string
     *
     * @ORM\Column(name="renovation", type="string", length=255)
     */
    private $renovation;

    /**
     * @var int
     *
     * @ORM\Column(name="furnisher", type="boolean")
     */
    private $furnisher;

    /**
     * @var
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Regions", inversedBy="ads")
     * @ORM\JoinColumn(name="region_id", referencedColumnName="id")
     */
    private $region;

    /**
     * @var
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Types", inversedBy="ads")
     * @ORM\JoinColumn(name="type_id", referencedColumnName="id")
     */
    private $types;

    public function __toString()
    {
        return $this->id ? $this->price . ' р.'.$this->region : 'New Ads';
        // TODO: Implement __toString() method.
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
     * Set price
     *
     * @param string $price
     *
     * @return Ads
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return string
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set state
     *
     * @param integer $state
     *
     * @return Ads
     */
    public function setState($state)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * Get state
     *
     * @return int
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Set firstName
     *
     * @param string $firstName
     *
     * @return Ads
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
     * @return Ads
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
     * Set fatherName
     *
     * @param string $fatherName
     *
     * @return Ads
     */
    public function setFatherName($fatherName)
    {
        $this->fatherName = $fatherName;

        return $this;
    }

    /**
     * Get fatherName
     *
     * @return string
     */
    public function getFatherName()
    {
        return $this->fatherName;
    }

    /**
     * Set phone
     *
     * @param string $phone
     *
     * @return Ads
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
     * Set description
     *
     * @param string $description
     *
     * @return Ads
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set street
     *
     * @param string $street
     *
     * @return Ads
     */
    public function setStreet($street)
    {
        $this->street = $street;

        return $this;
    }

    /**
     * Get street
     *
     * @return string
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * Set house
     *
     * @param string $house
     *
     * @return Ads
     */
    public function setHouse($house)
    {
        $this->house = $house;

        return $this;
    }

    /**
     * Get house
     *
     * @return string
     */
    public function getHouse()
    {
        return $this->house;
    }

    /**
     * Set kb
     *
     * @param string $kb
     *
     * @return Ads
     */
    public function setKb($kb)
    {
        $this->kb = $kb;

        return $this;
    }

    /**
     * Get kb
     *
     * @return string
     */
    public function getKb()
    {
        return $this->kb;
    }

    /**
     * Set sqMeter
     *
     * @param string $sqMeter
     *
     * @return Ads
     */
    public function setSqMeter($sqMeter)
    {
        $this->sqMeter = $sqMeter;

        return $this;
    }

    /**
     * Get sqMeter
     *
     * @return string
     */
    public function getSqMeter()
    {
        return $this->sqMeter;
    }

    /**
     * Set renovation
     *
     * @param string $renovation
     *
     * @return Ads
     */
    public function setRenovation($renovation)
    {
        $this->renovation = $renovation;

        return $this;
    }

    /**
     * Get renovation
     *
     * @return string
     */
    public function getRenovation()
    {
        return $this->renovation;
    }

    /**
     * Set furnisher
     *
     * @param integer $furnisher
     *
     * @return Ads
     */
    public function setFurnisher($furnisher)
    {
        $this->furnisher = $furnisher;

        return $this;
    }

    /**
     * Get furnisher
     *
     * @return int
     */
    public function getFurnisher()
    {
        return $this->furnisher;
    }

    /**
     * Set region
     *
     * @param \AppBundle\Entity\Regions $region
     *
     * @return Ads
     */
    public function setRegion(\AppBundle\Entity\Regions $region = null)
    {
        $this->region = $region;

        return $this;
    }

    /**
     * Get region
     *
     * @return \AppBundle\Entity\Regions
     */
    public function getRegion()
    {
        return $this->region;
    }

    /**
     * Set types
     *
     * @param \AppBundle\Entity\Types $types
     *
     * @return Ads
     */
    public function setTypes(\AppBundle\Entity\Types $types = null)
    {
        $this->types = $types;

        return $this;
    }

    /**
     * Get types
     *
     * @return \AppBundle\Entity\Types
     */
    public function getTypes()
    {
        return $this->types;
    }
}

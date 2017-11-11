<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Types
 *
 * @ORM\Table(name="types")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TypesRepository")
 */
class Types
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
     * @var bool
     *
     * @ORM\Column(name="is_enabled", type="boolean")
     */
    private $isEnabled;


    /**
     * @var
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Ads", mappedBy="types")
     */
    private $ads;



    public function __toString()
    {
        return $this->id ? $this->name : 'New Type';
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
     * Set name
     *
     * @param string $name
     *
     * @return Types
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
     * Set isEnabled
     *
     * @param boolean $isEnabled
     *
     * @return Types
     */
    public function setIsEnabled($isEnabled)
    {
        $this->isEnabled = $isEnabled;

        return $this;
    }

    /**
     * Get isEnabled
     *
     * @return bool
     */
    public function getIsEnabled()
    {
        return $this->isEnabled;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->ads = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add ad
     *
     * @param \AppBundle\Entity\Ads $ad
     *
     * @return Types
     */
    public function addAd(\AppBundle\Entity\Ads $ad)
    {
        $this->ads[] = $ad;

        return $this;
    }

    /**
     * Remove ad
     *
     * @param \AppBundle\Entity\Ads $ad
     */
    public function removeAd(\AppBundle\Entity\Ads $ad)
    {
        $this->ads->removeElement($ad);
    }

    /**
     * Get ads
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAds()
    {
        return $this->ads;
    }
}

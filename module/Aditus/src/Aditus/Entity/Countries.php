<?php

namespace Aditus\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Countries
 *
 * @ORM\Table(name="countries")
 * @ORM\Entity
 */
class Countries
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="string", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @var integer
     *
     * @ORM\Column(name="region_id", type="string", nullable=true)
     */
    private $regionId;

    /**
     * @var boolean
     *
     * @ORM\Column(name="active", type="boolean", nullable=true)
     */
    private $active;

    /**
     * @ORM\ManyToOne(targetEntity="Regions", inversedBy="countries", cascade={"persist"})
     * @ORM\JoinColumn(referencedColumnName="id")
     **/
    public $region;

    /**
     * @ORM\OneToMany(targetEntity="Companies", mappedBy="country")
     **/
    public $companies; 


    /**
     * Get id
     *
     * @return string 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Countries
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
     * Set regionId
     *
     * @param string $regionId
     * @return Countries
     */
    public function setRegionId($regionId)
    {
        $this->regionId = $regionId;

        return $this;
    }

    /**
     * Get regionId
     *
     * @return string 
     */
    public function getRegionId()
    {
        return $this->regionId;
    }

    /**
     * Set active
     *
     * @param boolean $active
     * @return Accounts
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active
     *
     * @return boolean 
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Allow null to remove association
     */
    public function setRegion(Regions $region = null)
    {
        $this->region = $region;
    }

    public function getRegion()
    {
        return $this->region;
    }

    /**
     * Get companies
     *
     * @return array
     */
    public function getCompanies()
    {
        return $this->companies;
    }
    
}

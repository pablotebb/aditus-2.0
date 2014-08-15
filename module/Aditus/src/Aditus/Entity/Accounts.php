<?php

namespace Aditus\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * Accounts
 *
 * @ORM\Table(name="accounts")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 *
 * @ORM\Entity(repositoryClass="Aditus\Model\AccountsRepository")
 */
class Accounts
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
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
     * @var string
     *
     * @ORM\Column(name="license_type", type="string", length=45, nullable=true)
     */
    private $licenseType;

    /**
     * @var string
     *
     * @ORM\Column(name="license_key", type="string", length=45, nullable=true)
     */
    private $licenseKey;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="license_expires", type="datetime", nullable=true)
     */
    private $licenseExpires;

    /**
     * @var string
     *
     * @ORM\Column(name="registration_code", type="string", length=45, nullable=true)
     */
    private $registrationCode;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=45, nullable=true)
     */
    private $type;

    /**
     * @var integer
     *
     * @ORM\Column(name="custom_kpi_limit", type="integer", nullable=true)
     */
    private $customKpiLimit;

    /**
     * @var boolean
     *
     * @ORM\Column(name="active", type="boolean", nullable=true)
     */
    private $active;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="datetime", nullable=true)
     */
    private $created;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated", type="datetime", nullable=true)
     */
    private $updated;

    /**
     * @ORM\OneToMany(targetEntity="Users", mappedBy="account")
     **/
    public $users;

    /**
     * @ORM\OneToMany(targetEntity="Funds", mappedBy="account")
     **/
    public $funds; 
    
    /**
     * @ORM\OneToMany(targetEntity="Indicators", mappedBy="account")
     **/
    public $indicators; 

    
    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->funds = new ArrayCollection();
        $this->indicators = new ArrayCollection();
    }


    /** @ORM\PrePersist */
    public function onPrePersist()
    {
        // set the created time
        $this->created = new \DateTime('now');
        $this->active = 1;
        $this->type = 'user';
        $this->customKpiLimit = 3;
    }


    /** @ORM\PreUpdate */
    public function onPreUpdate()
    {
        $this->updated = new \DateTime('now');
    }


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Accounts
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
     * Set licenseType
     *
     * @param string $licenseType
     * @return Accounts
     */
    public function setLicenseType($licenseType)
    {
        $this->licenseType = $licenseType;

        return $this;
    }

    /**
     * Get licenseType
     *
     * @return string 
     */
    public function getLicenseType()
    {
        return $this->licenseType;
    }

    /**
     * Set licenseKey
     *
     * @param string $licenseKey
     * @return Accounts
     */
    public function setLicenseKey($licenseKey)
    {
        $this->licenseKey = $licenseKey;

        return $this;
    }

    /**
     * Get licenseKey
     *
     * @return string 
     */
    public function getLicenseKey()
    {
        return $this->licenseKey;
    }

    /**
     * Set licenseExpires
     *
     * @param \DateTime $licenseExpires
     * @return Accounts
     */
    public function setLicenseExpires($licenseExpires)
    {
        $this->licenseExpires = $licenseExpires;

        return $this;
    }

    /**
     * Get licenseExpires
     *
     * @return \DateTime 
     */
    public function getLicenseExpires()
    {
        return $this->licenseExpires;
    }


    /**
     * Set registrationCode
     *
     * @param string $registrationCode
     * @return Accounts
     */
    public function setRegistrationCode($registrationCode)
    {
        $this->registrationCode = $registrationCode;

        return $this;
    }

    /**
     * Get registrationCode
     *
     * @return string 
     */
    public function getRegistrationCode()
    {
        return $this->registrationCode;
    }

    /**
     * Get type
     *
     * @return string 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set customKpiLimit
     *
     * @param integer $customKpiLimit
     * @return Accounts
     */
    public function setCustomKpiLimit($customKpiLimit)
    {
        $this->customKpiLimit = $customKpiLimit;

        return $this;
    }

    /**
     * Get customKpiLimit
     *
     * @return integer 
     */
    public function getCustomKpiLimit()
    {
        return $this->customKpiLimit;
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
     * Set created
     *
     * @param \DateTime $created
     * @return Accounts
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime 
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set updated
     *
     * @param \DateTime $updated
     * @return Accounts
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;

        return $this;
    }

    /**
     * Get updated
     *
     * @return \DateTime 
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /*
    public function addFunds(Collection $funds)
    {
        foreach ($funds as $fund) {
            $fund->setBlogPost($this);
            $this->tags->add($fund);
        }
    }

    public function removeFunds(Collection $funds)
    {
        foreach ($funds as $fund) {
            $fund->setBlogPost(null);
            $this->tags->removeElement($fund);
        }
    }

    public function getFunds()
    {
        return $this->tags;
    }
    */   

    public function isAdmin()
    {
        return (bool) ($this->getType() === 'admin' ? true : false);
    }

    public function allowCustomKpi()
    {
        return (bool) (count($this->indicators) < $this->customKpiLimit ? true : false);
    }

    public function getCompanyCount()
    {
        $count = 0;
        foreach( $this->funds as $fund ){
            $count += count($fund->companies);
        }
        return $count;
    }

    public function getFeedbackCount()
    {
        $count = 0;
        foreach( $this->users as $user ){
            $count += count($user->feedback);
        }
        return $count;
    }
}

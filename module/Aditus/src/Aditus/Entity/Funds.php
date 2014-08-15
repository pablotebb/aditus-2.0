<?php

namespace Aditus\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\Form\Annotation as Form;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * Funds
 *
 * @ORM\Table(name="funds")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 *
 * @Form\Name("Funds")
 */
class Funds
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
     * @var integer
     *
     * @ORM\Column(name="account_id", type="integer", nullable=true)
     */
    private $accountId;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=true)
     *
     * @Form\Filter({"name":"StringTrim"})
     * @Form\Required({ "required" : "true" })               
     * @Form\Validator({"name":"StringLength", "options":{"min":1, "max":75}})
     * @Form\Attributes({"type":"text", "required":"required"})
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="inception", type="string", length=4, nullable=true)
     */
    private $inception;

    /**
     * @var string
     *
     * @ORM\Column(name="vintage", type="string", length=4, nullable=true)
     */
    private $vintage;

    /**
     * @var string
     *
     * @ORM\Column(name="stage", type="string", length=45, nullable=true)
     */
    private $stage;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=45, nullable=true)
     */
    private $status;

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
     * @ORM\ManyToOne(targetEntity="Accounts")
     * @ORM\JoinColumn(referencedColumnName="id")
     **/
    public $account;    

    /**
     * @ORM\OneToMany(targetEntity="Companies", mappedBy="fund")
     **/
    public $companies;

    /**
     * @ORM\OneToMany(targetEntity="FundReports", mappedBy="fund")
     **/
    public $fundReports;

    
    public function __construct()
    {
        $this->companies = new ArrayCollection();
        $this->fundReports = new ArrayCollection();
    }


    /** @ORM\PrePersist */
    public function onPrePersist()
    {
        // set the created time
        $this->created = new \DateTime('now');
        $this->status = 'active';
        $this->active = 1;
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
     * Set accountId
     *
     * @param integer $accountId
     * @return Funds
     */
    public function setAccountId($accountId)
    {
        $this->accountId = $accountId;

        return $this;
    }

    /**
     * Get accountId
     *
     * @return integer 
     */
    public function getAccountId()
    {
        return $this->accountId;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Funds
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
     * Set description
     *
     * @param string $description
     * @return Funds
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
     * Set inception
     *
     * @param string $inception
     * @return Funds
     */
    public function setInception($inception)
    {
        $this->inception = $inception;

        return $this;
    }

    /**
     * Get inception
     *
     * @return string 
     */
    public function getInception()
    {
        return $this->inception;
    }

    /**
     * Set vintage
     *
     * @param string $vintage
     * @return Funds
     */
    public function setVintage($vintage)
    {
        $this->vintage = $vintage;

        return $this;
    }

    /**
     * Get vintage
     *
     * @return string 
     */
    public function getVintage()
    {
        return $this->vintage;
    }

    /**
     * Set stage
     *
     * @param string $stage
     * @return Funds
     */
    public function setStage($stage)
    {
        $this->stage = $stage;

        return $this;
    }

    /**
     * Get stage
     *
     * @return string 
     */
    public function getStage()
    {
        return $this->stage;
    }

    /**
     * Set status
     *
     * @param string $status
     * @return Funds
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string 
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set active
     *
     * @param boolean $active
     * @return Indicators
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
     * @return Funds
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
     * @return Funds
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

    /**
     * Get companies
     *
     * @return array
     */
    public function getCompanies()
    {
        return $this->companies;
    }

    /**
     * Allow null to remove association
     */
    public function setAccount(Accounts $account = null)
    {
        $this->account = $account;
    }

    public function getAccount()
    {
        return $this->account;
    }

    /**
     * Get fundReports
     *
     * @return array
     */
    public function getFundReports()
    {
        return $this->fundReports;
    }


}

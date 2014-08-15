<?php

namespace Aditus\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Companies
 *
 * @ORM\Table(name="companies", indexes={@ORM\Index(name="fk_companies_funds1_idx", columns={"fund_id"}), @ORM\Index(name="fk_companies_industries1_idx", columns={"industry_id"})})
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 *
 */
class Companies
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
     * @var integer
     *
     * @ORM\Column(name="fund_id", type="integer", nullable=true)
     */
    private $fundId;

    /**
     * @var string
     *
     * @ORM\Column(name="industry_id", type="string", length=4, nullable=true)
     */
    private $industryId;

    /**
     * @var string
     *
     * @ORM\Column(name="country_id", type="string", length=4, nullable=true)
     */
    private $countryId;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=true)
     */
    private $name;

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
     * @ORM\ManyToOne(targetEntity="Funds", inversedBy="companies", cascade={"persist"})
     * @ORM\JoinColumn(referencedColumnName="id")
     **/
    public $fund;

    /**
     * @ORM\ManyToOne(targetEntity="Industries")
     * @ORM\JoinColumn(referencedColumnName="id")
     **/
    public $industry;

    /**
     * @ORM\ManyToOne(targetEntity="Countries")
     * @ORM\JoinColumn(referencedColumnName="id")
     **/
    public $country;

    /**
     * @ORM\OneToMany(targetEntity="Assessments", mappedBy="company")
     **/
    protected $assessments;


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
     * @return Companies
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
     * Set fundId
     *
     * @param integer $fundId
     * @return Companies
     */
    public function setFundId($fundId)
    {
        $this->fundId = $fundId;

        return $this;
    }

    /**
     * Get fundId
     *
     * @return integer 
     */
    public function getFundId()
    {
        return $this->fundId;
    }

    /**
     * Set industryId
     *
     * @param string $industryId
     * @return Companies
     */
    public function setIndustryId($industryId)
    {
        $this->industryId = $industryId;

        return $this;
    }

    /**
     * Get industryId
     *
     * @return string 
     */
    public function getIndustryId()
    {
        return $this->industryId;
    }

    /**
     * Set countryId
     *
     * @param integer $countryId
     * @return Companies
     */
    public function setCountryId($countryId)
    {
        $this->countryId = $countryId;

        return $this;
    }

    /**
     * Get countryId
     *
     * @return integer 
     */
    public function getCountryId()
    {
        return $this->countryId;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Companies
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
     * Set status
     *
     * @param string $status
     * @return Companies
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
     * @return Companies
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
     * @return Companies
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
     * Get assessments
     *
     * @return array
     */
    public function getAssessments()
    {
        return $this->assessments;
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
     * Allow null to remove association
     */
    public function setFund(Funds $fund = null)
    {
        $this->fund = $fund;
    }

    public function getFund()
    {
        return $this->fund;
    }

    /**
     * Allow null to remove association
     */
    public function setIndustry(Industries $industry = null)
    {
        $this->industry = $industry;
    }

    public function getIndustry()
    {
        return $this->industry;
    }

    /**
     * Allow null to remove association
     */
    public function setCountry(Countries $country = null)
    {
        $this->country = $country;
    }

    public function getCountry()
    {
        return $this->country;
    }

}

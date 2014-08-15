<?php

namespace Aditus\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * FundReports
 *
 * @ORM\Table(name="fund_reports")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 *
 */
class FundReports
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
     * @ORM\Column(name="type", type="string", nullable=true)
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="reporting_year", type="string", length=4, nullable=true)
     */
    private $reportingYear;

    /**
     * @var string
     *
     * @ORM\Column(name="reporting_period", type="string", length=4, nullable=true)
     */
    private $reportingPeriod;

    /**
     * @var string
     *
     * @ORM\Column(name="e_overview", type="text", nullable=true)
     */
    private $eOverview;

    /**
     * @var string
     *
     * @ORM\Column(name="s_overview", type="text", nullable=true)
     */
    private $sOverview;

    /**
     * @var string
     *
     * @ORM\Column(name="g_overview", type="text", nullable=true)
     */
    private $gOverview;

    /**
     * @var string
     *
     * @ORM\Column(name="c_overview", type="text", nullable=true)
     */
    private $cOverview;

    /**
     * @var string
     *
     * @ORM\Column(name="display_disclosure", type="string", nullable=true)
     */
    private $displayDisclosure = 'display';

    /**
     * @var string
     *
     * @ORM\Column(name="result_display", type="string", nullable=true)
     */
    private $resultDisplay = 'average';

    /**
     * @var string
     *
     * @ORM\Column(name="change_display", type="string", nullable=true)
     */
    private $changeDisplay = 'both';

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
     * @var \Accounts
     *
     * @ORM\ManyToOne(targetEntity="Accounts")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="account_id", referencedColumnName="id")
     * })
     */
    public $account;

    /**
     * @var \Funds
     *
     * @ORM\ManyToOne(targetEntity="Funds")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="fund_id", referencedColumnName="id")
     * })
     */
    public $fund;

    /**
     * @ORM\OneToMany(targetEntity="FundReportSettings", mappedBy="fundReport", indexBy="indicatorId")
     **/
    public $settings;


    public function __construct()
    {
        $this->settings = new ArrayCollection();
    }


    /** @ORM\PrePersist */
    public function onPrePersist()
    {
        // set the created time
        $this->created = new \DateTime('now');
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
     * Set type
     *
     * @param string $type
     * @return FundReports
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
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
     * Set reportingYear
     *
     * @param string $reportingYear
     * @return FundReports
     */
    public function setReportingYear($reportingYear)
    {
        $this->reportingYear = $reportingYear;

        return $this;
    }

    /**
     * Get reportingYear
     *
     * @return string 
     */
    public function getReportingYear()
    {
        return $this->reportingYear;
    }

    /**
     * Set reportingPeriod
     *
     * @param string $reportingPeriod
     * @return FundReports
     */
    public function setReportingPeriod($reportingPeriod)
    {
        $this->reportingPeriod = $reportingPeriod;

        return $this;
    }

    /**
     * Get reportingPeriod
     *
     * @return string 
     */
    public function getReportingPeriod()
    {
        return $this->reportingPeriod;
    }

    /**
     * Set eOverview
     *
     * @param string $eOverview
     * @return FundReports
     */
    public function setEOverview($eOverview)
    {
        $this->eOverview = $eOverview;

        return $this;
    }

    /**
     * Get eOverview
     *
     * @return string 
     */
    public function getEOverview()
    {
        return $this->eOverview;
    }

    /**
     * Set sOverview
     *
     * @param string $sOverview
     * @return FundReports
     */
    public function setSOverview($sOverview)
    {
        $this->sOverview = $sOverview;

        return $this;
    }

    /**
     * Get sOverview
     *
     * @return string 
     */
    public function getSOverview()
    {
        return $this->sOverview;
    }

    /**
     * Set gOverview
     *
     * @param string $gOverview
     * @return FundReports
     */
    public function setGOverview($gOverview)
    {
        $this->gOverview = $gOverview;

        return $this;
    }

    /**
     * Get gOverview
     *
     * @return string 
     */
    public function getGOverview()
    {
        return $this->gOverview;
    }

    /**
     * Set cOverview
     *
     * @param string $cOverview
     * @return FundReports
     */
    public function setCOverview($cOverview)
    {
        $this->cOverview = $cOverview;

        return $this;
    }

    /**
     * Get cOverview
     *
     * @return string 
     */
    public function getCOverview()
    {
        return $this->cOverview;
    }

    /**
     * Set displayDisclosure
     *
     * @param string $displayDisclosure
     * @return FundReports
     */
    public function setDisplayDisclosure($displayDisclosure)
    {
        $this->displayDisclosure = $displayDisclosure;

        return $this;
    }

    /**
     * Get displayDisclosure
     *
     * @return string 
     */
    public function getDisplayDisclosure()
    {
        return $this->displayDisclosure;
    }

    /**
     * Set resultDisplay
     *
     * @param string $resultDisplay
     * @return Indicators
     */
    public function setResultDisplay($resultDisplay)
    {
        $this->resultDisplay = $resultDisplay;

        return $this;
    }

    /**
     * Get resultDisplay
     *
     * @return string 
     */
    public function getResultDisplay()
    {
        return $this->resultDisplay;
    }

    /**
     * Set changeDisplay
     *
     * @param string $changeDisplay
     * @return FundReports
     */
    public function setChangeDisplay($changeDisplay)
    {
        $this->changeDisplay = $changeDisplay;

        return $this;
    }

    /**
     * Get changeDisplay
     *
     * @return string 
     */
    public function getChangeDisplay()
    {
        return $this->changeDisplay;
    }

    /**
     * Set active
     *
     * @param boolean $active
     * @return FundReports
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
     * @return FundReports
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
     * @return FundReports
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
     * Set account
     *
     * @param \Aditus\Entity\Accounts $account
     * @return FundReports
     */
    public function setAccount(\Aditus\Entity\Accounts $account = null)
    {
        $this->account = $account;

        return $this;
    }

    /**
     * Get account
     *
     * @return \Aditus\Entity\Accounts 
     */
    public function getAccount()
    {
        return $this->account;
    }

    /**
     * Set fund
     *
     * @param \Aditus\Entity\Funds $fund
     * @return FundReports
     */
    public function setFund(\Aditus\Entity\Funds $fund = null)
    {
        $this->fund = $fund;

        return $this;
    }

    /**
     * Get fund
     *
     * @return \Aditus\Entity\Funds 
     */
    public function getFund()
    {
        return $this->fund;
    }

    /**
     * Set settings
     *
     * @param \Aditus\Entity\Funds $settings
     * @return FundReports
     */
    public function setSettings(\Aditus\Entity\FundReportSettings $settings = null)
    {
        $this->settings = $settings;

        return $this;
    }

    /**
     * Get settings
     *
     * @return \Aditus\Entity\Funds 
     */
    public function getSettings()
    {
        return $this->settings;
    }

    public function getOverview( $category )
    {
        $method = sprintf('get%sOverview', strtoupper($category));
        if( method_exists($this, $method) ){
            return $this->$method();
        }
        
        return;
    }

    public function setOverview( $category, $overview )
    {
        $method = sprintf('set%sOverview', strtoupper($category));
        if( method_exists($this, $method) ){
            return $this->$method( $overview );
        }
        
        return;
    }
}

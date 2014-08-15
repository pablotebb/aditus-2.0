<?php

namespace Aditus\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * Assessments
 *
 * @ORM\Table(name="assessments")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 *
 *
 * @ORM\Entity(repositoryClass="Aditus\Model\AssessmentsRepository")
 */
class Assessments
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
     * @ORM\Column(name="company_id", type="integer", nullable=true)
     */
    private $companyId;

    /**
     * @var integer
     *
     * @ORM\Column(name="previous_id", type="integer", nullable=true)
     */
    private $previousId;


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
     * @var \DateTime
     *
     * @ORM\Column(name="reporting_start", type="date", nullable=true)
     */
    private $reportingStart;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="reporting_end", type="date", nullable=true)
     */
    private $reportingEnd;

    /**
     * @var float
     *
     * @ORM\Column(name="percentage_completed", type="float", nullable=true)
     */
    private $percentageCompleted;

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
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=45, nullable=true)
     */
    private $type;

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
     * @ORM\ManyToOne(targetEntity="Companies", inversedBy="assessments", cascade={"persist"})
     * @ORM\JoinColumn(referencedColumnName="id")
     **/
    public $company;

    /**
     * @ORM\ManyToOne(targetEntity="Assessments", cascade={"persist"})
     * @ORM\JoinColumn(name="previous_id", referencedColumnName="id")
     */
    protected $previous;

    /**
     * @ORM\OneToMany(targetEntity="AssessmentDetails", mappedBy="assessment", indexBy="indicatorId", cascade={"persist"})
     **/
    public $details; 


    public function __construct()
    {
        $this->details = new ArrayCollection();
    }


    /** @ORM\PrePersist */
    public function onPrePersist()
    {
        // set the dates
        // $this->reportingStart = new \DateTime($this->reportingStart);
        // $this->reportingEnd = new \DateTime($this->reportingEnd);
        
        $this->percentageCompleted = 0;

        // set the created time
        $this->created = new \DateTime('now');
        $this->status = 'active';
        $this->active = 1;
    }

    /** @ORM\PreUpdate */
    public function onPreUpdate()
    {
        // set the updated time
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
     * Set companyId
     *
     * @param integer $companyId
     * @return Assessments
     */
    public function setCompanyId($companyId)
    {
        $this->companyId = $companyId;

        return $this;
    }

    /**
     * Get companyId
     *
     * @return integer 
     */
    public function getCompanyId()
    {
        return $this->companyId;
    }

    /**
     * Set previousId
     *
     * @param integer $previousId
     * @return AssessmentDetails
     */
    public function setPreviousId($previousId)
    {
        $this->previousId = $previousId;

        return $this;
    }

    /**
     * Get previousId
     *
     * @return integer 
     */
    public function getPreviousId()
    {
        return $this->previousId;
    }

    /**
     * Set reportingYear
     *
     * @param string $reportingYear
     * @return Assessments
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
     * @return Assessments
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
     * Set reportingStart
     *
     * @param \DateTime $reportingStart
     * @return Assessments
     */
    public function setReportingStart($reportingStart)
    {
        $this->reportingStart = $reportingStart;

        return $this;
    }

    /**
     * Get reportingStart
     *
     * @return \DateTime 
     */
    public function getReportingStart()
    {
        return $this->reportingStart;
    }

    /**
     * Set reportingEnd
     *
     * @param \DateTime $reportingEnd
     * @return Assessments
     */
    public function setReportingEnd($reportingEnd)
    {
        $this->reportingEnd = $reportingEnd;

        return $this;
    }

    /**
     * Get reportingEnd
     *
     * @return \DateTime 
     */
    public function getReportingEnd()
    {
        return $this->reportingEnd;
    }

    /**
     * Set percentageCompleted
     *
     * @param float $percentageCompleted
     * @return AssessmentDetails
     */
    public function setPercentageCompleted($percentageCompleted)
    {
        $this->percentageCompleted = $percentageCompleted;

        return $this;
    }

    /**
     * Get percentageCompleted
     *
     * @return float 
     */
    public function getPercentageCompleted()
    {
        return $this->percentageCompleted;
    }

    /**
     * Set status
     *
     * @param string $status
     * @return Assessments
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
     * Set type
     *
     * @param string $type
     * @return Assessments
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
     * Set created
     *
     * @param \DateTime $created
     * @return Assessments
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
     * @return Assessments
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

    public function setCompany(Companies $company = null)
    {
        $this->company = $company;
    }

    public function getCompany()
    {
        return $this->company;
    }

    /**
     * Allow null to remove association
     */
    public function setPrevious(Assessments $previous = null)
    {
        $this->previous = $previous;
    }

    public function getPrevious()
    {
        return $this->previous;
    }


    public function setDetails(Collection $details)
    {
        $this->details = $details;
    }    

    public function updateAssessment()
    {
        // update completion percentage
        $this->updatePercentage();
    }

    protected function updatePercentage()
    {
        $inputCount = 0; 
        $answeredCount = 0;

        foreach( $this->details as $detail ){
            $inputCount += (int) $detail->getIndicator()->getInput();
            $answeredCount += ($detail->getIndicator()->getInput() && strlen(trim($detail->getCapturedValue())) > 0) ? 1 : 0;
        }

        $this->setPercentageCompleted($answeredCount / max($inputCount,1) * 100);
    }

    public function displayReportingPeriod()
    {
        return $this->getReportingYear()
            .($this->getReportingPeriod() != 'YEAR' ? ' '.$this->getReportingPeriod() : '');
    }
}

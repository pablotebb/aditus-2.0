<?php

namespace Aditus\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * FundReports
 *
 * @ORM\Table(name="fund_report_settings")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 *
 */
class FundReportSettings
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
     * @ORM\Column(name="fund_report_id", type="integer", nullable=true)
     */
    private $fundReportId;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", nullable=true)
     */
    private $type;

    /**
     * @var integer
     *
     * @ORM\Column(name="indicator_id", type="integer", nullable=true)
     */
    private $indicatorId;

    /**
     * @var integer
     *
     * @ORM\Column(name="assessment_details_id", type="integer", nullable=true)
     */
    private $assessmentDetailsId;

    /**
     * @var integer
     *
     * @ORM\Column(name="position", type="integer", nullable=true)
     */
    private $position;

    /**
     * @var string
     *
     * @ORM\Column(name="display_disclosure", type="string", nullable=true)
     */
    private $displayDisclosure = 'global';

    /**
     * @var string
     *
     * @ORM\Column(name="result_display", type="string", nullable=true)
     */
    private $resultDisplay = 'global';

    /**
     * @var string
     *
     * @ORM\Column(name="change_display", type="string", nullable=true)
     */
    private $changeDisplay = 'global';

    /**
     * @var string
     *
     * @ORM\Column(name="story", type="text", nullable=true)
     */
    private $story;

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
     * @var \FundReports
     *
     * @ORM\ManyToOne(targetEntity="FundReports")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="fund_report_id", referencedColumnName="id")
     * })
     */
    public $fundReport;

    /**
     * @var \Indicators
     *
     * @ORM\ManyToOne(targetEntity="Indicators")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="indicator_id", referencedColumnName="id")
     * })
     */
    public $indicator;

    /**
     * @var \AssessmentDetails
     *
     * @ORM\ManyToOne(targetEntity="AssessmentDetails")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="assessment_details_id", referencedColumnName="id")
     * })
     */
    public $assessmentDetails;


    /** @ORM\PrePersist */
    public function onPrePersist()
    {
        // set the created time
        $this->created = new \DateTime('now');
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
     * Set indicatorId
     *
     * @param integer $indicatorId
     * @return AssessmentDetails
     */
    public function setIndicatorId($indicatorId)
    {
        $this->indicatorId = $indicatorId;

        return $this;
    }

    /**
     * Get indicatorId
     *
     * @return integer 
     */
    public function getIndicatorId()
    {
        return $this->indicatorId;
    }

    /**
     * Set position
     *
     * @param integer $position
     * @return Indicators
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * Get position
     *
     * @return integer 
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Set displayDisclosure
     *
     * @param string $displayDisclosure
     * @return Indicators
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
     * @return Indicators
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
     * Set story
     *
     * @param string $story
     * @return Indicators
     */
    public function setStory($story)
    {
        $this->story = $story;

        return $this;
    }

    /**
     * Get story
     *
     * @return string 
     */
    public function getStory()
    {
        return $this->story;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return Indicators
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
     * @return Indicators
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
     * Allow null to remove association
     */
    public function setFundReport(FundReports $fundReport = null)
    {
        $this->fundReport = $fundReport;
    }

    public function getFundReport()
    {
        return $this->fundReport;
    }

    /**
     * Allow null to remove association
     */
    public function setIndicator(Indicators $indicator = null)
    {
        $this->indicator = $indicator;
    }

    public function getIndicator()
    {
        return $this->indicator;
    }

    /**
     * Allow null to remove association
     */
    public function setAssessmentDetail(AssessmentDetails $assessmentDetails = null)
    {
        $this->assessmentDetails = $assessmentDetails;
    }

    public function getAssessmentDetail()
    {
        return $this->assessmentDetails;
    }

    public function hasStory()
    {
        return (bool) !(is_null($this->story) || strlen(trim($this->story)) == 0);
    }

    public function getCurrentResultDisplay()
    {
        if( $this->resultDisplay == 'global' ){
            return $this->fundReport->getResultDisplay();
        }

        return $this->resultDisplay;
    }

    public function getCurrentDisplayDisclosure()
    {
        if( $this->displayDisclosure == 'global' ){
            return $this->fundReport->getDisplayDisclosure();
        }

        return $this->displayDisclosure;
    }
}

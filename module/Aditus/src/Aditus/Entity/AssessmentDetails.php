<?php

namespace Aditus\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AssessmentDetails
 *
 * @ORM\Table(name="assessment_details", indexes={@ORM\Index(name="fk_assessment_details_indicators1_idx", columns={"indicator_id"})})
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 *
 */
class AssessmentDetails
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
     * @ORM\Column(name="assessment_id", type="integer", nullable=true)
     */
    private $assessmentId;

    /**
     * @var integer
     *
     * @ORM\Column(name="indicator_id", type="integer", nullable=true)
     */
    private $indicatorId;

    /**
     * @var integer
     *
     * @ORM\Column(name="previous_id", type="integer", nullable=true)
     */
    private $previousId;

    /**
     * @var string
     *
     * @ORM\Column(name="captured_value", type="string", length=255, nullable=true)
     */
    private $capturedValue;

    /**
     * @var string
     *
     * @ORM\Column(name="formatted_value", type="string", length=255, nullable=true)
     */
    private $formattedValue;

    /**
     * @var float
     *
     * @ORM\Column(name="trend_percentage", type="float", precision=10, scale=0, nullable=true)
     */
    private $trendPercentage;

    /**
     * @var string
     *
     * @ORM\Column(name="comments", type="text", nullable=true)
     */
    private $comments;

    /**
     * @var string
     *
     * @ORM\Column(name="target_value", type="string", length=255, nullable=true)
     */
    private $targetValue;

    /**
     * @var string
     *
     * @ORM\Column(name="target_formatted_value", type="string", length=255, nullable=true)
     */
    private $targetFormattedValue;

    /**
     * @var float
     *
     * @ORM\Column(name="target_percentage", type="float", precision=10, scale=0, nullable=true)
     */
    private $targetPercentage;

    /**
     * @var string
     *
     * @ORM\Column(name="target_comments", type="text", nullable=true)
     */
    private $targetComments;

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
     * @ORM\ManyToOne(targetEntity="Assessments", inversedBy="details", cascade={"persist"})
     * @ORM\JoinColumn(referencedColumnName="id")
     **/
    public $assessment;

    /**
     * @ORM\ManyToOne(targetEntity="Indicators")
     * @ORM\JoinColumn(referencedColumnName="id")
     **/
    public $indicator;

    /**
     * @ORM\ManyToOne(targetEntity="AssessmentDetails")
     * @ORM\JoinColumn(name="previous_id", referencedColumnName="id")
     */
    protected $previous;


    /** @ORM\PrePersist */
    public function onPrePersist()
    {
        // update values
        $this->updateValues();

        // set the created time
        $this->created = new \DateTime('now');
    }

    /** @ORM\PreUpdate */
    public function onPreUpdate()
    {
        // update values
        $this->updateValues();

        // set the updated time
        $this->updated = new \DateTime('now');
    }

    protected function updateValues()
    {
        // update trend percentage
        if( !is_null($this->previous) ){            
            switch( $this->indicator->getAnswerType() ){
                case 'integer':
                case 'float':
                    if( is_null($this->previous->getCapturedValue()) || $this->previous->getCapturedValue() == 0 ){
                        $this->setTrendPercentage(null);
                    } else {
                        $this->setTrendPercentage((floatval($this->capturedValue)/floatval($this->previous->getCapturedValue())-1)*100);
                    }
                    break;
            }
        } else {
            $this->setTrendPercentage(null);
        }

        // update target percentage
        switch( $this->indicator->getAnswerType() ){
            case 'integer':
            case 'float':
                if( !is_null($this->targetValue) && !is_null($this->capturedValue) ){
                    if( is_null($this->capturedValue) || $this->capturedValue == 0 ){
                        $this->setTargetPercentage(null);
                    } else {
                        $this->setTargetPercentage((floatval($this->targetValue)/floatval($this->capturedValue)-1)*100);
                    }
                } else {
                    $this->setTargetPercentage(null);
                }
                break;
        }

        // update display values
        $this->setFormattedValue();
        $this->setTargetFormattedValue();        
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
     * Set assessmentId
     *
     * @param integer $assessmentId
     * @return AssessmentDetails
     */
    public function setAssessmentId($assessmentId)
    {
        $this->assessmentId = $assessmentId;

        return $this;
    }

    /**
     * Get assessmentId
     *
     * @return integer 
     */
    public function getAssessmentId()
    {
        return $this->assessmentId;
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
     * Set capturedValue
     *
     * @param string $capturedValue
     * @return AssessmentDetails
     */
    public function setCapturedValue($capturedValue)
    {
        if( strlen(trim($capturedValue)) > 0 ){
            switch( $this->indicator->getAnswerType() ){
                case 'integer':
                case 'float':
                    $value = floatval(str_replace(',', '', $capturedValue));
                    $this->capturedValue = max(0, $value);
                    break;
                default:         
                    $this->capturedValue = $capturedValue;
                    break;
            }
        } else {
            $this->capturedValue = null;
        }

        return $this;
    }

    /**
     * Get capturedValue
     *
     * @return string 
     */
    public function getCapturedValue()
    {
        return $this->capturedValue;
    }

    /**
     * Set formattedValue
     *
     * @return AssessmentDetails
     */
    protected function setFormattedValue()
    {        
        switch( $this->indicator->getAnswerType() ){
            case 'integer':
            case 'float':
                $this->formattedValue = $this->getFormattedNumber($this->capturedValue);
                break;
            case 'YN':
            default:
                $this->formattedValue = ucwords($this->capturedValue);
                break;
        }

        return $this;
    }

    /**
     * Get formattedValue
     *
     * @return string 
     */
    public function getFormattedValue()
    {
        return $this->formattedValue;
    }

    /**
     * Set trendPercentage
     *
     * @param float $trendPercentage
     * @return AssessmentDetails
     */
    public function setTrendPercentage($trendPercentage)
    {
        $this->trendPercentage = $trendPercentage;

        return $this;
    }

    /**
     * Get trendPercentage
     *
     * @return float 
     */
    public function getTrendPercentage()
    {
        return $this->trendPercentage;
    }

    /**
     * Set comments
     *
     * @param string $comments
     * @return AssessmentDetails
     */
    public function setComments($comments)
    {
        $this->comments = $comments;

        return $this;
    }

    /**
     * Get comments
     *
     * @return string 
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * Set targetValue
     *
     * @param string $targetValue
     * @return AssessmentDetails
     */
    public function setTargetValue($targetValue)
    {
        if( strlen(trim($targetValue)) > 0 ){
            switch( $this->indicator->getAnswerType() ){
                case 'integer':
                case 'float':
                    // $this->targetValue = str_replace(',', '', $targetValue);
                    $value = floatval(str_replace(',', '', $targetValue));
                    if( $value < 0 ){
                        $value = floatval($this->capturedValue) - abs($value);
                    }
                    $this->targetValue = max(0, $value);
                    break;
                default:         
                    $this->targetValue = $targetValue;
                    break;
            }
        } else {
            $this->targetValue = null;
        }

        return $this;
    }

    /**
     * Get targetValue
     *
     * @return string 
     */
    public function getTargetValue()
    {
        return $this->targetValue;
    }

    /**
     * Set targetFormattedValue
     *
     * @return AssessmentDetails
     */
    protected function setTargetFormattedValue()
    {
        switch( $this->indicator->getAnswerType() ){
            case 'integer':
            case 'float':
                $this->targetFormattedValue = $this->getFormattedNumber($this->targetValue);
                break;
            case 'YN':
            default:
                $this->targetFormattedValue = ucwords($this->targetValue);
                break;
        }

        return $this;
    }

    /**
     * Get targetFormattedValue
     *
     * @return string 
     */
    public function getTargetFormattedValue()
    {
        return $this->targetFormattedValue;
    }

    /**
     * Set targetPercentage
     *
     * @param float $targetPercentage
     * @return AssessmentDetails
     */
    public function setTargetPercentage($targetPercentage)
    {
        $this->targetPercentage = $targetPercentage;

        return $this;
    }

    /**
     * Get targetPercentage
     *
     * @return float 
     */
    public function getTargetPercentage()
    {
        return $this->targetPercentage;
    }

    /**
     * Set targetComments
     *
     * @param string $targetComments
     * @return AssessmentDetails
     */
    public function setTargetComments($targetComments)
    {
        $this->targetComments = $targetComments;

        return $this;
    }

    /**
     * Get targetComments
     *
     * @return string 
     */
    public function getTargetComments()
    {
        return $this->targetComments;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return AssessmentDetails
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
     * @return AssessmentDetails
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
    public function setAssessment(Assessments $assessment = null)
    {
        $this->assessment = $assessment;
    }

    public function getAssessment()
    {
        return $this->assessment;
    }

    /**
     * Allow null to remove association
     */
    public function setPrevious(AssessmentDetails $previous = null)
    {
        $this->previous = $previous;
    }

    public function getPrevious()
    {
        return $this->previous;
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

    public function isAnswered()
    {
        return (bool) !(is_null($this->capturedValue) || strlen(trim($this->capturedValue)) == 0);
    }

    public function hasComments()
    {
        return (bool) !(is_null($this->comments) || strlen(trim($this->comments)) == 0);
    }

    public function hasTargetComments()
    {
        return (bool) !(is_null($this->targetComments) || strlen(trim($this->targetComments)) == 0);
    }

    public function getFormattedNumber($number)
    {
        return number_format($number, $this->getIndicator()->getDecimals());
        $number = floatval(str_replace(',', '', $number));
        $split = explode('.', $number);
        return number_format($number, array_key_exists(1, $split) ? strlen($split[1]) : 0);
    }
}

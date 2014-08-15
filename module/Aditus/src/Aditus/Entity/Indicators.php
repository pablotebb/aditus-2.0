<?php

namespace Aditus\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Indicators
 *
 * @ORM\Table(name="indicators", uniqueConstraints={@ORM\UniqueConstraint(name="code_UNIQUE", columns={"code"})})
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 *
 * @ORM\Entity(repositoryClass="Aditus\Model\IndicatorsRepository")
 */
class Indicators
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
     * @ORM\Column(name="parent_id", type="integer", nullable=true)
     */
    private $parentId;

    /**
     * @var integer
     *
     * @ORM\Column(name="account_id", type="integer", nullable=true)
     */
    private $accountId;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", nullable=true)
     */
    private $type = 'universal';

    /**
     * @var string
     *
     * @ORM\Column(name="category", type="string", nullable=true)
     */
    private $category;

    /**
     * @var string
     *
     * @ORM\Column(name="code", type="string", length=5, nullable=true)
     */
    private $code;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="text", nullable=true)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="unit", type="text", nullable=true)
     */
    private $unit;

    /**
     * @var string
     *
     * @ORM\Column(name="display_name", type="string", length=255, nullable=true)
     */
    private $displayName;

    /**
     * @var string
     *
     * @ORM\Column(name="answer_type", type="string", length=45, nullable=true)
     */
    private $answerType;

    /**
     * @var integer
     *
     * @ORM\Column(name="decimals", type="integer", nullable=true)
     */
    private $decimals;

    /**
     * @var string
     *
     * @ORM\Column(name="options", type="text", nullable=true)
     */
    private $options;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="help_text", type="text", nullable=true)
     */
    private $helpText;

    /**
     * @var string
     *
     * @ORM\Column(name="rationale", type="text", nullable=true)
     */
    private $rationale;

    /**
     * @var string
     *
     * @ORM\Column(name="display_rationale", type="text", nullable=true)
     */
    private $displayRationale;

    /**
     * @var boolean
     *
     * @ORM\Column(name="input", type="boolean", nullable=true)
     */
    private $input;

    /**
     * @var integer
     *
     * @ORM\Column(name="target_goal", type="integer", nullable=true)
     */
    private $targetGoal;

    /**
     * @var boolean
     *
     * @ORM\Column(name="active", type="boolean", nullable=true)
     */
    private $active;

    /**
     * @var boolean
     *
     * @ORM\Column(name="ordering", type="boolean", nullable=true)
     */
    private $ordering;

    /**
     * @var boolean
     *
     * @ORM\Column(name="display", type="boolean", nullable=true)
     */
    private $display;

    /**
     * @var boolean
     *
     * @ORM\Column(name="display_ordering", type="boolean", nullable=true)
     */
    private $displayOrdering;

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


    /** @ORM\PrePersist */
    public function onPrePersist()
    {
        // set the created time
        $this->created = new \DateTime('now');
        $this->active = 1;
        
        // custom KPI
        if( $this->category == 'C' ){
            $this->displayName = $this->name;
            $this->input = 1;
            $this->display = 1;
            $this->type = 'custom';
            $this->category = 'C';
            $this->code = 'custom';
            $this->displayRationale = $this->rationale;
        }
    }

    /** @ORM\PreUpdate */
    public function onPreUpdate()
    {
        $this->updated = new \DateTime('now');

        // custom KPI
        if( $this->category == 'C' ){
            $this->displayName = $this->name;
            $this->displayRationale = $this->rationale;
        }
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
     * Set parentId
     *
     * @param integer $parentId
     * @return Indicators
     */
    public function setParentId($parentId)
    {
        $this->parentId = $parentId;

        return $this;
    }

    /**
     * Get parentId
     *
     * @return integer 
     */
    public function getParentId()
    {
        return $this->parentId;
    }

    /**
     * Set accountId
     *
     * @param integer $accountId
     * @return Indicators
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
     * Set type
     *
     * @param string $type
     * @return Indicators
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
     * Set category
     *
     * @param string $category
     * @return Indicators
     */
    public function setCategory($category)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return string 
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set code
     *
     * @param string $code
     * @return Indicators
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code
     *
     * @return string 
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Indicators
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
     * Set unit
     *
     * @param string $unit
     * @return Indicators
     */
    public function setUnit($unit)
    {
        if( $this->answerType == 'YN' ){
            $this->unit = 'yes / no';
        } else {
            $this->unit = $unit;
        }

        return $this;
    }

    /**
     * Get unit
     *
     * @return string 
     */
    public function getUnit()
    {
        return $this->unit;
    }

    /**
     * Set displayName
     *
     * @param string $displayName
     * @return Indicators
     */
    public function setDisplayName($displayName)
    {
        $this->displayName = $displayName;

        return $this;
    }

    /**
     * Get displayName
     *
     * @return string 
     */
    public function getDisplayName()
    {
        return $this->displayName;
    }

    /**
     * Set answerType
     *
     * @param string $answerType
     * @return Indicators
     */
    public function setAnswerType($answerType)
    {
        $this->answerType = $answerType;

        return $this;
    }

    /**
     * Get answerType
     *
     * @return string 
     */
    public function getAnswerType()
    {
        return $this->answerType;
    }

    /**
     * Set decimals
     *
     * @param integer $decimals
     * @return Indicators
     */
    public function setDecimals($decimals)
    {
        $this->decimals = $decimals;

        return $this;
    }

    /**
     * Get decimals
     *
     * @return integer 
     */
    public function getDecimals()
    {
        return $this->decimals;
    }

    /**
     * Set allowNotApplicable
     *
     * @param boolean $allowNotApplicable
     * @return Indicators
     */
    public function setAllowNotApplicable($allowNotApplicable)
    {
        $this->allowNotApplicable = $allowNotApplicable;

        return $this;
    }

    /**
     * Get allowNotApplicable
     *
     * @return boolen 
     */
    public function getAllowNotApplicable()
    {
        return $this->allowNotApplicable;
    }

    /**
     * Set options
     *
     * @param string $options
     * @return Indicators
     */
    public function setOptions($options)
    {
        $this->options = $options;

        return $this;
    }

    /**
     * Get options
     *
     * @return string 
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Indicators
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
     * Set helpText
     *
     * @param string $helpText
     * @return Indicators
     */
    public function setHelpText($helpText)
    {
        $this->helpText = $helpText;

        return $this;
    }

    /**
     * Get helpText
     *
     * @return string 
     */
    public function getHelpText()
    {
        return $this->helpText;
    }

    /**
     * Set displayRationale
     *
     * @param string $displayRationale
     * @return Indicators
     */
    public function setDisplayRationale($displayRationale)
    {
        $this->displayRationale = $displayRationale;

        return $this;
    }

    /**
     * Get displayRationale
     *
     * @return string 
     */
    public function getDisplayRationale()
    {
        return $this->displayRationale;
    }

    /**
     * Set rationale
     *
     * @param string $rationale
     * @return Indicators
     */
    public function setRationale($rationale)
    {
        $this->rationale = $rationale;

        return $this;
    }

    /**
     * Get rationale
     *
     * @return string 
     */
    public function getRationale()
    {
        return $this->rationale;
    }

    /**
     * Set input
     *
     * @param boolean $input
     * @return Indicators
     */
    public function setInput($input)
    {
        $this->input = $input;

        return $this;
    }

    /**
     * Get input
     *
     * @return boolean 
     */
    public function getInput()
    {
        return $this->input;
    }

    /**
     * Set targetGoal
     *
     * @param integer $targetGoal
     * @return Indicators
     */
    public function setTargetGoal($targetGoal)
    {
        $this->targetGoal = $targetGoal;

        return $this;
    }

    /**
     * Get targetGoal
     *
     * @return integer 
     */
    public function getTargetGoal()
    {
        return $this->targetGoal;
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
     * Set ordering
     *
     * @param boolean $ordering
     * @return Indicators
     */
    public function setOrdering($ordering)
    {
        $this->ordering = $ordering;

        return $this;
    }

    /**
     * Get ordering
     *
     * @return boolean 
     */
    public function getOrdering()
    {
        return $this->ordering;
    }

    /**
     * Set display
     *
     * @param boolean $display
     * @return Indicators
     */
    public function setDisplay($display)
    {
        $this->display = $display;

        return $this;
    }

    /**
     * Get display
     *
     * @return boolean 
     */
    public function getDisplay()
    {
        return $this->display;
    }

    /**
     * Set displayOrdering
     *
     * @param boolean $displayOrdering
     * @return Indicators
     */
    public function setDisplayOrdering($displayOrdering)
    {
        $this->displayOrdering = $displayOrdering;

        return $this;
    }

    /**
     * Get displayOrdering
     *
     * @return boolean 
     */
    public function getDisplayOrdering()
    {
        return $this->displayOrdering;
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
    public function setAccount(Accounts $account = null)
    {
        $this->account = $account;
    }

    public function getAccount()
    {
        return $this->account;
    }


    public function getCategoryName()
    {
        switch( $this->category ){
            case 'E':
                return 'Environmental';
            case 'S':
                return 'Social';
            case 'G':
                return 'Governance';
            case 'C':
                return 'Custom';
        }
    }
}

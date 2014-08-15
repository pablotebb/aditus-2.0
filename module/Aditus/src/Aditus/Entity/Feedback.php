<?php

namespace Aditus\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\Form\Annotation as Form;

/**
 * Feedback
 *
 * @ORM\Table(name="feedback")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 *
 * @ORM\Entity(repositoryClass="Aditus\Model\FeedbackRepository")
 *
 * @Form\Name("Feedback")
 */
class Feedback
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
     * @var integer
     *
     * @ORM\Column(name="user_id", type="string", nullable=true)
     */
    private $userId;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="text", nullable=true)
     */
    private $type = 'uncategorized';

    /**
     * @var string
     *
     * @ORM\Column(name="referrer", type="text", nullable=true)
     */
    private $referrer;

    /**
     * @var string
     *
     * @ORM\Column(name="comments", type="text", nullable=true)
     */
    private $comments;

    /**
     * @var string
     *
     * @ORM\Column(name="notes", type="text", nullable=true)
     */
    private $notes;

    /**
     * @var string
     *
     * @ORM\Column(name="browser_information", type="text", nullable=true)
     */
    private $browserInformation;

    /**
     * @var string
     *
     * @ORM\Column(name="backtrace", type="text", nullable=true)
     */
    private $backtrace;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="text", nullable=true)
     */
    private $status;

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

    private $types = array(
        'uncategorized' => 'Uncategorized',
        'wording'       => 'Wording',
        'features'      => 'Features',
        'ux'            => 'UX',
        'technical'     => 'Technical Error',
        'general'       => 'General',
        'other'         => 'Other',
    );


    /**
     * @ORM\ManyToOne(targetEntity="Users")
     * @ORM\JoinColumn(referencedColumnName="id")
     **/
    public $user;    



    /** @ORM\PrePersist */
    public function onPrePersist()
    {
        // set the created time
        $this->created = new \DateTime('now');
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
     * @return string 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set userId
     *
     * @param string $userId
     * @return Feedback
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * Get userId
     *
     * @return string 
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Set type
     *
     * @param string $type
     * @return Feedback
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
     * Set referrer
     *
     * @param string $referrer
     * @return Feedback
     */
    public function setReferrer($referrer)
    {
        $this->referrer = $referrer;

        return $this;
    }

    /**
     * Get referrer
     *
     * @return string 
     */
    public function getReferrer()
    {
        return $this->referrer;
    }

    /**
     * Set comments
     *
     * @param string $comments
     * @return Feedback
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
     * Set notes
     *
     * @param string $notes
     * @return Feedback
     */
    public function setNotes($notes)
    {
        $this->notes = $notes;

        return $this;
    }

    /**
     * Get notes
     *
     * @return string 
     */
    public function getNotes()
    {
        return $this->notes;
    }

    /**
     * Set browserInformation
     *
     * @param string $browserInformation
     * @return Feedback
     */
    public function setBrowserInformation($browserInformation)
    {
        $this->browserInformation = $browserInformation;

        return $this;
    }

    /**
     * Get browserInformation
     *
     * @return string 
     */
    public function getBrowserInformation()
    {
        return $this->browserInformation;
    }

    /**
     * Set backtrace
     *
     * @param string $backtrace
     * @return Feedback
     */
    public function setBacktrace($backtrace)
    {
        $this->backtrace = $backtrace;

        return $this;
    }

    /**
     * Get backtrace
     *
     * @return string 
     */
    public function getBacktrace()
    {
        return $this->backtrace;
    }

    /**
     * Set status
     *
     * @param string $status
     * @return Feedback
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
     * Allow null to remove association
     */
    public function setUser(Users $user = null)
    {
        $this->user = $user;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function displayType()
    {
        return array_key_exists($this->type, $this->types) ? $this->types[$this->type] : 'uncategorized';
    }

    public function getTypes()
    {
        return $this->types;
    }
}

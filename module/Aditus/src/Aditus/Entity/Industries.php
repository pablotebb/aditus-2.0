<?php

namespace Aditus\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Industries
 *
 * @ORM\Table(name="industries")
 * @ORM\Entity
 *
 * @ORM\Entity(repositoryClass="Aditus\Model\IndustriesRepository")
 */
class Industries
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
     * @ORM\Column(name="parent_id", type="string", nullable=true)
     */
    private $parentId;

    /**
     * @var string
     *
     * @ORM\Column(name="cni_code", type="string", length=45, nullable=true)
     */
    private $cniCode;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="Companies", mappedBy="industry")
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
     * Set parentId
     *
     * @param string $parentId
     * @return Industries
     */
    public function setParentId($parentId)
    {
        $this->parentId = $parentId;

        return $this;
    }

    /**
     * Get parentId
     *
     * @return string 
     */
    public function getParentId()
    {
        return $this->parentId;
    }

    /**
     * Set cniCode
     *
     * @param string $cniCode
     * @return Industries
     */
    public function setCniCode($cniCode)
    {
        $this->cniCode = $cniCode;

        return $this;
    }

    /**
     * Get cniCode
     *
     * @return string 
     */
    public function getCniCode()
    {
        return $this->cniCode;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Industries
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
     * Get companies
     *
     * @return array
     */
    public function getCompanies()
    {
        return $this->companies;
    }
    
}

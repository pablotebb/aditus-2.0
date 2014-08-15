<?php
namespace Aditus\Controller;

use Doctrine\ORM\EntityManager;
use Zend\Mvc\Controller\AbstractActionController;

class EntityUsingController extends AbstractActionController
{
    /**
    * @var EntityManager
    */
    protected $entityManager;

    /**
    * Sets the EntityManager
    *
    * @param EntityManager $em
    * @access protected
    * @return PostController
    */
    protected function setEntityManager(EntityManager $em)
    {
        $this->entityManager = $em;

        return $this;
    }
    /**
    * Returns the EntityManager
    *
    * Fetches the EntityManager from ServiceLocator if it has not been initiated
    * and then returns it
    *
    * @access protected
    * @return EntityManager
    */
    protected function getEntityManager()
    {
        if (null === $this->entityManager) {
            $this->setEntityManager($this->getServiceLocator()->get('Doctrine\ORM\EntityManager'));
        }

        return $this->entityManager;
    }
    /**
     * [indexAction]
     * @return 
     */
    public function indexAction()
    {

    }

    /**
     * [addAction]
     * @return 
     */

    public function addAction()
    {

    }
    /**
     * [editAction]
     * @return 
     */
    public function editAction()
    {

    }
    /**
     * [deleteAction]
     * @return 
     */
    public function deleteAction()
    {

    }
}

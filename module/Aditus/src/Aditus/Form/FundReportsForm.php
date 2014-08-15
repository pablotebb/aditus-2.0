<?php
namespace Aditus\Form;

use Doctrine\Common\Persistence\ObjectManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Zend\Form\Form;
use Aditus\Form\FundReportsFieldset;

class FundReportsForm extends Form
{
    public function __construct(ObjectManager $objectManager)
    {
        parent::__construct('fundReport');

        // The form will hydrate an object of type "Users"
        $this->setHydrator(new DoctrineHydrator($objectManager));

        // Add the user fieldset, and set it as the base fieldset
        $fieldset = new FundReportsFieldset($objectManager);
        $fieldset->setUseAsBaseFieldset(true);
        $this->add($fieldset);
        // … add CSRF and submit elements …

        // Optionally set your validation group here
    }
}
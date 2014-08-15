<?php
namespace Aditus\Form;

use Doctrine\Common\Persistence\ObjectManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Zend\Form\Form;
use Aditus\Form\FundsFieldset;

class CreateFundForm extends Form
{
    public function __construct(ObjectManager $objectManager)
    {
        parent::__construct('create-fund-form');

        // The form will hydrate an object of type "Funds"
        $this->setHydrator(new DoctrineHydrator($objectManager));

        // Add the user fieldset, and set it as the base fieldset
        $fundsFieldset = new FundsFieldset($objectManager);
        $fundsFieldset->setUseAsBaseFieldset(true);
        $this->add($fundsFieldset);

        // … add CSRF and submit elements …

        // Optionally set your validation group here
    }
}
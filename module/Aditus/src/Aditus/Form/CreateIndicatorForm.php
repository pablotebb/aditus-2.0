<?php
namespace Aditus\Form;

use Doctrine\Common\Persistence\ObjectManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Zend\Form\Form;
use Aditus\Form\IndicatorsFieldset;

class CreateIndicatorForm extends Form
{
    public function __construct(ObjectManager $objectManager)
    {
        parent::__construct('create-indicator-form');

        // The form will hydrate an object of type "Funds"
        $this->setHydrator(new DoctrineHydrator($objectManager));

        // Add the user fieldset, and set it as the base fieldset
        $indicatorsFieldset = new IndicatorsFieldset($objectManager);
        $indicatorsFieldset->setUseAsBaseFieldset(true);
        $this->add($indicatorsFieldset);

        // … add CSRF and submit elements …

        // Optionally set your validation group here
    }
}
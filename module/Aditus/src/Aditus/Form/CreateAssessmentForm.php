<?php
namespace Aditus\Form;

use Doctrine\Common\Persistence\ObjectManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Zend\Form\Form;
use Aditus\Form\AssessmentsFieldset;

class CreateAssessmentForm extends Form
{
    public function __construct(ObjectManager $objectManager)
    {
        parent::__construct('create-assessment-form');

        // The form will hydrate an object of type "Assessments"
        $this->setHydrator(new DoctrineHydrator($objectManager));

        // Add the user fieldset, and set it as the base fieldset
        $assessmentsFieldset = new AssessmentsFieldset($objectManager);
        $assessmentsFieldset->setUseAsBaseFieldset(true);
        $this->add($assessmentsFieldset);

        // … add CSRF and submit elements …

        // Optionally set your validation group here
    }
}
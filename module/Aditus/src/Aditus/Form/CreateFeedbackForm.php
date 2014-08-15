<?php
namespace Aditus\Form;

use Doctrine\Common\Persistence\ObjectManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Zend\Form\Form;
use Aditus\Form\FeedbackFieldset;

class CreateFeedbackForm extends Form
{
    public function __construct(ObjectManager $objectManager)
    {
        parent::__construct('create-feedback-form');

        // The form will hydrate an object of type "Feedback"
        $this->setHydrator(new DoctrineHydrator($objectManager));

        // Add the user fieldset, and set it as the base fieldset
        $feedbackFieldset = new FeedbackFieldset($objectManager);
        $feedbackFieldset->setUseAsBaseFieldset(true);
        $this->add($feedbackFieldset);

        // … add CSRF and submit elements …

        // Optionally set your validation group here
    }
}
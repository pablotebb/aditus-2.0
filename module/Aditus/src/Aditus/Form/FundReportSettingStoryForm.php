<?php
namespace Aditus\Form;

use Doctrine\Common\Persistence\ObjectManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Zend\Form\Form;
use Aditus\Form\FundReportSettingsFieldset;

class FundReportSettingStoryForm extends Form
{
    public function __construct(ObjectManager $objectManager)
    {
        parent::__construct('story');

        // The form will hydrate an object of type "Users"
        $this->setHydrator(new DoctrineHydrator($objectManager));

        // Add the user fieldset, and set it as the base fieldset
        $fieldset = new FundReportSettingsFieldset($objectManager);
        $fieldset->setUseAsBaseFieldset(true);
        $this->add($fieldset->get('story'));

        // … add CSRF and submit elements …

        // Optionally set your validation group here
    }
}
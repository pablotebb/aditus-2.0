<?php
namespace Aditus\Form;

use Doctrine\Common\Persistence\ObjectManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Zend\Form\Form;
use Aditus\Form\CompaniesFieldset;

class CreateCompanyForm extends Form
{
    public function __construct(ObjectManager $objectManager)
    {
        parent::__construct('create-company-form');

        // The form will hydrate an object of type "Funds"
        $this->setHydrator(new DoctrineHydrator($objectManager));

        // Add the user fieldset, and set it as the base fieldset
        $companyFieldset = new CompaniesFieldset($objectManager);
        $companyFieldset->setUseAsBaseFieldset(true);
        $this->add($companyFieldset);

        // … add CSRF and submit elements …

        // Optionally set your validation group here
    }
}
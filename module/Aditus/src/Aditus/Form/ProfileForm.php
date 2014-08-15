<?php
namespace Aditus\Form;

use Doctrine\Common\Persistence\ObjectManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Zend\Form\Form;
use Aditus\Form\UsersFieldset;
use Aditus\Form\AccountsFieldset;

class ProfileForm extends Form
{
    public function __construct(ObjectManager $objectManager)
    {
        parent::__construct('profile');

        // The form will hydrate an object of type "Users"
        $this->setHydrator(new DoctrineHydrator($objectManager));

        // Add the user fieldset, and set it as the base fieldset
        $usersFieldset = new UsersFieldset($objectManager);
        $usersFieldset->setUseAsBaseFieldset(true);
        $this->add($usersFieldset);

        // … add CSRF and submit elements …
        // Optionally set your validation group here
    }
}
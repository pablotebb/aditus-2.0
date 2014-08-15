<?php
namespace Aditus\Form;

use Doctrine\Common\Persistence\ObjectManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Zend\Form\Form;
use Aditus\Form\UsersFieldset;

class LoginForm extends Form
{
    public function __construct(ObjectManager $objectManager)
    {
        parent::__construct('login');

        // The form will hydrate an object of type "Users"
        $this->setHydrator(new DoctrineHydrator($objectManager));

        // Add the user fieldset, and set it as the base fieldset
        $usersFieldset = new UsersFieldset($objectManager);
        $usersFieldset->setUseAsBaseFieldset(true);
        
        $this->add($usersFieldset->get('email')->setAttribute('placeholder', 'EMAIL'));
        $this->add($usersFieldset->get('secret')->setAttribute('placeholder', 'PASSWORD'));

        // … add CSRF and submit elements …

        // Optionally set your validation group here
    }
}
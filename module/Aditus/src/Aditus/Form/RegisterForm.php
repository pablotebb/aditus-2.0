<?php
namespace Aditus\Form;

use Doctrine\Common\Persistence\ObjectManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Zend\Form\Form;
use Aditus\Form\UsersFieldset;
use Aditus\Form\AccountsFieldset;

class RegisterForm extends Form
{
    public function __construct(ObjectManager $objectManager)
    {
        parent::__construct('register');

        // The form will hydrate an object of type "Users"
        $this->setHydrator(new DoctrineHydrator($objectManager));

        // Add the user fieldset, and set it as the base fieldset
        $usersFieldset = new UsersFieldset($objectManager);
        $usersFieldset->setUseAsBaseFieldset(true);
        $this->add($usersFieldset->get('firstName')->setAttribute('placeholder', 'FIRST NAME'));
        $this->add($usersFieldset->get('lastName')->setAttribute('placeholder', 'LAST NAME'));
        $this->add($usersFieldset->get('email')->setAttribute('placeholder', 'EMAIL'));
        $this->add($usersFieldset->get('phone')->setAttribute('placeholder', 'PHONE'));
        $this->add($usersFieldset->get('secret')->setAttribute('placeholder', 'PASSWORD'));

        // Add the accounts fieldset, and set it as the base fieldset
        $accountsFieldset = new AccountsFieldset($objectManager);    
        $this->add($accountsFieldset->get('name')->setAttribute('placeholder', 'COMPANY NAME'));
        $this->add($accountsFieldset);
        // … add CSRF and submit elements …

        // Optionally set your validation group here
    }
}
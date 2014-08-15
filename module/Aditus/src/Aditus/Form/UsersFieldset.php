<?php
namespace Aditus\Form;

use Aditus\Entity\Users;
use Doctrine\Common\Persistence\ObjectManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;

class UsersFieldset extends Fieldset implements InputFilterProviderInterface
{
    public function __construct(ObjectManager $objectManager)
    {
        parent::__construct('user');

        $this->setHydrator(new DoctrineHydrator($objectManager))
             ->setObject(new Users());

        $this->add(array(
            'type' => 'Zend\Form\Element\Hidden',
            'name' => 'id'
        ));

        $this->add(array(
            'type'    => 'Zend\Form\Element\Text',
            'name'    => 'firstName',
            'options' => array(
                'label' => 'First Name'
            ),
            'attributes' => array(
                'required' => 'required',
            ),
        ));

        $this->add(array(
            'type'    => 'Zend\Form\Element\Text',
            'name'    => 'lastName',
            'options' => array(
                'label' => 'Last Name'
            ),
            'attributes' => array(
                'required' => 'required',
            ),
        ));

        $this->add(array(
            'type'    => 'Zend\Form\Element\Email',
            'name'    => 'email',
            'options' => array(
                'label' => 'Email'
            ),
            'attributes' => array(
                'required' => 'required',
            ),
        ));

        $this->add(array(
            'type'    => 'Zend\Form\Element\Text',
            'name'    => 'phone',
            'options' => array(
                'label' => 'Phone'
            ),
            'attributes' => array(
            ),
        ));

        $this->add(array(
            'type'    => 'Zend\Form\Element\Password',
            'name'    => 'secret',
            'options' => array(
                'label' => 'Password'
            ),
            'attributes' => array(
                'required' => 'required',
            ),
        ));

        $this->add(new AccountsFieldset($objectManager));        
    }

    public function getInputFilterSpecification()
    {
        return array(
            'id' => array(
                'required' => false
            ),

            'firstName' => array(
                'required' => true
            ),

            'lastName' => array(
                'required' => true
            ),

            'email' => array(
                'required' => true
            ),
        );
    }
}
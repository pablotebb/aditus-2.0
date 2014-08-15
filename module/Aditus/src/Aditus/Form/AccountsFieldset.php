<?php
namespace Aditus\Form;

use Aditus\Entity\Accounts;
use Doctrine\Common\Persistence\ObjectManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;

class AccountsFieldset extends Fieldset implements InputFilterProviderInterface
{
    public function __construct(ObjectManager $objectManager)
    {
        parent::__construct('account');

        $this->setHydrator(new DoctrineHydrator($objectManager))
             ->setObject(new Accounts());

        $this->add(array(
            'type' => 'Zend\Form\Element\Hidden',
            'name' => 'id'
        ));

        $this->add(array(
            'type'    => 'Zend\Form\Element\Text',
            'name'    => 'name',
            'options' => array(
                'label' => 'Company Name'
            ),
            'attributes' => array(
                'required' => 'required',
            ),
        ));

   }

    public function getInputFilterSpecification()
    {
        return array(
            'id' => array(
                'required' => false
            ),

            'name' => array(
                'required' => true
            ),
        );
    }
}
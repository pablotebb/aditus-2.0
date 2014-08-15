<?php
namespace Aditus\Form;

use Aditus\Entity\Funds;
use Doctrine\Common\Persistence\ObjectManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;

class FundsFieldset extends Fieldset implements InputFilterProviderInterface
{
    public function __construct(ObjectManager $objectManager)
    {
        parent::__construct('fund');

        $this->setHydrator(new DoctrineHydrator($objectManager))
             ->setObject(new Funds());

        $this->add(array(
            'type' => 'Zend\Form\Element\Hidden',
            'name' => 'id'
        ));

        $this->add(array(
            'type'    => 'Zend\Form\Element\Text',
            'name'    => 'name',
            'options' => array(
                'label' => 'Name'
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
            )
        );
    }
}
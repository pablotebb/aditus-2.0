<?php
namespace Aditus\Form;

use Aditus\Entity\AssessmentDetails;
use Doctrine\Common\Persistence\ObjectManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;

class AssessmentDetailsFieldset extends Fieldset implements InputFilterProviderInterface
{
    public function __construct(ObjectManager $objectManager)
    {
        parent::__construct('detail');

        $this->setHydrator(new DoctrineHydrator($objectManager))
             ->setObject(new AssessmentDetails());

        $this->add(array(
            'type' => 'Zend\Form\Element\Hidden',
            'name' => 'id'
        ));

        $this->add(array(
            'type'    => 'Zend\Form\Element\Textarea',
            'name'    => 'comments',
            'options' => array(
                'label' => 'Note',
            ),
            'attributes' => array(
                'rows' => 5,
            ),
        ));

        $this->add(array(
            'type'    => 'Zend\Form\Element\Textarea',
            'name'    => 'targetComments',
            'options' => array(
                'label' => 'Target Note',
            ),
            'attributes' => array(
                'rows' => 5,
            ),
        ));

    }

    public function getInputFilterSpecification()
    {
        return array(
            'id' => array(
                'required' => false
            ),
        );
    }
}
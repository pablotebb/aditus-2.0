<?php
namespace Aditus\Form;

use Aditus\Entity\Indicators;
use Doctrine\Common\Persistence\ObjectManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;

class IndicatorsFieldset extends Fieldset implements InputFilterProviderInterface
{
    public function __construct(ObjectManager $objectManager)
    {
        parent::__construct('indicator');

        $this->setHydrator(new DoctrineHydrator($objectManager))
             ->setObject(new Indicators());

        $this->add(array(
            'type' => 'Zend\Form\Element\Hidden',
            'name' => 'id'
        ));

        $this->add(array(
            'type'    => 'Zend\Form\Element\Text',
            'name'    => 'name',
            'options' => array(
                'label' => 'Name',
            ),
            'attributes' => array(
                'required' => 'required',
            ),
        ));

        $this->add(array(
            'type'    => 'Zend\Form\Element\Text',
            'name'    => 'unit',
            'options' => array(
                'label' => 'Unit of Measure',
            ),
            'attributes' => array(
            ),
        ));

        $this->add(array(
            'type'    => 'Zend\Form\Element\Select',
            'name'    => 'answerType',
            'options' => array(
                'label' => 'Answer Type',
                'empty_option' => 'Select',
                'value_options' => array(
                    'integer'   => 'Quantitative',
                    'YN'        => 'Yes / No',
                 ),                
            ),
            'attributes' => array(
                'required' => 'required',
            ),
        ));

        $this->add(array(
            'type'    => 'Zend\Form\Element\Textarea',
            'name'    => 'rationale',
            'options' => array(
                'label' => 'Rationale',
            ),
            'attributes' => array(
                'rows' => 6,
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

            'answerType' => array(
                'required' => true
            ),
        );
    }
}
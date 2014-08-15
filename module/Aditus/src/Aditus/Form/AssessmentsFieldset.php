<?php
namespace Aditus\Form;

use Aditus\Entity\Assessments;
use Doctrine\Common\Persistence\ObjectManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;

class AssessmentsFieldset extends Fieldset implements InputFilterProviderInterface
{
    public function __construct(ObjectManager $objectManager)
    {
        parent::__construct('assessment');

        $this->setHydrator(new DoctrineHydrator($objectManager))
             ->setObject(new Assessments());

        $this->add(array(
            'type' => 'Zend\Form\Element\Hidden',
            'name' => 'id'
        ));

        $this->add(array(
            'type'    => 'Zend\Form\Element\Select',
            'name'    => 'reportingYear',
            'options' => array(
                'label' => 'Reporting Year',
                'empty_option' => 'Select',
                'value_options' => array(
                    '2014' => '2014',
                    '2013' => '2013',
                    '2012' => '2012',
                    '2011' => '2011',
                    '2010' => '2010',
                 ),                
            ),
            'attributes' => array(
                'required' => 'required',
            ),
        ));

        $this->add(array(
            'type'    => 'Zend\Form\Element\Select',
            'name'    => 'reportingPeriod',
            'options' => array(
                'label' => 'Reporting Period',
                'empty_option' => 'Select',
                'value_options' => array(
                    'YEAR' => 'Year',
                    'Q1' => 'Q1',
                    'Q2' => 'Q2',
                    'Q3' => 'Q3',
                    'Q4' => 'Q4',
                 ),                
            ),
            'attributes' => array(
                'required' => 'required',
            ),
        ));

        $this->add(array(
            'type'    => 'Zend\Form\Element\Text',
            'name'    => 'reportingStart',
            'options' => array(
                'label' => 'Start Date',
                'format' => 'Y-m-d',
            ),
            'attributes' => array(
                'required' => 'required',
            ),
        ));

        $this->add(array(
            'type'    => 'Zend\Form\Element\Text',
            'name'    => 'reportingEnd',
            'options' => array(
                'label' => 'End Date',
                'format' => 'Y-m-d',
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

            'reportingYear' => array(
                'required' => true
            ),

            'reportingPeriod' => array(
                'required' => true
            ),

            'reportingStart' => array(
                'required' => true
            ),

            'reportingEnd' => array(
                'required' => true
            ),
        );
    }
}
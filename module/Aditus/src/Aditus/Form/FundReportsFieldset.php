<?php
namespace Aditus\Form;

use Aditus\Entity\FundReports;
use Doctrine\Common\Persistence\ObjectManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;

class FundReportsFieldset extends Fieldset implements InputFilterProviderInterface
{
    public function __construct(ObjectManager $objectManager)
    {
        parent::__construct('report');

        $this->setHydrator(new DoctrineHydrator($objectManager))
             ->setObject(new FundReports());

        $this->add(array(
            'type' => 'Zend\Form\Element\Hidden',
            'name' => 'id'
        ));

        // resultDisplay
        $this->add(array(
            'type'    => 'Zend\Form\Element\Select',
            'name'    => 'resultDisplay',
            'options' => array(
                'label' => 'Results Display',
                'value_options' => array(
                     'average'    => 'Average',
                     'aggregate'  => 'Aggregate',
                ),
            )
        ));

        // disclosureDisplay
        $this->add(array(
            'type'    => 'Zend\Form\Element\Select',
            'name'    => 'displayDisclosure',
            'options' => array(
                'label' => 'Company/KPI Disclosure',
                'value_options' => array(
                     'display'    => 'Display',
                     'hide'       => 'Hide',
                ),
            )
        ));

        // eOverview
        $this->add(array(
            'type'    => 'Zend\Form\Element\Textarea',
            'name'    => 'eOverview',
            'options' => array(
                'label' => 'Overview'
            ),
            'attributes' => array(
                'required' => 'required',
                'rows' => 6,
            ),
        ));        

        // sOverview
        $this->add(array(
            'type'    => 'Zend\Form\Element\Textarea',
            'name'    => 'sOverview',
            'options' => array(
                'label' => 'Overview'
            ),
            'attributes' => array(
                'required' => 'required',
                'rows' => 6,
            ),
        ));        

        // gOverview
        $this->add(array(
            'type'    => 'Zend\Form\Element\Textarea',
            'name'    => 'gOverview',
            'options' => array(
                'label' => 'Overview'
            ),
            'attributes' => array(
                'required' => 'required',
                'rows' => 6,
            ),
        ));        

        // cOverview
        $this->add(array(
            'type'    => 'Zend\Form\Element\Textarea',
            'name'    => 'cOverview',
            'options' => array(
                'label' => 'Overview'
            ),
            'attributes' => array(
                'required' => 'required',
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
        );
    }
}
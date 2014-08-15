<?php
namespace Aditus\Form;

use Aditus\Entity\FundReportSettings;
use Doctrine\Common\Persistence\ObjectManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;

class FundReportSettingsFieldset extends Fieldset implements InputFilterProviderInterface
{
    public function __construct(ObjectManager $objectManager)
    {
        parent::__construct('setting');

        $this->setHydrator(new DoctrineHydrator($objectManager))
             ->setObject(new FundReportSettings());

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
                     'global'     => 'Default',
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
                'label' => 'Company Count',
                'value_options' => array(
                     'global'     => 'Default',
                     'display'    => 'Display',
                     'hide'       => 'Hide',
                ),
            )
        ));

        // story
        $this->add(array(
            'type'    => 'Zend\Form\Element\Textarea',
            'name'    => 'story',
            'options' => array(
                'label' => 'Story'
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
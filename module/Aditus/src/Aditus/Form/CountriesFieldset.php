<?php
namespace Aditus\Form;

use Aditus\Entity\Countries;
use Doctrine\Common\Persistence\ObjectManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;

class CountriesFieldset extends Fieldset implements InputFilterProviderInterface
{
    public function __construct(ObjectManager $objectManager)
    {
        parent::__construct('country');

        $this->setHydrator(new DoctrineHydrator($objectManager))
             ->setObject(new Countries());

        $this->add(array(
            'type' => 'DoctrineModule\Form\Element\ObjectSelect',
            'name' => 'id',
            'options' => array(
                'label' => 'Country',
                'empty_option'    => '-- Select --',
                'object_manager' => $objectManager,
                'target_class' => 'Aditus\Entity\Countries',                
                'property' => 'id',      
                'label_generator' => function($targetEntity) {
                    return $targetEntity->getName();
                },

                'is_method'      => true,
                'find_method'    => array(
                    'name' => 'findBy',
                    'params' => array(
                        'criteria' => array('active' => 1),
                        'orderBy'  => array('name' => 'ASC'),
                    ),
                ),

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

        );
    }
}
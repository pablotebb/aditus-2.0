<?php
namespace Aditus\Form;

use Aditus\Entity\Industries;
use Doctrine\Common\Persistence\ObjectManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;

class IndustriesFieldset extends Fieldset implements InputFilterProviderInterface
{
    public function __construct(ObjectManager $objectManager)
    {
        parent::__construct('industry');

        $this->setHydrator(new DoctrineHydrator($objectManager))
             ->setObject(new Industries());

        $this->add(array(
            'type' => 'DoctrineModule\Form\Element\ObjectSelect',
            'name' => 'id',
            'options' => array(
                'label' => 'Sector',
                'empty_option'    => '-- Select --',
                'empty_value' => 0,
                'object_manager' => $objectManager,
                'target_class' => 'Aditus\Entity\Industries',                
                'property' => 'id',      
                'is_method'      => true,             
                'find_method'    => array(
                    'name'   => 'getSuperSectors',
                ),
                'label_generator' => function($targetEntity) {
                    return $targetEntity->getName();
                },
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
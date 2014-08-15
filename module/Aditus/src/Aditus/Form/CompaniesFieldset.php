<?php
namespace Aditus\Form;

use Aditus\Entity\Companies;
use Doctrine\Common\Persistence\ObjectManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;

class CompaniesFieldset extends Fieldset implements InputFilterProviderInterface
{
    public function __construct(ObjectManager $objectManager)
    {
        parent::__construct('company');

        $this->setHydrator(new DoctrineHydrator($objectManager))
             ->setObject(new Companies());

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

        $this->add(new IndustriesFieldset($objectManager));
        $this->add(new CountriesFieldset($objectManager));
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
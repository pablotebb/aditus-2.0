<?php
namespace Aditus\Form;

use Doctrine\Common\Persistence\ObjectManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Zend\Form\Form;

class FilterPortfolioForm extends Form
{
    public function __construct(ObjectManager $objectManager)
    {
        parent::__construct('filter');

        $this->setHydrator(new DoctrineHydrator($objectManager));

        $this->add(new IndustriesFieldset($objectManager));
        $this->add(new CountriesFieldset($objectManager));

        // group by
        $this->add(array(
            'type'    => 'Zend\Form\Element\Select',
            'name'    => 'groupBy',
            'options' => array(
                'label' => 'Group By',
                'value_options' => array(
                     'fund'     => 'Fund',
                     'sector'   => 'Sector',
                     'country'  => 'Country',
                ),
            )
        ));

        // group by result
        $this->add(array(
            'type'    => 'Zend\Form\Element\Select',
            'name'    => 'groupResult',
            'options' => array(
                'label' => '&nbsp;',
                'value_options' => array(
                     'average'      => 'Average',
                     'aggregate'    => 'Aggregate',
                ),
            )
        ));
    }
}
<?php
namespace Aditus\Form;

use Aditus\Entity\Feedback;
use Doctrine\Common\Persistence\ObjectManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;

class FeedbackFieldset extends Fieldset implements InputFilterProviderInterface
{
    public function __construct(ObjectManager $objectManager)
    {
        parent::__construct('feedback');

        $this->setHydrator(new DoctrineHydrator($objectManager))
             ->setObject(new Feedback());

        $this->add(array(
            'type' => 'Zend\Form\Element\Hidden',
            'name' => 'id'
        ));

        $this->add(array(
            'type'    => 'Zend\Form\Element\Textarea',
            'name'    => 'comments',
            'options' => array(
                'label' => 'Comment'
            ),
            'attributes' => array(
                'required' => 'required',
                'rows'  => 6
            ),
        ));
    }

    public function getInputFilterSpecification()
    {
        return array(
            'id' => array(
                'required' => false
            ),

            'comments' => array(
                'required' => true
            )
        );
    }
}
<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Aditus\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Aditus\Controller\EntityUsingController;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Zend\View\Model\JsonModel;
use Aditus\Form\CreateFeedbackForm;

class FeedbackController extends EntityUsingController
{
    public function editAction()
    {
        if( $this->params('id') > 0 ){
            // check for feedbackId
            $feedback = $this->getEntityManager()->find('\Aditus\Entity\Feedback', $this->params('id'));
        } else {
            // Create a new, empty entity and bind it to the form
            $feedback = new \Aditus\Entity\Feedback();            
        }

        // Create the form and inject the ObjectManager
        $feedbackForm = new CreateFeedbackForm($this->getEntityManager());
        $feedbackForm->bind($feedback);

        if ($this->request->isPost()) {
            $feedbackForm->setData($this->request->getPost());

            if ($feedbackForm->isValid()) {
                $feedback->setUser($this->identity());
                $feedback->setReferrer($this->getRequest()->getHeader('Referer')->uri()->getPath());

                // browser information
                $browser = new \Aditus\Helper\BrowserDetection();
                $feedback->setBrowserInformation($browser->__toString());

                $this->getEntityManager()->persist($feedback);
                $this->getEntityManager()->flush();

                // setup view
                $view = new ViewModel(array(
                    'feedback' => $feedback,
                    'feedbackForm' => $feedbackForm,
                ));
                $view->setTemplate('Aditus/feedback/modal/success');
                $view->setTerminal($this->request->isXmlHttpRequest());
                return $view;
            }
        }

        // setup view
        $view = new ViewModel(array(
            'feedbackForm' => $feedbackForm,
            'feedback' => $feedback,
        ));
        $view->setTemplate('Aditus/feedback/modal/edit');
        $view->setTerminal($this->request->isXmlHttpRequest());
        return $view;
    }
}

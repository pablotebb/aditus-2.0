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

class LoginController extends EntityUsingController
{
    public function registerAction()
    {
        // Create the form and inject the ObjectManager
        $registerForm = new \Aditus\Form\RegisterForm($this->getEntityManager());

        // create user
        $user = new \Aditus\Entity\Users();
        $registerForm->bind($user);

        // process form
        if( $this->request->isPost() ){
            $registerForm->setData($this->request->getPost());

            if( $registerForm->isValid() ){
                // save
                // $user->setAccount($account);
                $this->getEntityManager()->persist($user);
                $this->getEntityManager()->flush();

                $data = $this->request->getPost();

                // load auth service
                $authService = $this->getServiceLocator()->get('Zend\Authentication\AuthenticationService');

                // attempt to authenticate
                $adapter = $authService->getAdapter();
                $adapter->setIdentityValue($data['email']);
                $adapter->setCredentialValue($data['secret']);
                $authResult = $authService->authenticate();

                if ($authResult->isValid()) {
                    // display success view
                    $this->layout('layout/login');
                    $view = new ViewModel();
                    $view->setTemplate('Aditus/login/registerSuccess');
                    return $view;
                }

            }
        }

        // setup view
        $this->layout('layout/login');
        $view = new ViewModel(array(
            'registerForm' => $registerForm,
        ));
        return $view;
    }

    public function loginAction()
    {
        // Create the form and inject the ObjectManager
        $loginForm = new \Aditus\Form\LoginForm($this->getEntityManager());

        if ($this->request->isPost()) {
            $loginForm->setData($this->request->getPost());

            if ($loginForm->isValid()) {
                $data = $this->request->getPost();

                // load auth service
                $authService = $this->getServiceLocator()->get('Zend\Authentication\AuthenticationService');

                // attempt to authenticate
                $adapter = $authService->getAdapter();
                $adapter->setIdentityValue($data['email']);
                $adapter->setCredentialValue($data['secret']);
                $authResult = $authService->authenticate();

                if ($authResult->isValid()) {
                    // login successful - update user
                    $user = $this->identity();
                    $user->setSuccessfulLogin();
                    $this->getEntityManager()->persist($user);
                    $this->getEntityManager()->flush();

                    // redirect to portfolio
                    return $this->redirect()->toRoute($user->getAccount()->isAdmin() ? 'admin/dashboard' : 'portfolio');
                }
            }
        }

        // setup view
        $this->layout('layout/login');
        $view = new ViewModel(array(
            'loginForm' => $loginForm,
        ));
        return $view;
    }

    public function logoutAction()
    {
        $authService = $this->getServiceLocator()->get('Zend\Authentication\AuthenticationService');
        $authService->clearIdentity();

        return $this->redirect()->toRoute('login');
    }

}

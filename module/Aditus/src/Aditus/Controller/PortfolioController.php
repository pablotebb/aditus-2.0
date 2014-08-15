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
use Aditus\Form\CreateFundForm;
use Aditus\Form\CreateCompanyForm;
use Aditus\Form\FilterPortfolioForm;


class PortfolioController extends EntityUsingController
{
    public function indexAction()
    {
        // load assessment reporting periods
        $assessmentPeriods = $this->getEntityManager()->getRepository('\Aditus\Entity\Assessments')->getAssessmentPeriods($this->identity());
        // current assessment period
        if( !is_null($this->params('reportingYear')) ){
            $currentPeriod = array(
                'reportingYear' => $this->params('reportingYear'),
                'reportingPeriod' => $this->params('reportingPeriod')
            );
        } else {
            $currentPeriod = $assessmentPeriods[0];
        }

        // Create the form and inject the ObjectManager
        $filterForm = new FilterPortfolioForm($this->getEntityManager());
        $filterForm->get('industry')->get('id')->setAttribute('name', 'industryId')->setAttribute('required', false);
        $filterForm->get('country')->get('id')->setAttribute('name', 'countryId')->setAttribute('required', false);

        // set form defaults
        $filterForm->get('industry')->get('id')->setValue($this->params('industryId', 0));
        $filterForm->get('country')->get('id')->setValue($this->params('countryId', 0));
        $filterForm->get('groupBy')->setValue($this->params('groupBy', 'fund'));
        $filterForm->get('groupResult')->setValue($this->params('groupResult', 'average'));

        // create portfolio array        
        $portfolio = array(
            'groupBy' => $filterForm->get('groupBy')->getValue(),
            'groupResult' => $filterForm->get('groupResult')->getValue(),
        );
        $results = $this->getEntityManager()->getRepository('\Aditus\Entity\Accounts')->getPortfolioAssessments($this->identity(), $currentPeriod, $portfolio['groupBy'], $portfolio['groupResult'], (int) $this->params('industryId'), (int) $this->params('countryId'));
        $portfolio = array_merge($portfolio, $results);

        // load indicators
        $indicators = $this->getEntityManager()->getRepository('\Aditus\Entity\Indicators')->getDisplayIndicators( $this->identity() );

        // check for a valid portfolio
        if( empty($results['groups']) ){
            $view = new ViewModel();
            $view->setTemplate('Aditus/portfolio/empty');
            return $view;
        }

        // filter partial
        $filterView = new ViewModel(array(
            'filterForm' => $filterForm,
            'assessmentPeriods' => $assessmentPeriods,
            'currentPeriod' => $currentPeriod,
            'baseUrl' => $this->url()->fromRoute('portfolio'),
        ));
        $filterView->setTemplate('Aditus/portfolio/modal/filter');    

        // setup view
        $view = new ViewModel(array(
            'portfolio' => $portfolio,
            'indicators' => $indicators,
            'currentPeriod' => $currentPeriod,
        ));
        $view->addChild($filterView, 'filterView');
        return $view;
    }    

    public function fundAction()
    {
        if( $this->params('id') > 0 ){
            // check for fundId
            $fund = $this->getEntityManager()->find('\Aditus\Entity\Funds', $this->params('id'));
        } else {
            // Create a new, empty entity and bind it to the form
            $fund = new \Aditus\Entity\Funds();            
        }

        // Create the form and inject the ObjectManager
        $fundForm = new CreateFundForm($this->getEntityManager());
        $fundForm->bind($fund);

        if ($this->request->isPost()) {
            $fundForm->setData($this->request->getPost());

            if ($fundForm->isValid()) {
                $fund->setAccount($this->identity()->getAccount());
                $this->getEntityManager()->persist($fund);
                $this->getEntityManager()->flush();

                // setup view
                $view = new ViewModel(array(
                    'fund' => $fund,
                    'fundForm' => $fundForm,
                ));
                $view->setTemplate('Aditus/portfolio/modal/fundSuccess');
                $view->setTerminal($this->request->isXmlHttpRequest());
                return $view;
            }
        }

        // setup view
        $view = new ViewModel(array(
            'fundForm' => $fundForm,
            'fund' => $fund,
        ));
        $view->setTemplate('Aditus/portfolio/modal/fundEdit');
        $view->setTerminal($this->request->isXmlHttpRequest());
        return $view;
    }

    public function CompanyAction()
    {
        if( $this->params('id') > 0 ){
            // check for fundId
            $fund = $this->getEntityManager()->find('\Aditus\Entity\Funds', $this->params('id'));
            if( $this->params('companyId') > 0 ){
                // check for companyId
                $company = $this->getEntityManager()->find('\Aditus\Entity\Companies', $this->params('companyId'));
            } else {
                // create new
                $company = new \Aditus\Entity\Companies();
            }
        } else {
            // redirect to portfolio
            return $this->redirect()->toRoute('portfolio');
        }

        // Create the form and inject the ObjectManager
        $companyForm = new CreateCompanyForm($this->getEntityManager());
        $companyForm->bind($company);

        if ($this->request->isPost()) {
            $companyForm->setData($this->request->getPost());

            if ($companyForm->isValid()) {
                $company->setAccount($this->identity()->getAccount());
                $company->setFund($fund);

                // save
                $this->getEntityManager()->persist($company);
                $this->getEntityManager()->flush();

                // setup view
                $view = new ViewModel(array(
                    'company' => $company,
                    'companyForm' => $companyForm,
                ));
                $view->setTemplate('Aditus/portfolio/modal/companySuccess');
                $view->setTerminal($this->request->isXmlHttpRequest());
                return $view;
            }
        }

        // setup view
        $view = new ViewModel(array(
            'companyForm' => $companyForm,
            'fund' => $fund,
            'company' => $company,
        ));
        $view->setTemplate('Aditus/portfolio/modal/companyEdit');
        $view->setTerminal($this->request->isXmlHttpRequest());
        return $view;
    }

    public function CompanyDeleteAction()
    {
        // check for company
        $company = $this->getEntityManager()->find('\Aditus\Entity\Companies', $this->params('id'));
        $fund = $company->getFund();

        // Create the form and inject the ObjectManager
        $companyForm = new CreateCompanyForm($this->getEntityManager());
        $companyForm->bind($company);

        if ($this->request->isPost()) {
            // remove and save
            $this->getEntityManager()->remove($company);
            $this->getEntityManager()->flush();

            // setup view
            $view = new ViewModel(array(
                'fund' => $fund,
            ));
            $view->setTemplate('Aditus/portfolio/modal/companyDeleteSuccess');
            $view->setTerminal($this->request->isXmlHttpRequest());
            return $view;
        }

        // setup view
        $view = new ViewModel(array(
            'companyForm' => $companyForm,
            'fund' => $fund,
            'company' => $company,
        ));
        $view->setTemplate('Aditus/portfolio/modal/companyDelete');
        $view->setTerminal($this->request->isXmlHttpRequest());
        return $view;
    }    

    public function fundDeleteAction()
    {
        // check for fund
        $fund = $this->getEntityManager()->find('\Aditus\Entity\Funds', $this->params('id'));

        // Create the form and inject the ObjectManager
        $fundForm = new CreateFundForm($this->getEntityManager());
        $fundForm->bind($fund);

        if ($this->request->isPost()) {
            // remove companies
            foreach( $fund->getCompanies() as $company ){
                $this->getEntityManager()->remove($company);
            }

            // remove and save
            $this->getEntityManager()->remove($fund);
            $this->getEntityManager()->flush();

            // setup view
            $view = new ViewModel(array());
            $view->setTemplate('Aditus/portfolio/modal/fundDeleteSuccess');
            $view->setTerminal($this->request->isXmlHttpRequest());
            return $view;
        }

        // setup view
        $view = new ViewModel(array(
            'fundForm' => $fundForm,
            'fund' => $fund,
        ));
        $view->setTemplate('Aditus/portfolio/modal/fundDelete');
        $view->setTerminal($this->request->isXmlHttpRequest());
        return $view;
    }    
}

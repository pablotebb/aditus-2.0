<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Aditus;

return array(
    'router' => array(
        'routes' => array(
            'register' => array(
                'type'    => 'Segment',
                'options' => array(
                    'route'    => '/register[/:code]',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Aditus\Controller',
                        'controller'    => 'Login',
                        'action'        => 'register',                        
                    ),
                ),
            ),
            'login' => array(
                'type'    => 'Segment',
                'options' => array(
                    'route'    => '/login[/:action]',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Aditus\Controller',
                        'controller'    => 'Login',
                        'action'        => 'login',
                    ),
                ),
            ),
            'logout' => array(
                'type'    => 'Segment',
                'options' => array(
                    'route'    => '/logout',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Aditus\Controller',
                        'controller'    => 'Login',
                        'action'        => 'logout',
                    ),
                ),
            ),
            'home' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Aditus\Controller',
                        'controller'    => 'Portfolio',
                        'action'        => 'index',
                    ),
                ),
            ),
/*            'profile' => array(
                'type'    => 'Segment',
                'options' => array(
                    'route'    => '/profile',
                    'constraints'   => array(
                        'action'    => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'        => '[0-9]{0,24}',
                        'companyId' => '[0-9]{0,24}',
                    ),
                    'defaults' => array(
                        '__NAMESPACE__' => 'Aditus\Controller',
                        'controller'    => 'Account',
                        'action'        => 'profile',
                    ),
                ),
            ),
            'fund' => array(
                'type'    => 'Segment',
                'options' => array(
                    'route'    => '/fund[/:id][/:companyId]',
                    'constraints'   => array(
                        'action'    => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'        => '[0-9]{0,24}',
                        'companyId' => '[0-9]{0,24}',
                    ),
                    'defaults' => array(
                        '__NAMESPACE__' => 'Aditus\Controller',
                        'controller'    => 'Portfolio',
                        'action'        => 'fund',
                    ),
                ),
            ),
            'fund-delete' => array(
                'type'    => 'Segment',
                'options' => array(
                    'route'    => '/fund-delete[/:id]',
                    'constraints'   => array(
                        'action'    => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'        => '[0-9]{0,24}',
                    ),
                    'defaults' => array(
                        '__NAMESPACE__' => 'Aditus\Controller',
                        'controller'    => 'Portfolio',
                        'action'        => 'fundDelete',
                    ),
                ),
            ),
            'company' => array(
                'type'    => 'Segment',
                'options' => array(
                    'route'    => '/company[/:id][/:companyId]',
                    'constraints'   => array(
                        'action'    => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'        => '[0-9]{0,24}',
                        'companyId' => '[0-9]{0,24}',
                    ),
                    'defaults' => array(
                        '__NAMESPACE__' => 'Aditus\Controller',
                        'controller'    => 'Portfolio',
                        'action'        => 'company',
                    ),
                ),
            ),
            'company-delete' => array(
                'type'    => 'Segment',
                'options' => array(
                    'route'    => '/company-delete[/:id]',
                    'constraints'   => array(
                        'action'    => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'        => '[0-9]{0,24}',
                    ),
                    'defaults' => array(
                        '__NAMESPACE__' => 'Aditus\Controller',
                        'controller'    => 'Portfolio',
                        'action'        => 'companyDelete',
                    ),
                ),
            ),*/
            'portfolio' => array(
                'type'    => 'Segment',
                'options' => array(
                    'route'    => '/portfolio[/:reportingYear][/:reportingPeriod][/:industryId][/:countryId][/:groupBy][/:groupResult]',
                    'constraints'   => array(
                        'action'    => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'reportingYear' => '[0-9]{4}',
                    ),
                    'defaults' => array(
                        '__NAMESPACE__' => 'Aditus\Controller',
                        'controller'    => 'Portfolio',
                        'action'        => 'index',
                    ),
                ),
            ),
            /*
            'indicators' => array(
                'type'    => 'Segment',
                'options' => array(
                    'route'    => '/indicators[/:action][/:id][/:reportingYear][/:reportingPeriod][/:industryId][/:countryId][/:groupBy][/:groupResult]',
                    'constraints'   => array(
                        'action'    => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'reportingYear' => '[0-9]{4}',
                    ),
                    'defaults' => array(
                        '__NAMESPACE__' => 'Aditus\Controller',
                        'controller'    => 'Indicators',
                        'action'        => 'index',
                    ),
                ),
            ),
            'assessment' => array(
                'type'    => 'Segment',
                'options' => array(
                    'route'    => '/assessment[/:action][/:id][/:indicatorId]',
                    'constraints'   => array(
                        'action'    => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'        => '[0-9]{0,24}',
                        'indicatorId'  => '[0-9]{0,24}',
                    ),
                    'defaults' => array(
                        '__NAMESPACE__' => 'Aditus\Controller',
                        'controller'    => 'Assessment',
                        'action'        => 'index',
                    ),
                ),
            ),
            'create-report' => array(
                'type'    => 'Segment',
                'options' => array(
                    'route'    => '/create-report[/:fundId][/:reportingYear][/:reportingPeriod]',
                    'constraints'   => array(
                        'action'    => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'        => '[0-9]{0,24}',
                        'reportingYear' => '[0-9]{4}',
                    ),
                    'defaults' => array(
                        '__NAMESPACE__' => 'Aditus\Controller',
                        'controller'    => 'FundReport',
                        'action'        => 'create',
                    ),
                ),
            ),
            'fund-report' => array(
                'type'    => 'Segment',
                'options' => array(
                    'route'    => '/fund-report[/:action][/:id][/:category]',
                    'constraints'   => array(
                        'action'    => '[a-zA-Z][a-zA-Z0-9_-]*',
                    ),
                    'defaults' => array(
                        '__NAMESPACE__' => 'Aditus\Controller',
                        'controller'    => 'FundReport',
                        'action'        => 'edit',
                    ),
                ),
            ),
            */
            'feedback' => array(
                'type'    => 'Segment',
                'options' => array(
                    'route'    => '/feedback[/:action][/:id]',
                    'constraints'   => array(
                        'action'    => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'        => '[0-9]{0,24}',
                    ),
                    'defaults' => array(
                        '__NAMESPACE__' => 'Aditus\Controller',
                        'controller'    => 'Feedback',
                        'action'        => 'index',
                    ),
                ),
            ),            
            /*
            'support' => array(
                'type'    => 'Segment',
                'options' => array(
                    'route'    => '/support[/:action][/:id]',
                    'constraints'   => array(
                        'action'    => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'        => '[0-9]{0,24}',
                    ),
                    'defaults' => array(
                        '__NAMESPACE__' => 'Aditus\Controller',
                        'controller'    => 'Support',
                        'action'        => 'index',
                    ),
                ),
            ),            
            */
        ),
    ),
    /*
    'service_manager' => array(
        'abstract_factories' => array(
            'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
            'Zend\Log\LoggerAbstractServiceFactory',
        ),
        'aliases' => array(
            'translator' => 'MvcTranslator',
        ),
    ),
    'translator' => array(
        'locale' => 'en_US',
        'translation_file_patterns' => array(
            array(
                'type'     => 'gettext',
                'base_dir' => __DIR__ . '/../language',
                'pattern'  => '%s.mo',
            ),
        ),
    ),
    */
    'controllers' => array(
        'invokables' => array(
            'Aditus\Controller\Feedback' => 'Aditus\Controller\FeedbackController',
            'Aditus\Controller\Login' => 'Aditus\Controller\LoginController',
            'Aditus\Controller\Portfolio' => 'Aditus\Controller\PortfolioController',
        ),
    ),
    'controller_plugins' => array(
        'invokables' => array(
            'Highcharts'   => 'Aditus\Plugin\Highcharts',
        )
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
        'strategies' => array(
            'ViewJsonStrategy',
        ),
    ),    
    // Doctrine config
    'doctrine' => array(
        'driver' => array(
            __NAMESPACE__ . '_driver' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(__DIR__ . '/../src/' . __NAMESPACE__ . '/Entity')
            ),
            'orm_default' => array(
                'drivers' => array(
                    __NAMESPACE__ . '\Entity' => __NAMESPACE__ . '_driver',
                ),
            ),
        ),
        'configuration' => array(
            'orm_default' => array(
                'stringFunctions' => array(
                    'FIND_IN_SET' => 'DoctrineExtensions\Query\Mysql\FindInSet',
                ),
                'types' => array(
                    'simplearray' => 'Doctrine\DBAL\Types\SimpleArrayType',
                    // 'decimal' => 'Application\Types\CurrencyType',
                    // 'integer' => 'Application\Types\NumberType',
                ),
            ),
        ),
        'connection' => array(
            'orm_default' => array(
                'driverClass' => 'Doctrine\DBAL\Driver\PDOMySql\Driver',
                'doctrine_type_mappings' => array(
                     'enum' => 'string',
                 ),
                'params' => array(
                    'driverOptions' => array(
                        1002 => 'SET NAMES utf8'
                    )
                ),
            ),
        ),
        'authentication' => array(
            'orm_default' => array(
                'object_manager' => 'Doctrine\ORM\EntityManager',
                'identity_class' => __NAMESPACE__ . '\Entity\Users',
                'identity_property' => 'email',
                'credential_property' => 'secret',
/*
                'credential_callables' => function (Aditus\Entity\Users $user, $passwordGiven) {
                    $salt = $user->created;
                    $loop = round((strlen($salt)*3.1479)*653);
                    $string = trim($passwordGiven);
                    $password = str_replace('$6$rounds=' . $loop . '$' . substr($salt, 0, 16) . '$', '', crypt($string, '$6$rounds=' . $loop . '$' . substr($salt, 0, 16) . '$'));

                    return $password === $user->passwd;
                },
*/                
            ),
        ),
    ),
    'controller_plugins' => array(
        'invokables' => array(
            'Highcharts'   => 'Aditus\Plugin\Highcharts',
        )
    ),
    'view_helpers' => array(
        'invokables' => array(
            'Arr' => 'Aditus\Helper\Arr',
            'Num' => 'Aditus\Helper\Num',
        ),
    ),
);

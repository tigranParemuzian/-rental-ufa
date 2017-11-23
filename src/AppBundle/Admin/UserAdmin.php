<?php
/**
 * Created by PhpStorm.
 * User: aram
 * Date: 12/29/15
 * Time: 12:13 PM
 */

namespace AppBundle\Admin;

use AppBundle\Entity\User;
use Sonata\AdminBundle\Admin\AbstractAdmin as Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\RedirectResponse;


/**
 * Class UserAdmin
 * @package AppBundle\Admin
 */
class UserAdmin extends Admin
{



    private $roles;
    private $pass;

    public function __construct($code, $class, $baseControllerName)
    {
        parent::__construct($code, $class, $baseControllerName);


    }

    public function getRolesPerms(){
        $securityContext = $this->getConfigurationPool()->getContainer()->get('security.authorization_checker');

        if ($securityContext->isGranted('ROLE_MODERATOR') === true){
            $this->roles =  ['ROLE_CLIENT'=>'КЛИЕНТЫ'];
        }elseif ($securityContext->isGranted('ROLE_ADMIN') === true){
            $this->roles =  ['ROLE_CLIENT'=>'КЛИЕНТЫ', 'ROLE_MODERATOR'=>'МЕНЕДЖЕР'];
        }elseif($securityContext->isGranted('ROLE_SUPER_ADMIN') === true){
            $this->roles =  ['ROLE_CLIENT'=>'КЛИЕНТЫ', 'ROLE_MODERATOR'=>'МЕНЕДЖЕР', 'ROLE_ADMIN'=>'Admin'];

        };

        return $this->roles;
    }
//    /**
//     * @return \Symfony\Component\Form\FormBuilder
//     */
//    public function getFormBuilder()
//    {
//        $this->formOptions['data_class'] = $this->getClass();
//
//        $options = $this->formOptions;
//        $options['validation_groups'] = "Admin";
//
//        $formBuilder = $this->getFormContractor()->getFormBuilder( $this->getUniqid(), $options);
//
//        $this->defineFormBuilder($formBuilder);
//
//        return $formBuilder;
//    }

//    public function prePersist($object)
//    {
//        parent::prePersist($object);
//
//        $object->addRole("ROLE_ADMIN");
//        $object->addRole("ROLE_SUPER_ADMIN");
//        $object->addRole("ROLE_SONATA_ADMIN");
//
//        $this->updatePassword($object);
//    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $this->getRolesPerms();
        $datagridMapper
            ->add('id')
            ->add('email')
            ->add('username')
            ->add('lastName')
            ->add('firstName')
            ->add('enabled')
            ->add('phone')
            ->add('roles', 'doctrine_orm_string', array(), 'choice', array(
                'choices'  => array(),
            ))
            ->add('created', 'doctrine_orm_datetime_range', array(),'sonata_type_datetime_range_picker',
                array('field_options_start' => array('format' => 'yyyy-MM-dd HH:mm:ss'),
                    'field_options_end' => array('format' => 'yyyy-MM-dd HH:mm:ss'))
            )
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('email')
            ->add('username', null, ['label'=>'Phone'])
            ->add('lastName')
            ->add('firstName')
//            ->add('phone')
            ->add('roles', 'choice', array(
                'choices'  => $this->getRolesPerms(),
                'multiple' => true,
                'template' => 'AppBundle:CRUD:user_roles_list.html.twig')
            )
            ->add('enabled', null, array('editable'=>true))
//            ->add('created')
            ->add('_action', 'actions', array(
                'actions' => array(
                    'show' => array(),
                    'edit' => array(),
                    'delete' => array(),
                )
            ))
        ;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {

        // get container
        $container = $this->getConfigurationPool()->getContainer();

        $roles = $container->getParameter('security.role_hierarchy.roles');

//        dump($roles); exit;

        $formMapper
            ->with('admin.witget.main', array(
                'class' =>'col-sm-3',
                'box-class' => 'box box-solid box-danger',
               /* 'description'=>'Products main create part'*/
            ))
            ->add('firstName', 'text', ['label'=>'Имя'])
            ->add('lastName', 'text', ['label'=>'Last Name'])
            ->add('patronymic', 'text', ['label'=>'Patronymic'])
            ->add('email')
            ->add('username', 'text', ['label'=>'Phone'])
            ->end()
            ->with('admin.witget.finance', array(
                'class' =>'col-sm-3',
                'box-class' => 'box box-solid box-danger'/*,
                'description'=>'Products main create part'*/
            ))
            ->add('contract')
            ->add('contractCost')
            ->add('paymentDate','sonata_type_date_picker', array(
                'dp_side_by_side'       => false,
                'dp_use_current'        => false,
                'widget' => 'single_text',
                'format' => 'y-dd-MM',
                'required' => false,
                'label'=>'SUP date',
                'attr'=>['style' => 'width: 100px !important']
            ))
            ->end()
            ->with('admin.witget.settings', array(
                'class' =>'col-sm-3',
                'box-class' => 'box box-solid box-danger'/*,
                'description'=>'Products main create part'*/
            ))
            ->add('databasePermission')
            ->add('inhabited')
            ->add('sentPassword')
            ->add('enabled')
            ->add('problematic')
            ->end()
            ->with('admin.witget.intersts', array(
                'class' =>'col-sm-3',
                'box-class' => 'box box-solid box-danger'/*,
                'description'=>'Products main create part'*/
            ))
            ->add('types')
            ->add('priceFrom')
            ->add('regions')
            ->add('priceTo')
            ->add('roles', 'choice', array(
                'choices'  => $this->getRolesPerms(),
                'multiple' => true
            ))
            ->add('plainPassword', 'repeated', array('first_name' => 'password',
                'required' => false,
                'second_name' => 'confirm',
                'type' => 'password',
                'invalid_message' => 'Passwords do not match',
                'first_options' => array('label' => 'Password'),
                'second_options' => array('label' => 'Repeat Password')))
            ->end()
        ;
    }

    protected $formOptions = array(
        'cascade_validation' => true
    );

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('id')
            ->add('email')
            ->add('phone')
            ->add('username')
            ->add('lastName')
            ->add('firstName')
        ;
    }

    public function preUpdate($object)
    {
        parent::preUpdate($object);

        $this->updatePassword($object);
        $object->setPhone($object->getUsername());


        if($object->getRegions()){
            foreach ($object->getRegions() as $rg){
                $rg->setUser($object);
            }
        }

        if($object->getTypes()){
            foreach ($object->getTypes() as $rg){
                $rg->setUser($object);
            }
        }


    }

    public function prePersist($object)
    {
        parent::prePersist($object);

        $this->pass = $object->getPlainPassword();

        $this->updatePassword($object);
        $object->setPhone($object->getUsername());

        $message = "http://rental-ufa.Ru %0A Login: {$object->getUsername()} %0A Password: ".$this->pass ;
        $url = "http://smsc.ru/sys/send.php?login=tigran2006&psw=aa2009aa&phones={$object->getUsername()}&mes={$message}";
        $t = file_get_contents($url);

        $log = $this->getConfigurationPool()->getContainer()->get('monolog.logger.command_create');

        $log->info($t);

        if($object->getRegions()){
            foreach ($object->getRegions() as $rg){
                $rg->setUser($object);
            }
        }

        if($object->getTypes()){
            foreach ($object->getTypes() as $rg){
                $rg->setUser($object);
            }
        }
    }

    /**
     * @param $object
     */
    private function updatePassword(User $object)
    {
        // get user manager
        $um = $this->getConfigurationPool()->getContainer()->get('fos_user.user_manager');

        // get plain password
        $plainPassword = $object->getPlainPassword();

        if($plainPassword){
            // update user
            $um->updateUser($object, false);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getExportFormats()
    {
        return array(
            'xls'
        );
    }

    /**
     * @return array
     */
    public function getExportFields()
    {
        return array(
            'id' => 'id',
            'Username' => 'username',
            'Last Name' => 'lastName',
            'First Name' => 'firstName',
        );
    }

    /**
     * @return
     */
    public function getDataSourceIterator()
    {
        $datagrid = $this->getDatagrid();
        $datagrid->buildPager();

        return $this->getModelManager()->getDataSourceIterator($datagrid, $this->getExportFields());
    }

    /**
     * This function
     * @param string $context
     * @return \Sonata\AdminBundle\Datagrid\ProxyQueryInterface
     */
    public function createQuery($context = 'list')
    {

        $query = parent::createQuery($context);

        $securityContext = $this->getConfigurationPool()->getContainer()->get('security.authorization_checker');


        $query->andWhere(
            $query->expr()->eq($query->getRootAliases()[0] . '.enabled', ':st')
        );

        if ($securityContext->isGranted('ROLE_MODERATOR') === true){

            $query->andWhere(
                $query->expr()->orX(
                    $query->expr()->like($query->getRootAliases()[0] . '.roles', ':rls1')
                )
            );
            $query->setParameter('rls1', '%ROLE_CLIENT%');

        }elseif ($securityContext->isGranted('ROLE_ADMIN') === true){

            $query->andWhere(
                $query->expr()->orX(
                    $query->expr()->like($query->getRootAliases()[0] . '.roles', ':rls1'),
                    $query->expr()->like($query->getRootAliases()[0] . '.roles', ':rls2')
                )
            );
            $query->setParameter('rls1', '%ROLE_CLIENT%');
            $query->setParameter('rls2', '%ROLE_MODERATOR%');


        }elseif($securityContext->isGranted('ROLE_SUPER_ADMIN') === true) {
            $query->andWhere(
                $query->expr()->orX(
                    $query->expr()->like($query->getRootAliases()[0] . '.roles', ':rls1'),
                    $query->expr()->like($query->getRootAliases()[0] . '.roles', ':rls2'),
                    $query->expr()->like($query->getRootAliases()[0] . '.roles', ':rls3')
                )
            );
            $query->setParameter('rls1', '%ROLE_CLIENT%');
            $query->setParameter('rls2', '%ROLE_MODERATOR%');
            $query->setParameter('rls3', '%ROLE_ADMIN%');
        };

        $query->setParameter('st', true);
        return $query;
    }
}
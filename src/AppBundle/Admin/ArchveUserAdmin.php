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
class ArchveUserAdmin extends Admin
{


    protected $baseRoutePattern = 'user-old';
    protected $baseRouteName = 'user-old';

    /**
     * @param RouteCollection $collection
     */
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->clearExcept(array('list'));
    }


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
            ->add('id',null,['label'=>'admin.user.id'])
            ->add('email',null,['label'=>'admin.user.email'])
            ->add('username', null, ['label'=>'admin.user.phone'])
            ->add('lastName', null, ['label'=>'admin.user.lastName'])
            ->add('firstName', null, ['label'=>'admin.user.firstName'])
            ->add('enabled',null,['label'=>'admin.user.enabled'])
            ->add('phone',null,['label'=>'admin.user.phone'])
            /*->add('roles', 'doctrine_orm_string', ['label'=>'admin.user.roles'], 'choice', array(
                'choices'  => array(),
            ))*/
            ->add('created', 'doctrine_orm_datetime_range',['label'=>'admin.user.created'],'sonata_type_datetime_range_picker',
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
        $securityContext = $this->getConfigurationPool()->getContainer()->get('security.authorization_checker');

        $listMapper
            ->addIdentifier('id', null, ['label'=>'admin.user.id'])
            ->add('updated', 'date', [])
            ->add('lastName', null, ['label'=>'admin.user.lastName', 'template'=>'AppBundle:CRUD:fio_admin_list.html.twig'])
            ->add('username', null, ['label'=>'admin.user.phone'])
            ->add('enabled', null, array('editable'=>true, 'label'=>'admin.user.enabled'));
        if($securityContext->isGranted('ROLE_ADMIN') === true) {

            $listMapper
            ->add('patronymic', null, ['template'=>'AppBundle:CRUD:rm_object_archive.html.twig', 'label'=>'rm'])
        ;
        }
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
            ->add('firstName', 'text', ['label'=>'admin.user.firstName'])
            ->add('lastName', 'text', ['label'=>'admin.user.lastName'])
            ->add('patronymic', 'text', ['label'=>'admin.user.patronymic'])
            ->add('email', null, ['label'=>'admin.user.email'])
            ->add('username', 'text', ['label'=>'admin.user.username'])
            ->end()
            ->with('admin.witget.finance', array(
                'class' =>'col-sm-3',
                'box-class' => 'box box-solid box-danger'/*,
                'description'=>'Products main create part'*/
            ))
            ->add('contract', 'text', ['label'=>'admin.user.contract'])
            ->add('contractCost', 'text', ['label'=>'admin.user.contract_cost'])
            ->add('paymentDate','sonata_type_date_picker', array(
                'dp_side_by_side'       => false,
                'dp_use_current'        => false,
                'widget' => 'single_text',
                'format' => 'y-dd-MM',
                'required' => false,
                'label'=>'admin.user.contract_date',
                'attr'=>['style' => 'width: 100px !important']
            ))
            ->end()
            ->with('admin.witget.settings', array(
                'class' =>'col-sm-3',
                'box-class' => 'box box-solid box-danger'/*,
                'description'=>'Products main create part'*/
            ))
            ->add('databasePermission', null, ['label'=>'admin.user.database_permission'])
            ->add('inhabited', null, ['label'=>'admin.user.inhabited'])
            ->add('sentPassword', null, ['label'=>'admin.user.sent_password'])
            ->add('enabled', null, ['label'=>'admin.user.enabled'])
            ->add('problematic', null, ['label'=>'admin.user.problematic'])
            ->end()
            ->with('admin.witget.intersts', array(
                'class' =>'col-sm-3',
                'box-class' => 'box box-solid box-danger'/*,
                'description'=>'Products main create part'*/
            ))
            ->add('types', null, ['label'=>'admin.user.types'])
            ->add('priceFrom', null, ['label'=>'admin.user.price_from'])
            ->add('regions', null, ['label'=>'admin.user.regions'])
            ->add('priceTo', null, ['label'=>'admin.user.price_to'])
            /*->add('roles', 'choice', array(
                'choices'  => $this->getRolesPerms(),
                'multiple' => true,
                'label'=>'admin.user.roles'
            ))*/
            ->add('plainPassword', 'repeated', array('first_name' => 'password',
                'required' => false,
                'second_name' => 'confirm',
                'type' => 'password',
                'invalid_message' => 'Passwords do not match',
                'first_options' => array('label' => 'admin.user.first_options'),
                'second_options' => array('label' => 'admin.user.second_options')))
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
            ->add('id',null,['label'=>'admin.user.id'])
            ->add('email',null,['label'=>'admin.user.email'])
            ->add('username', null, ['label'=>'admin.user.phone'])
            ->add('lastName', null, ['label'=>'admin.user.lastName'])
            ->add('firstName', null, ['label'=>'admin.user.firstName'])
            ->add('phone',null,['label'=>'admin.user.phone'])
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


        $query->setParameter('st', false);

        return $query;
    }
}
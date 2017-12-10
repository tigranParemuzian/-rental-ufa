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
 * Class ManagerAdmin
 * @package AppBundle\Admin
 */
class ManagerAdmin extends Admin
{



    private $roles;
    private $pass;
    private $container;

    protected $baseRoutePattern = 'manager';
    protected $baseRouteName = 'manager';

    public function __construct($code, $class, $baseControllerName, $container = null)
    {
        parent::__construct($code, $class, $baseControllerName);

        $this->container  =$container;

    }

    public function getRolesPerms(){
        $securityContext = $this->container->get('security.authorization_checker');

        $translator = $this->container->get('translator');


        if ($securityContext->isGranted('ROLE_MODERATOR') === true){
            $this->roles =  ['ROLE_CLIENT'=>$translator->trans('admin.user.clients')];
        }

        if ($securityContext->isGranted('ROLE_ADMIN') === true){
            $this->roles =  ['ROLE_CLIENT'=>$translator->trans('admin.user.clients'), 'ROLE_MODERATOR'=>$translator->trans('admin.user.manager')];
        }

        if($securityContext->isGranted('ROLE_SUPER_ADMIN') === true){
            $this->roles =  ['ROLE_CLIENT'=>$translator->trans('admin.user.clients'), 'ROLE_MODERATOR'=>$translator->trans('admin.user.manager'), 'ROLE_ADMIN'=>$translator->trans('admin.user.admin')];

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
//            ->add('email',null,['label'=>'admin.user.email'])
            ->add('username', null, ['label'=>'admin.user.phone'])
            ->add('lastName', null, ['label'=>'admin.user.lastName'])
            ->add('firstName', null, ['label'=>'admin.user.firstName'])
            ->add('enabled',null,['label'=>'admin.user.enabled'])
            ->add('phone',null,['label'=>'admin.user.phone'])
            /*->add('roles', 'doctrine_orm_string', ['label'=>'admin.user.roles'], 'choice', array(
                'choices'  => $this->roles,
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
        $listMapper
            ->addIdentifier('id', null, ['label'=>'admin.user.id'])
            ->add('updated', 'date')
            ->add('username', null, ['label'=>'admin.user.username'])
            ->add('lastName', null, ['label'=>'admin.user.lastName'])
            ->add('firstName', null, ['label'=>'admin.user.firstName'])
//            ->add('phone')
            // Output for value `http://example.com`:
            // `<a href="http://example.com">http://example.com</a>`

//            ->add('roles',
//
//                'choice', [
//                'choices'  => $this->getRolesPerms(),
//               'multiple' => true,
//                     'template' => 'AppBundle:CRUD:user_roles_list.html.twig'
//                ]
//                /**/
////                )
//            )
            ->add('enabled', null, array('editable'=>true, 'label'=>'admin.user.enabled'))
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


        $securityContext = $this->container->get('security.authorization_checker');

        $formMapper
            ->with('admin.witget.main', array(
                'class' =>'col-sm-6',
                'box-class' => 'box box-solid box-danger',
               /* 'description'=>'Products main create part'*/
            ))
            ->add('firstName', 'text', ['label'=>'admin.user.firstName'])
            ->add('lastName', 'text', ['label'=>'admin.user.lastName'])
            ->add('patronymic', 'text', ['label'=>'admin.user.patronymic'])
//            ->add('email', null, ['label'=>'admin.user.email'])


            ->end()
            ->with('admin.witget.settings', array(
                'class' =>'col-sm-6',
                'box-class' => 'box box-solid box-danger'/*,
                'description'=>'Products main create part'*/
            ))
            ->add('username', 'text', ['label'=>'admin.user.phone'])
            ->add('plainPassword', 'repeated', array('first_name' => 'password',
                'required' => false,
                'second_name' => 'confirm',
                'type' => 'password',
                'invalid_message' => 'Passwords do not match',
                'first_options' => array('label' => 'admin.user.first_options'),
                'second_options' => array('label' => 'admin.user.second_options')))
            ->add('enabled', null, ['label'=>'admin.user.enabled'])
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
//            ->add('email',null,['label'=>'admin.user.email'])
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

    }

   /* public function postRemove($object)
    {
        parent::preRemove($object);

        if(!$object->getRegions()->isEmpty()){
            foreach ($)
        }
        $this->updatePassword($object);
        $object->setPhone($object->getUsername());

    }*/

    public function prePersist($object)
    {
        parent::prePersist($object);


        $object->setRoles(['ROLE_MODERATOR']);


        $object->setEmail($object->getUsername() . '@rental-ufa.ru');

        $this->updatePassword($object);
        $object->setPhone($object->getUsername());
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

        $securityContext = $this->container->get('security.authorization_checker');


        $query->andWhere(
            $query->expr()->eq($query->getRootAliases()[0] . '.enabled', ':st')
        );

        if ($securityContext->isGranted('ROLE_ADMIN') === true){

            $query->andWhere(
                /*$query->expr()->orX(*/
                    $query->expr()->like($query->getRootAliases()[0] . '.roles', ':rls1')
                /*)*/
            );
            $query->setParameter('rls1', '%ROLE_MODERATOR%');
        }

        $query->setParameter('st', true);
        return $query;
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: tigran
 * Date: 2/20/17
 * Time: 4:19 PM
 */

namespace AppBundle\Admin;


use AppBundle\Entity\Ads;
use Sonata\AdminBundle\Admin\AbstractAdmin as Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;

class AdsAdmin extends Admin
{
    protected $renovation;
    protected $state;
    protected $container;


    protected $datagridValues = array(
        '_page' => 1,
        '_sort_order' => 'DESC', // sort direction
        '_sort_by' => 'created' // field name
    );

    public function __construct($code, $class, $baseControllerName, $container = null)
    {
        parent::__construct($code, $class, $baseControllerName);


        $this->container = $container;
        $translator = $this->container->get('translator');

        $this->renovation = [$translator->trans('admin.ads.euro'),
            $translator->trans('admin.ads.cosmo'),
            $translator->trans('admin.ads.good'),
            $translator->trans('admin.ads.regular')
            ];
        $this->state = [Ads::IS_SHOW=>$translator->trans('admin.ads.showcase'),
            Ads::IS_ARCHIVE=>$translator->trans('admin.ads.archive')];
    }

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
//            ->tab('admin.witget.main')
            ->with('admin.witget.main', array(
                'class' => 'col-sm-6',
                'box-class' => 'box box-solid box-danger'
            ))
                ->add('firstName', 'text', ['label'=>'admin.ads.fio'])
                ->add('phone', 'text', ['label'=>'admin.ads.phone'])
                ->add('price', 'text', ['label'=>'admin.ads.price'])
                ->add('state', 'choice', ['choices'=>$this->state, 'label'=>'admin.ads.state'])
            ->add('region', null, ['label'=>'admin.ads.region'])
            ->add('types', null, ['label'=>'admin.ads.types'])
                ->add('description','textarea', ['label'=>'admin.ads.description'])
            ->end()
            ->with('admin.witget.parent', array(
                'class' => 'col-sm-6',
                'box-class' => 'box box-solid box-danger'
            ))
                ->add('street', 'text', ['label'=>'admin.ads.street'])
                ->add('house', 'text', ['label'=>'admin.ads.house'])
                ->add('kb', 'text', ['label'=>'admin.ads.kb', 'required'=>false])
                ->add('sqMeter', 'text', ['label'=>'admin.ads.sqMeter', 'required'=>false])
                ->add('renovation', 'choice', ['choices'=>$this->renovation, 'label'=>'admin.ads.renovation'])
                ->add('furnisher', null, ['label'=>'admin.ads.furnisher'])
                ->add('notAvalible', null, ['label'=>'admin.ads.notAvalible'])
                ->add('notConnected', null, ['label'=>'admin.ads.notConnected'])
            ->end()
        ;

    }

    /**
     * @param ListMapper $list
     */
    protected function configureListFields(ListMapper $list)
    {
        $securityContext = $this->container->get('security.authorization_checker');

        if($securityContext->isGranted('ROLE_MODERATOR') === true || $securityContext->isGranted('ROLE_ADMIN') === true){
            $list
                ->add('updated','date');
        }

        $list
            ->add('street', 'text', ['label'=>'admin.ads.object', 'template'=>'AppBundle:CRUD:address_list.html.twig'])
            ->add('types', null, ['label'=>'admin.ads.types'])
            ->add('price', null, ['label'=>'admin.ads.price', 'editable'=>true])
            ->add('phone', null, ['label'=>'admin.ads.phone', 'editable'=>true])
        ;

        if($securityContext->isGranted('ROLE_MODERATOR') === true || $securityContext->isGranted('ROLE_ADMIN') === true){
            $list
                ->add('state', 'choice', ['choices'=>$this->state,
                    'label'=>'admin.ads.state', 'editable'=>true]);
        }

        $list
            ->add('furnisher', null, ['label'=>'admin.ads.furnisher', 'editable'=>true])
        ;

        if($securityContext->isGranted('ROLE_MODERATOR') === true || $securityContext->isGranted('ROLE_ADMIN') === true){

            $list
//                ->add('author.clientFullName', null, ['label'=>'admin.user.managerList'])
                ->add('notAvalible', null, ['label'=>'admin.ads.notAvalible', 'editable'=>true])
                ->add('notConnected', null, ['label'=>'admin.ads.notConnected', 'editable'=>true])
            ;
        }

        $list
            ->add('id', null, ['label'=>'admin.ads.id'])
            ->add('_action', 'actions',
                array('actions' =>
                    array(
                       'show' => array(), 'edit'=>array(), 'delete'=>[]
                    ),
                    'label'=>'admin.types.action'
                ))
                    ;

    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $securityContext = $this->container->get('security.authorization_checker');

        if($securityContext->isGranted('ROLE_MODERATOR') === true || $securityContext->isGranted('ROLE_ADMIN') === true) {

            $datagridMapper
                /*->add('notAvalible', null, ['label'=>'admin.ads.notAvalible', 'editable'=>true])
                ->add('notConnected', null, ['label'=>'admin.ads.notConnected', 'editable'=>true])
                ->add('updated', 'doctrine_orm_date_range', array(), 'sonata_type_date_range_picker',
                    array('field_options_start' => array('format' => 'yyyy-MM-dd'),
                        'field_options_end' => array('format' => 'yyyy-MM-dd'))
                )*/
                ;
        }

            $datagridMapper
            ->add('id')

            ->add('price', 'doctrine_orm_number_range', ['label'=>'admin.ads.price', 'editable'=>true])
            /*->add('state', 'doctrine_orm_choice', ['label' => 'admin.ads.state'], 'choice', ['choices'=>$this->state, 'expanded' => true,
        'multiple' => true])
            ->add('firstName', null, ['label'=>'admin.ads.fio', 'editable'=>true])
            ->add('phone', null, ['label'=>'admin.ads.phone', 'editable'=>true])
            ->add('street', null, ['label'=>'admin.ads.street', 'editable'=>true])
            ->add('house', null, ['label'=>'admin.ads.house', 'editable'=>true])
            ->add('kb', null, ['label'=>'admin.ads.kb', 'editable'=>true])
            ->add('sqMeter', null, ['label'=>'admin.ads.sqMeter', 'editable'=>true])
            ->add('renovation', 'doctrine_orm_choice',['label'=>'admin.ads.renovation'],'choice', ['choices'=>$this->renovation,  'expanded' => true,  'multiple' => true])
            ->add('furnisher', null, ['label'=>'admin.ads.furnisher', 'editable'=>true])*/
            ->add('region', null, ['label'=>'admin.ads.region'], null, ['multiple'=>true])
            ->add('types', null, ['label'=>'admin.ads.types'], null, ['multiple'=>true])

        ;
    }

    /**
     * @param ShowMapper $show
     */
    protected function configureShowFields(ShowMapper $show)
    {

        $securityContext = $this->container->get('security.authorization_checker');

        $show
            ->with('admin.witget.main', array(
                'class' => 'col-sm-12',
                'box-class' => 'box box-solid box-danger',
                'description' => 'admin.witget.main_descr'
            ));
        if($securityContext->isGranted('ROLE_MODERATOR') === true || $securityContext->isGranted('ROLE_ADMIN') === true){

            $show
                ->add('notAvalible', null, ['label'=>'admin.ads.notAvalible'])
                ->add('notConnected', null, ['label'=>'admin.ads.notConnected'])
            ;
        }

        $show
            ->add('id')
            ->add('price', null, ['label'=>'admin.ads.price'])
            ->add('firstName', null, ['label'=>'admin.ads.fio'])
            ->add('phone', null, ['label'=>'admin.ads.phone'])
            ->add('description','textarea', ['label'=>'admin.ads.description'])
            ->add('street', null, ['label'=>'admin.ads.street'])
            ->add('house', null, ['label'=>'admin.ads.house'])
            ->add('kb', null, ['label'=>'admin.ads.kb'])
            ->add('sqMeter', null, ['label'=>'admin.ads.sqMeter'])
            ->add('renovation', 'choice', ['choices'=>$this->renovation, 'label'=>'admin.ads.renovation'])
            ->add('furnisher', null, ['label'=>'admin.ads.furnisher'])
            ->add('region', null, ['label'=>'admin.ads.region'])
            ->add('types', null, ['label'=>'admin.ads.types'])
        ->end()
        ;

    }

    /**
     * This function
     * @param string $context
     * @return \Sonata\AdminBundle\Datagrid\ProxyQueryInterface
     */
    public function createQuery($context = 'list')
    {

        $query = parent::createQuery($context);

        /**
         * get User
         */
        $user = $this->container->get('security.token_storage')->getToken()->getUser();

        /**
         * get Role current user
         */
        $securityContext = $this->container->get('security.authorization_checker');

        /**
         * check user is client
         * todo: only for client
         */
        if($securityContext->isGranted('ROLE_CLIENT') === true){

            $em = $this->container->get('doctrine')->getManager();

            $user = $em->getRepository('AppBundle:User')->findSingle($user->getId())[0];

            $regions = [];
            if(!($user->getRegions()->isEmpty())){
                foreach ($user->getRegions() as $region){

                    $regions[]=$region->getId();

                }

                $query->andWhere(
                    $query->expr()->in($query->getRootAliases()[0] . '.region', ':rg')
                );
                $query->setParameter('rg', $regions);

            }

            $types = [];

            if(!($user->getTypes()->isEmpty())){
                foreach ($user->getTypes() as $region){

                    $types[]=$region->getId();

                }

                $query->andWhere(
                    $query->expr()->in($query->getRootAliases()[0] . '.types', ':tp')
                );
                $query->setParameter('tp', $types);

            }



            if((int)$user->getPriceFrom() >0){
                $query->andWhere(
                    $query->expr()->gte($query->getRootAliases()[0] . '.price', ':min')
                );
                $query->setParameter('min', (int)$user->getPriceFrom());
            }
            if((int)$user->getPriceTo() >0) {
                $query->andWhere(
                    $query->expr()->lte($query->getRootAliases()[0] . '.price', ':max')
                );
                $query->setParameter('max', (int)$user->getPriceTo());
            }

        }

        $query->andWhere(
            $query->expr()->in($query->getRootAliases()[0] . '.state', ':st')
        );
        $query->setParameter('st', [Ads::IS_SHOW, Ads::IS_DONE]);



        return $query;
    }

    public function prePersist($object){

        $user = $this->container->get('security.token_storage')->getToken()->getUser();

       $object->setAuthor($user);

    }

//    public function preUpdate($object){
//
//
//        $user = $this->container->get('security.token_storage')->getToken()->getUser();
//
//        $object->setAuthor($user);
//
//    }
}
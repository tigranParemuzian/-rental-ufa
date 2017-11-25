<?php
/**
 * Created by PhpStorm.
 * User: tigran
 * Date: 2/20/17
 * Time: 4:19 PM
 */

namespace AppBundle\Admin;


use AppBundle\Entity\Ads;
use AppBundle\Entity\Parameter;
use Sonata\AdminBundle\Admin\AbstractAdmin as Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;

class OldAdsAdmin extends Admin
{

    protected $baseRoutePattern = 'ads-old';
    protected $baseRouteName = 'ads-old';

    /**
     * @param RouteCollection $collection
     */
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->clearExcept(array('list'));
    }

    protected $renovation;
    protected $state;

    public function __construct($code, $class, $baseControllerName)
    {
        parent::__construct($code, $class, $baseControllerName);
        $this->renovation = ['Евро', 'Косметический', 'Хороший'];
        $this->state = [Ads::IS_SHOW=>'ПОКАЗ', Ads::IS_ARCHIVE=>'АРХИВ', Ads::IS_DONE=>'СДАН'];
    }

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('admin.witget.main', array(
                'class' => 'col-sm-6',
                'box-class' => 'box box-solid box-danger'
                /*'description' => 'admin.witget.main_descr'*/
            ))
            ->add('firstName', 'text', ['label'=>'admin.ads.firstName'])
            ->add('lastName', 'text', ['label'=>'admin.ads.lastName'])
            ->add('fatherName','text', ['label'=>'admin.ads.fatherName'])
            ->add('phone', 'text', ['label'=>'admin.ads.phone'])
            ->add('price', 'text', ['label'=>'admin.ads.price'])
            ->add('state', 'choice', ['choices'=>$this->state, 'label'=>'admin.ads.state'])
            ->add('description','textarea', ['label'=>'admin.ads.description'])
            ->end()
            ->with('admin.witget.parent', array(
                'class' => 'col-sm-6',
                'box-class' => 'box box-solid box-danger'
                /*'description' => 'admin.witget.main_descr'*/
            ))

            ->add('region', null, ['label'=>'admin.ads.region'])
            ->add('types', null, ['label'=>'admin.ads.types'])
            ->add('street', 'text', ['label'=>'admin.ads.street'])
            ->add('house', 'text', ['label'=>'admin.ads.house'])
            ->add('kb', 'text', ['label'=>'admin.ads.kb'])
            ->add('sqMeter', 'text', ['label'=>'admin.ads.sqMeter'])
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

        $list
            ->add('id')
            ->add('price', null, ['label'=>'admin.ads.price', 'editable'=>true])
            ->add('state', 'choice', ['choices'=>$this->state, 'label'=>'admin.ads.state', 'editable'=>true])
            ->add('firstName', null, ['label'=>'admin.ads.firstName', 'editable'=>true])
            ->add('lastName', null, ['label'=>'admin.ads.lastName', 'editable'=>true])
            ->add('fatherName',null, ['label'=>'admin.ads.fatherName', 'editable'=>true])
            ->add('phone', null, ['label'=>'admin.ads.phone', 'editable'=>true])
            ->add('description','textarea', ['label'=>'admin.ads.description', 'editable'=>true])
            ->add('street', 'text', ['label'=>'admin.ads.street', 'editable'=>true])
            ->add('house', 'text', ['label'=>'admin.ads.house', 'editable'=>true])
            ->add('kb', null, ['label'=>'admin.ads.kb', 'editable'=>true])
            ->add('sqMeter', null, ['label'=>'admin.ads.sqMeter', 'editable'=>true])
            ->add('renovation', 'choice', ['choices'=>$this->renovation, 'label'=>'admin.ads.renovation', 'editable'=>true])
            ->add('furnisher', null, ['label'=>'admin.ads.furnisher', 'editable'=>true])
            ->add('region', null, ['label'=>'admin.ads.region'])
            ->add('types', null, ['label'=>'admin.ads.types'])
            ->add('notAvalible', null, ['label'=>'admin.ads.notAvalible', 'editable'=>true])
            ->add('notConnected', null, ['label'=>'admin.ads.notConnected', 'editable'=>true])
            /*->add('_action', 'actions',
                array('actions' =>
                    array(
                        'delete' => array(), 'edit' => array()
                    )
                ))*/;

    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id')
            ->add('price', null, ['label'=>'admin.ads.price', 'editable'=>true])
            ->add('state', 'doctrine_orm_choice', ['label' => 'admin.ads.state'], 'choice', ['choices'=>$this->state, 'expanded' => true,
                'multiple' => true])
            ->add('firstName', null, ['label'=>'admin.ads.firstName', 'editable'=>true])
            ->add('lastName', null, ['label'=>'admin.ads.lastName', 'editable'=>true])
            ->add('fatherName',null, ['label'=>'admin.ads.fatherName', 'editable'=>true])
            ->add('phone', null, ['label'=>'admin.ads.phone', 'editable'=>true])
            ->add('street', null, ['label'=>'admin.ads.street', 'editable'=>true])
            ->add('house', null, ['label'=>'admin.ads.house', 'editable'=>true])
            ->add('kb', null, ['label'=>'admin.ads.kb', 'editable'=>true])
            ->add('sqMeter', null, ['label'=>'admin.ads.sqMeter', 'editable'=>true])
            ->add('renovation', 'doctrine_orm_choice',['label'=>'admin.ads.renovation'],'choice', ['choices'=>$this->renovation,  'expanded' => true,  'multiple' => true])
            ->add('furnisher', null, ['label'=>'admin.ads.furnisher', 'editable'=>true])
            ->add('region', null, ['label'=>'admin.ads.region'])
            ->add('types', null, ['label'=>'admin.ads.types'])
            ->add('notAvalible', null, ['label'=>'admin.ads.notAvalible', 'editable'=>true])
            ->add('notConnected', null, ['label'=>'admin.ads.notConnected', 'editable'=>true])
        ;
    }


    /**
     * @param ShowMapper $show
     */
    protected function configureShowFields(ShowMapper $show)
    {
        $show
            ->add('id')
            ->add('price', null, ['label'=>'admin.ads.price'])
//            ->add('state', 'choice', ['choices'=>$this->state, 'label'=>'Состояние'])
            ->add('firstName', null, ['label'=>'admin.ads.firstName'])
            ->add('lastName', null, ['label'=>'admin.ads.lastName'])
            ->add('fatherName',null, ['label'=>'admin.ads.fatherName'])
            ->add('phone', null, ['label'=>'admin.ads.phone'])
            ->add('description','textarea', ['label'=>'admin.ads.description'])
            ->add('street', null, ['label'=>'admin.ads.street'])
            ->add('house', null, ['label'=>'admin.ads.house'])
            ->add('kb', null, ['label'=>'admin.ads.kb'])
            ->add('sqMeter', null, ['label'=>'admin.ads.sqMeter'])
//            ->add('renovation', 'choice', ['choices'=>$this->renovation, 'label'=>' Ремонт'])
            ->add('furnisher', null, ['label'=>' admin.ads.furnisher'])
            ->add('region', null, ['label'=>'admin.ads.region'])
            ->add('types', null, ['label'=>'admin.ads.types'])
            ->add('notAvalible', null, ['label'=>'admin.ads.notAvalible'])
            ->add('notConnected', null, ['label'=>'admin.ads.notConnected'])
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

                $query->andWhere(
                    $query->expr()->eq($query->getRootAliases()[0] . '.state', ':st')
                );
            $query->setParameter('st', Ads::IS_ARCHIVE);

        return $query;
    }
}
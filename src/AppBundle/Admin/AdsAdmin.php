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

class AdsAdmin extends Admin
{
    protected $translationDomain ='ads';
    protected $renovation;
    protected $state;

    public function __construct($code, $class, $baseControllerName)
    {
        parent::__construct($code, $class, $baseControllerName);
        $this->renovation = ['Евро', 'Косметический', 'Хороший'];
        $this->state = ['ПОКАЗ', 'АРХИВ', 'СДАН'];
    }

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('admin.witget.main', array(
                'class' => 'col-sm-6',
                'box-class' => 'box box-solid box-danger'
                /*'description' => 'admin.witget.main_descr'*/
            ))
            ->add('firstName', 'text', ['label'=>'firstName'])
            ->add('lastName', 'text', ['label'=>'lastName'])
            ->add('fatherName','text', ['label'=>'fatherName'])
            ->add('phone', 'text', ['label'=>'phone'])
            ->add('price', 'text', ['label'=>'price'])
            ->add('state', 'choice', ['choices'=>$this->state, 'label'=>'state'])
            ->add('description','textarea', ['label'=>'description'])
->end()
            ->with('admin.witget.parent', array(
                'class' => 'col-sm-6',
                'box-class' => 'box box-solid box-danger'
                /*'description' => 'admin.witget.main_descr'*/
            ))

            ->add('region', null, ['label'=>'region'])
            ->add('types', null, ['label'=>'types'])
            ->add('street', 'text', ['label'=>'street'])
            ->add('house', 'text', ['label'=>'house'])
            ->add('kb', 'text', ['label'=>'kb'])
            ->add('sqMeter', 'text', ['label'=>'sqMeter'])
            ->add('renovation', 'choice', ['choices'=>$this->renovation, 'label'=>'renovation'])
            ->add('furnisher', null, ['label'=>'furnisher'])
            ->add('notAvalible', null, ['label'=>'notAvalible'])
            ->add('notConnected', null, ['label'=>'notConnected'])
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
            ->add('price', null, ['label'=>'Цена', 'editable'=>true])
            ->add('state', 'choice', ['choices'=>$this->state, 'label'=>'Состояние', 'editable'=>true])
            ->add('firstName', null, ['label'=>'Имя', 'editable'=>true])
            ->add('lastName', null, ['label'=>'Фамилия', 'editable'=>true])
            ->add('fatherName',null, ['label'=>'Отчество', 'editable'=>true])
            ->add('phone', null, ['label'=>'Телефон', 'editable'=>true])
            ->add('description','textarea', ['label'=>'Описание', 'editable'=>true])
            ->add('street', 'text', ['label'=>'Улица', 'editable'=>true])
            ->add('house', 'text', ['label'=>'Дом', 'editable'=>true])
            ->add('kb', null, ['label'=>'Кв', 'editable'=>true])
            ->add('sqMeter', null, ['label'=>'Площадь', 'editable'=>true])
            ->add('renovation', 'choice', ['choices'=>$this->renovation, 'label'=>' Ремонт', 'editable'=>true])
            ->add('furnisher', null, ['label'=>' Мебель', 'editable'=>true])
            ->add('region', null, ['label'=>'Район'])
            ->add('types', null, ['label'=>' Тип жилья'])
            ->add('notAvalible', null, ['label'=>' Недоступен', 'editable'=>true])
            ->add('notConnected', null, ['label'=>' Неотвечает', 'editable'=>true])
            ->add('_action', 'actions',
                array('actions' =>
                    array(
                        'delete' => array(), 'edit' => array()
                    )
                ));

    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id')
            ->add('price', null, ['label'=>'Цена'])
//            ->add('state', 'choice', ['choices'=>$this->state, 'label'=>'Состояние'])
            ->add('firstName', null, ['label'=>'Имя'])
            ->add('lastName', null, ['label'=>'Фамилия'])
            ->add('fatherName',null, ['label'=>'Отчество'])
            ->add('phone', null, ['label'=>'Телефон'])
            ->add('description',null, ['label'=>'Описание'])
            ->add('street', null, ['label'=>'Улица'])
            ->add('house', null, ['label'=>'Дом'])
            ->add('kb', null, ['label'=>'Кв'])
            ->add('sqMeter', null, ['label'=>'Площадь'])
//            ->add('renovation', null, 'choice', ['choices'=>$this->renovation, 'label'=>' Ремонт'])
            ->add('furnisher', null, ['label'=>' Мебель'])
            ->add('region', null, ['label'=>'Район'])
            ->add('types', null, ['label'=>' Тип жилья'])
            ->add('notAvalible', null, ['label'=>' Недоступен'])
            ->add('notConnected', null, ['label'=>' Неотвечает'])
        ;
    }

    /**
     * @param ShowMapper $show
     */
    protected function configureShowFields(ShowMapper $show)
    {
        $show
            ->add('id')
            ->add('price', null, ['label'=>'Цена'])
//            ->add('state', 'choice', ['choices'=>$this->state, 'label'=>'Состояние'])
            ->add('firstName', null, ['label'=>'Имя'])
            ->add('lastName', null, ['label'=>'Фамилия'])
            ->add('fatherName',null, ['label'=>'Отчество'])
            ->add('phone', null, ['label'=>'Телефон'])
            ->add('description','textarea', ['label'=>'Описание'])
            ->add('street', null, ['label'=>'Улица'])
            ->add('house', null, ['label'=>'Дом'])
            ->add('kb', null, ['label'=>'Кв'])
            ->add('sqMeter', null, ['label'=>'Площадь'])
//            ->add('renovation', 'choice', ['choices'=>$this->renovation, 'label'=>' Ремонт'])
            ->add('furnisher', null, ['label'=>' Мебель'])
            ->add('region', null, ['label'=>'Район'])
            ->add('types', null, ['label'=>' Тип жилья'])
            ->add('notAvalible', null, ['label'=>' Недоступен'])
            ->add('notConnected', null, ['label'=>' Неотвечает'])
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
            $query->expr()->in($query->getRootAliases()[0] . '.state', ':st')
        );


        $query->setParameter('st', [Ads::IS_SHOW, Ads::IS_DONE]);

        return $query;
    }
}
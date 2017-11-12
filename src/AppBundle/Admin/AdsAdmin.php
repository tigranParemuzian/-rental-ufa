<?php
/**
 * Created by PhpStorm.
 * User: tigran
 * Date: 2/20/17
 * Time: 4:19 PM
 */

namespace AppBundle\Admin;


use AppBundle\Entity\Parameter;
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

    public function __construct($code, $class, $baseControllerName)
    {
        parent::__construct($code, $class, $baseControllerName);
        $this->renovation = ['Евро', 'Косметический', 'Хороший'];
        $this->state = ['ПОКАЗ', 'АРХИВ', 'СДАН'];
    }

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('Main', array(
                'class' => 'col-sm-6',
                'box-class' => 'box box-solid box-danger',
                'description' => 'Parameters main create part'
            ))
            ->add('firstName', 'text', ['label'=>'Имя'])
            ->add('lastName', 'text', ['label'=>'Фамилия'])
            ->add('fatherName','text', ['label'=>'Отчество'])
            ->add('phone', 'text', ['label'=>'Телефон'])
            ->add('price', 'text', ['label'=>'Цена'])
            ->add('state', 'choice', ['choices'=>$this->state, 'label'=>'Состояние'])
            ->add('description','textarea', ['label'=>'Описание'])
->end()
            ->with('Parent', array(
                'class' => 'col-sm-6',
                'box-class' => 'box box-solid box-danger',
               /* 'description' => 'Parameters main create part'*/
            ))

            ->add('region', null, ['label'=>'Район'])
            ->add('types', null, ['label'=>' Тип жилья'])
            ->add('street', 'text', ['label'=>'Улица'])
            ->add('house', 'text', ['label'=>'Дом'])
            ->add('kb', 'text', ['label'=>'Кв'])
            ->add('sqMeter', 'text', ['label'=>'Площадь'])
            ->add('renovation', 'choice', ['choices'=>$this->renovation, 'label'=>' Ремонт'])
            ->add('furnisher', null, ['label'=>' Мебель'])
            ->add('notAvalible', null, ['label'=>' Недоступен'])
            ->add('notConnected', null, ['label'=>' Неотвечает'])
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
            ->add('price', null, ['label'=>'Цена'])
            ->add('state', 'choice', ['choices'=>$this->state, 'label'=>'Состояние'])
            ->add('firstName', null, ['label'=>'Имя'])
            ->add('lastName', null, ['label'=>'Фамилия'])
            ->add('fatherName',null, ['label'=>'Отчество'])
            ->add('phone', null, ['label'=>'Телефон'])
            ->add('description',null, ['label'=>'Описание'])
            ->add('street', null, ['label'=>'Улица'])
            ->add('house', null, ['label'=>'Дом'])
            ->add('kb', null, ['label'=>'Кв'])
            ->add('sqMeter', null, ['label'=>'Площадь'])
            ->add('renovation', 'choice', ['choices'=>$this->renovation, 'label'=>' Ремонт'])
            ->add('furnisher', null, ['label'=>' Мебель'])
            ->add('region', null, ['label'=>'Район'])
            ->add('types', null, ['label'=>' Тип жилья'])
            ->add('notAvalible', null, ['label'=>' Недоступен'])
            ->add('notConnected', null, ['label'=>' Неотвечает'])
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
}
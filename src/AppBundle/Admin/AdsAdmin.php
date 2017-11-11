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
            ->add('price')
            ->add('state', 'choice', ['choices'=>$this->state, 'label'=>'Состояние'])
            ->add('firstName')
            ->add('lastName')
            ->add('fatherName')
            ->add('phone')
            ->add('description')
            ->add('street')
            ->add('house')
            ->add('kb')
            ->add('sqMeter')
            ->add('renovation', 'choice', ['choices'=>$this->renovation, 'label'=>' Ремонт'])
            ->add('furnisher')
            ->add('region')
            ->add('types')
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
            ->add('price')
            ->add('state')
            ->add('firstName')
            ->add('lastName')
            ->add('fatherName')
            ->add('phone')
            ->add('description')
            ->add('street')
            ->add('house')
            ->add('kb')
            ->add('sqMeter')
            ->add('renovation')
            ->add('furnisher')
            ->add('region')
            ->add('types')
        ;
    }

    /**
     * @param ShowMapper $show
     */
    protected function configureShowFields(ShowMapper $show)
    {
        $show
            ->add('id')
            ->add('price')
            ->add('state')
            ->add('firstName')
            ->add('lastName')
            ->add('fatherName')
            ->add('phone')
            ->add('description')
            ->add('street')
            ->add('house')
            ->add('kb')
            ->add('sqMeter')
            ->add('renovation')
            ->add('furnisher')
            ->add('region')
            ->add('types');
    }
}
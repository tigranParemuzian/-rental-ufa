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

class RegionsAdmin extends Admin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('Main', array(
                'class' => 'col-sm-12',
                'box-class' => 'box box-solid box-danger',
                'description' => 'Parameters main create part'
            ))
            ->add('name')
            ->add('isEnabled')
            ->end()
        ;

    }

    /**
     * @param ListMapper $list
     */
    protected function configureListFields(ListMapper $list)
    {
        $list
            ->add('name', 'text', ['editable'=>true])
            ->add('isEnabled', null, ['editable'=>true])
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
            ->add('name')
            ->add('isEnabled')
        ;
    }

    /**
     * @param ShowMapper $show
     */
    protected function configureShowFields(ShowMapper $show)
    {
        $show
            ->add('name')
            ->add('isEnabled')
        ;
    }
}
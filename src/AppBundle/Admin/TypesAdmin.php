<?php
/**
 * Created by PhpStorm.
 * User: tigran
 * Date: 2/20/17
 * Time: 4:19 PM
 */

namespace AppBundle\Admin;


use AppBundle\Entity\Parameter;
use function PHPSTORM_META\type;
use Sonata\AdminBundle\Admin\AbstractAdmin as Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;

class TypesAdmin extends Admin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('Main', array(
                'class' => 'col-sm-12',
                'box-class' => 'box box-solid box-danger',
                'description' => 'Parameters main create part',
                'label' => 'admin.types.main'
            ))
            ->add('name',null,['label'=>'admin.types.name'])
            ->add('isEnabled',null,['label'=>'admin.types.isEnabled'])
            ->end()
        ;

    }

    /**
     * @param ListMapper $list
     */
    protected function configureListFields(ListMapper $list)
    {
        $list
            ->add('name',null,['label'=>'admin.types.name'])
            ->add('isEnabled', null,['label'=>'admin.types.isEnabled'], ['editable'=>true])
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
            ->add('name',null,['label'=>'admin.types.name'])
            ->add('isEnabled',null,['label'=>'admin.types.isEnabled'])
        ;
    }

    /**
     * @param ShowMapper $show
     */
    protected function configureShowFields(ShowMapper $show)
    {
        $show
            ->add('name',null,['label'=>'admin.types.name'])
            ->add('isEnabled',null,['label'=>'admin.types.isEnabled'])
        ;
    }
}
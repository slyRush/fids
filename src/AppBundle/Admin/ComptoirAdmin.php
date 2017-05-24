<?php
namespace AppBundle\Admin;

//Why your controller is in the namespace of your bundle? The correct place is MyBundle\Controller\Admin.
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Route\RouteCollection ;
use Sonata\AdminBundle\Validator\ErrorElement;

class ComptoirAdmin extends Admin
{
    /**
    * Default Datagrid values
    *
    * @var array
    */
    protected $datagridValues = array(
        '_page' => 1,            // display the first page (default = 1)
        '_sort_order' => 'DESC', // reverse order (default = 'ASC')
        '_sort_by' => 'id'  // name of the ordered field
                                 // (default = the model's id field, if any)

        // the '_sort_by' key can be of the form 'mySubModel.mySubSubModel.myField'.
    );
    
    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper  
                ->add('numero', 'text', array('label' => 'Comptoir N°','required' => true ))
                ->add('type', 'choice', array(
                        'label' => 'Type',
                        'required' => true,
                        'choices' => array(
                            'national' => "National",
                            'international' => 'International'
                        )
                    ))
                ->add('isDispo', 'hidden', array('data' => 1))
        ;
    }

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper 			
            ->add('numero', 'string',  array('label'=>'Comptoir N°'))
            ->add('type', 'string',  array('label'=>'Type'))        
            ->add('isDispo', null,  array(
                    'label'=>'Disponibilité',
                    'template' => "AppBundle:Admin:disponibilite.html.twig"
                ))
            ->add('_action', 'actions', array(
                'actions' => array(
                    'show' => array(),
                    'edit' => array(), 
                    'delete' => array(),
                )
            ))
        ;
    }

    // Fields to be shown on show action
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('numero', 'string',  array('label'=>'Comptoir N°'))
            ->add('type', 'string',  array('label'=>'Type'))        
            ->add('isDispo', null,  array('label'=>'Disponibilité'))
                ;
                
    }
	
    protected function configureRoutes(RouteCollection $collection)
    {
            // to remove a single route
            //$collection->remove('create');		
    }

    
    public function configure()
    {
        parent::configure();
        $this->classnameLabel = "Comptoir";
    }
}
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

class CompagnieAdmin extends Admin
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
        $options = array('required' => false, 'data_class' => null);
        $basePath = $this->getRequest()->getBasePath() . '/' ;
        $logo = null ;
        if (($subject = $this->getSubject()) && $subject->getLogo()) {
            $path = $subject->getLogo();
            $logo = $path ;
            $options['help'] = '<img style="width: 100px; height: 100px;" src="' . $basePath . $path . '" />';
        }
        $options['data'] = $logo ;
        $options['label'] = 'logo (145px x 60px)';
        $formMapper  
                ->add('id_compagnie', 'text', array('label' => 'Id','required' => true ))
                ->add('nom', 'text', array('label' => 'Nom','required' => true ))
                ->add('logo', 'file', $options)
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
            ->add('id_compagnie', 'text', array('label' => 'Id','required' => true ))
            ->add('nom', 'string',  array('label'=>'Compagnie'))
            ->add('logo', null, array('template' => "AppBundle:Admin:Compagnie/logo_list.html.twig"))//logo preview
            //->add('media', 'string', array('template' => 'SonataMediaBundle:MediaAdmin:list_image.html.twig'))
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
            ->add('id_compagnie', 'text')
            ->add('nom', 'text')  
            ->add('logo', null, array('template' => "AppBundle:Admin:Compagnie/logo_show.html.twig"))//logo preview
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
        $this->classnameLabel = "Compagnie";
    }
}
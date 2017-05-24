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

class VolsAdmin extends Admin
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
                ->add('nom', 'text', array('label' => 'Vol N°','required' => true ))
                ->add('depart', 'text', array('label' => 'Départ','required' => true ))
                ->add('destination', 'text', array('label' => 'Destination','required' => true ))   
                ->add('reseau', 'choice', array(
                        'label' => 'Réseau',
                        'required' => true,
                        'choices' => array(
                            "" => "",
                            'national' => "National",
                            'international' => 'International'
                        ),
                        'data' => ""
                    ))
                ->add('type', 'choice', array(
                        'label' => 'Type',
                        'required' => true,
                        'choices' => array(
                            "" => "",
                            'depart' => "Départ",
                            'arrivee' => 'Arrivée'
                        ),
                        'data' => ""
                    ))
                ->add('idCompagnie','entity', array(
                            'class' => 'AppBundle\Entity\Compagnie',
                            'property' => 'nom',
                            'label' => 'Compagnie de vols',
                            'required' => true,
                            'query_builder' => function (\Doctrine\ORM\EntityRepository $repository) {
                                return $repository->createQueryBuilder('pos');
                                        //->where('pos.isActive = 1');
                           }, 
                           'attr' => array('class' => 'span5')
                ))
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
            ->add('nom', 'string',  array('label'=>'Vol N°'))
            ->add('depart', 'string',  array('label'=>'Départ'))
            ->add('destination', 'string',  array('label'=>'Destination'))
            ->add('idCompagnie.nom', 'string',  array('label'=>'Compagnie'))    
            ->add('type', 'text', array('label' => 'Type'))   
            ->add('reseau', 'text', array('label' => 'Réseau'))
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
            ->add('nom', 'text',  array('labelnom'=>'Vol N°'))  
            ->add('depart', 'text',  array('label'=>'Départ'))
            ->add('destination', 'text',  array('label'=>'Destination')) 
            ->add('idCompagnie.nom', 'string',  array('label'=>'Compagnie'))    
            ->add('type', 'text', array('label' => 'Type'))   
            ->add('reseau', 'text', array('label' => 'Réseau'))
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
        $this->classnameLabel = "Vols";
    }
}
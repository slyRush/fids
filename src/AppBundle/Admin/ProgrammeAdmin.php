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

class ProgrammeAdmin extends Admin
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
        // isActive
        $formMapper  
                ->tab('Informations du vols')
                    ->with('Informations générale')
                    ->add('idVols','entity', array(
                            'class' => 'AppBundle\Entity\Vols',
                            'property' => 'nom',
                            'label' => 'Vols',
                            'required' => true,
                            'query_builder' => function (\Doctrine\ORM\EntityRepository $repository) {
                                return $repository->createQueryBuilder('pos');
                                        //->where('pos.isActive = 1');
                           }, 
                           'attr' => array('class' => 'span5')))
                    ->add('dateVols', 'date', array(
                            'label' => 'Date du vols','required' => true
                            ,'attr' => array('class' => 'span5'),'data' => new \DateTime()
                            //,'attr' => array('style' => 'width:100px','placeholder'=>'%') A VOIR PLUS TARD
                        ))
                    ->add('heureDepart', 'time', array(
                            'label' => 'Heure de départ','required' => true 
                        ))  
                    ->add('heureArrivee', 'time', array('label' => "Heure d'arrivée",'required' => true )) 
                    ->add('comptoir','entity', array(
                            'class' => 'AppBundle\Entity\Comptoir',
                            'property' => 'numero',
                            'label' => 'Comptoir',
                            'expanded' => true,
                            'multiple' => true,
                            /*'group_by' => function($val, $key, $index) {
                                if ($val->getType() =='national') {
                                    return 'Soon';
                                } else {
                                    return 'Later';
                                }
                            },*/
                            'choice_label' => function ($value, $key, $index) {
                                
                                if ($value->getType() == 'national') {
                                    return 'n° '.$value->getNUmero().' (national)';
                                } else {

                                    return 'n° '.$value->getNUmero().' (international)';
                                }
                            },
                            'query_builder' => function (\Doctrine\ORM\EntityRepository $repository) {
                               $id = $this->id($this->getSubject()) ;
                               $queryEdit = $repository->createQueryBuilder('pos')
                                        ->leftJoin('AppBundle:ProgrammeComptoir', 'pc', 'WITH', "pc.idProgramme =".$id)
                                        ->where('pos.isDispo = 1')
                                        ->orWhere('pos.id = pc.idComptoir');
                                $queryCreate = $repository->createQueryBuilder('pos')
                                        ->where('pos.isDispo = 1');
                                $query = ($id)? $queryEdit : $queryCreate ;
                                return $query ;
                           }
                         ))  
                    ->add('porte','entity', array(
                            'class' => 'AppBundle\Entity\Porte',
                            'property' => 'numero',
                            'label' => "Porte d'embarquement",
                            'expanded' => true,
                            'multiple' => true,
                            'choice_label' => function ($value, $key, $index) {
                                
                                if ($value->getType() == 'national') {
                                    return 'n° '.$value->getNUmero().' (national)';
                                } else {

                                    return 'n° '.$value->getNUmero().' (international)';
                                }
                            },
                            'query_builder' => function (\Doctrine\ORM\EntityRepository $repository) {
                                $id = $this->id($this->getSubject()) ;
                                $queryEdit = $repository->createQueryBuilder('pos')
                                        ->leftJoin('AppBundle:ProgrammePorte', 'pc', 'WITH', "pc.idProgramme =".$id)
                                        ->where('pos.isDispo = 1')
                                        ->orWhere('pos.id = pc.idPorte');
                                $queryCreate = $repository->createQueryBuilder('pos')
                                        ->where('pos.isDispo = 1');
                                $query = ($id)? $queryEdit : $queryCreate ;
                                return $query ;
                           }
                         ))                
                    ->end()               
                ->end()
                ->tab('Statut')  
                    ->with('Statut')                 
                    ->add('statut', 'choice', array(
                        'label' => 'Statut du vols',
                        'required' => true,
                        'choices' => array(
                            "" => "",
                            'embarquement' => 'Embarquement',
                            'decolle' => 'Décollé',
                            'retarde' => 'Retardé',
                            'pose' => 'Posé',
                            'termine' => 'Terminé',
                            'annule' => 'Annulé'
                        ),
                        'data' => ""
                    ))
                    ->add('checkIn', 'choice', array(
                        'label' => 'Check in',
                        'required' => true,
                        'choices' => array(
                            "" => "",
                            'ouvert' => 'Enregistrement ouvert',
                            'cloture' => 'Enregistrement cloturée'
                        ),
                        'data' => ""
                    ))
                    ->add('situationBagage', 'choice', array(
                        'label' => 'Situation bagage',
                        'choices' => array(
                            "" => "",
                            'arrive' => 'Arrivé',
                            'livre' => 'Livrée'
                        ),
                        'data' => ""
                    ))
                    ->end()               
                ->end()
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
            ->add('idVols.nom', null, array(
                    'label' => 'Vols',
                    //'template' => 'AppBundle:Admin:Programme/nom_du_vols.html.twig'
                )
            )
            ->add('idCompagnie.nom', 'null',  array('label'=>'Compagnie'))
            ->add('dateVols', 'date',  array('label'=>'Date du vols'))
            ->add('heureDepart', 'time',  array('label'=>'Heure de départ'))
            ->add('heureArrivee', 'time',  array('label'=>"Heure d'arrivée")) 
            ->add('statut', 'text',  array(
                'label'=>"Statut du vol",
                'template' => 'AppBundle:Admin:Programme/statut.html.twig'
            ))
            ->add('checkIn', 'text',  array(
                'label'=>"Check in",
                'template' => 'AppBundle:Admin:Programme/checkin.html.twig'
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
            ->add('idVols.nom', 'text',  array('label'=>'Nom'))  
            ->add('dateVols', 'date',  array('label'=>'Départ'))
            ->add('statut', 'text',  array('label'=>"Statut"))
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
        $this->classnameLabel = "Programme";
    }
}
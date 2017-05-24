<?php

namespace AppBundle\Manager;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\Translation\TranslatorInterface;
use AppBundle\Entity\ProgrammeComptoir ;
use AppBundle\Entity\ProgrammePorte ;

/**
 *  Programme Manager : service to manage common tasks
 */
class ProgrammeManager extends Controller {

    protected $em;
    protected $container;
    protected $translator;

    /**
     * Class BenefManager constructor
     * 
     * @param EntityManager $em
     * @param Container $container
     * @param TranslatorInterface $translator
     */
    public function __construct(EntityManager $em, Container $container = null, TranslatorInterface $translator) {
        $this->em = $em;
        $this->container = $container;
        $this->translator = $translator;
    }
    
    public function manageRelation($relationTab, $oProgramme, $type){
        //ajout des nouveaux relations
        if(isset($relationTab) && is_array($relationTab)){
            $em = $this->getDoctrine()->getEntityManager();
            $rep = $em->getRepository('AppBundle:Programme'.$type);
            foreach ($relationTab as $value) {
                $oProRelation = $rep->findOneBy(array("idProgramme" => $oProgramme->getId(), "id".$type => $value));
                if(!isset($oProRelation)){
                    if($type == "Comptoir"){
                        $this->addComptoirToP($oProgramme , $value);//alors ajouter le comptoir
                    } else {
                        $this->addPorteToP($oProgramme , $value);//alors ajouter la porte 
                    }
                }
            }
        }
        //supprimer les anciens relations
        $allRelation = $rep->findBy(array("idProgramme" => $oProgramme->getId(), 'type' => strtolower($type)));
        if($type == "Comptoir"){
            $this->removeComptoirToP($allRelation, $relationTab) ;//supprimer les comptoirs décochés
        } else {
            $this->removePorteToP($allRelation, $relationTab) ;//supprimer les portes décochés
        }
    }
    
    /*
     * ajout relation programme et comptoir
     */
    private function addComptoirToP($oProgramme, $idComptoir){
        $oProgComptoir = new ProgrammeComptoir() ;
        //liaison programme
        $oProgComptoir->setIdProgramme($oProgramme->getId());
        $oProgComptoir->setProgramme($oProgramme);
        //liaison comptoir
        $repC = $this->em->getRepository('AppBundle:Comptoir');
        $oComptoir = $repC->find($idComptoir) ;
        if(isset($oComptoir) && is_object($oComptoir)){
            //mettre ce comptoir en non dispo
            $oComptoir->setIsDispo(false) ;
            $this->em->persist($oComptoir) ;
            $this->em->flush($oComptoir);
            
            $oProgComptoir->setIdComptoir($idComptoir);
            $oProgComptoir->setComptoir($oComptoir);
        }  
        $oProgComptoir->setType("comptoir") ;
        $oProgComptoir->setIsDeleted(false);
        $this->em->persist($oProgComptoir);
        $this->em->flush($oProgComptoir);
    }
    
    /*
     * ajout relation programme et porte
     */
    private function addPorteToP($oProgramme, $idPorte){
        $oProgPorte = new ProgrammePorte() ;
        //liaison porte
        $oProgPorte->setIdProgramme($oProgramme->getId());
        $oProgPorte->setProgramme($oProgramme);
        //liaison porte
        $repC = $this->em->getRepository('AppBundle:Porte');
        $oPorte = $repC->find($idPorte) ;
        if(isset($oPorte) && is_object($oPorte)){
            //mettre ce porte en non dispo
            $oPorte->setIsDispo(false) ;
            $this->em->persist($oPorte) ;
            $this->em->flush($oPorte);
            
            $oProgPorte->setIdPorte($idPorte);
            $oProgPorte->setPorte($oPorte);
        }
        $oProgPorte->setType("porte") ;
        $oProgPorte->setIsDeleted(false);
        $this->em->persist($oProgPorte);
        $this->em->flush($oProgPorte);
    }
    
    /*
     * supprimer relation programme et comptoir
     */
    private function removeComptoirToP($allComptoir, $relationTab){
        if(isset($allComptoir)){
            foreach ($allComptoir as $obj) {
                if(!in_array($obj->getIdComptoir(), $relationTab)){
                    $oComptoir = $obj->getComptoir() ;
                    $oProgramme = $obj->getProgramme() ;
                    if(isset($oComptoir) && is_object($oComptoir)){
                        $oComptoir->setIsDispo(true) ;
                        $this->em->persist($oComptoir) ;
                        $this->em->flush($oComptoir);
                        $oProgramme->removeComptoir($oComptoir);
                        $oComptoir->removeProgramme($oProgramme);
                    }
                    
                    //$obj->setIsDeleted(true);
                    $this->em->remove($obj);
                    $this->em->flush($obj);
                }
            }
        }
    }
    
    /*
     * supprimer relation programme et porte
     */
    private function removePorteToP($allPorte, $relationTab){
        if(isset($allPorte)){
            foreach ($allPorte as $obj) {
                if(!in_array($obj->getIdPorte(), $relationTab)){
                    $oPorte = $obj->getPorte() ;
                    $oProgramme = $obj->getProgramme() ;
                    if(isset($oPorte) && is_object($oPorte)){
                        $oPorte->setIsDispo(true) ;
                        $this->em->persist($oPorte) ;
                        $this->em->flush($oPorte);
                        $oProgramme->removePorte($oPorte);
                        $oPorte->removeProgramme($oProgramme);
                    }
                    
                    //$obj->setIsDeleted(true);
                    $this->em->remove($obj);
                    $this->em->flush($obj);
                }
            }
        }
    }
    
    /*
     * return un tableau de tous les informations de vols
     */
    public function getFlightInformation(){
        $fRepository = $this->em->getRepository('AppBundle:Programme');
        $flight = $fRepository->getProgrammeToday() ;
        return $flight ;
    }
    
    /*
     * return un tableau de tous les informations de vols
     */
    public function getCheckList(){
        $fRepository = $this->em->getRepository('AppBundle:Programme');
        $checkList = $fRepository->getCheckList() ;
        return $checkList ;
    }
}

?>

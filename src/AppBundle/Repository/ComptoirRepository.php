<?php

namespace AppBundle\Repository;

/**
 * ComptoirRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ComptoirRepository extends \Doctrine\ORM\EntityRepository
{
    function getTomorrowsDate($format = 'Y-m-d H:i:s'){
    
        $date = \DateTime::createFromFormat( "Y-m-d H:i:s", date("Y-m-d 06:00:00") );
        $date->add(\DateInterval::createFromDateString('tomorrow'));

        return $date->format($format);
    }
	public function getCheckList(){
        
        $sql = $this->createQueryBuilder('cpt')
                ->select("cpt.id, cpt.numero, cpt.isDispo, cpt.type as comptoir_type,"
                		."p.id as id_programme, p.heureDepart, p.heureArrivee, p.statut, p.checkIn, p.typeAffichage, p.situationBagage,p.classe,"
                        . "v.nom as nom_vol, v.depart, v.destination, v.type, v.reseau, "
                        . "c.nom as compagnie, c.logo,"
                        . "pc.idComptoir, cpt.numero as num_comptoir")
                ->leftJoin('AppBundle:ProgrammeComptoir', 'pc', 'WITH', "pc.idComptoir = cpt.id")
                ->leftJoin('AppBundle:Programme', 'p', 'WITH', "p.id = pc.idProgramme")
                ->leftJoin('AppBundle:Vols', 'v', 'WITH', "v.id = p.idVols")
                ->leftJoin('AppBundle:Compagnie', 'c', 'WITH', "c.id = v.idCompagnie")
                
               ;
    
        $result = $sql->getQuery()->getResult();
        return $result;
    }


    public function getCheck( $id){
        $today_startdatetime = \DateTime::createFromFormat( "Y-m-d H:i:s", date("Y-m-d 00:00:00") );
        $today_enddatetime = \DateTime::createFromFormat( "Y-m-d H:i:s", date("Y-m-d 23:59:59") );
        $tomorow_enddatetime = $this->getTomorrowsDate();
        
        $sql = $this->createQueryBuilder('cpt')
                ->select("cpt.id, cpt.numero, cpt.isDispo, cpt.type,"
                		."p.id as id_programme, p.heureDepart, p.heureArrivee, p.statut, p.checkIn, p.typeAffichage, p.situationBagage,p.classe,"
                        . "v.nom as nom_vol, v.depart, v.destination, v.type, v.reseau, "
                        . "c.nom as compagnie, c.logo,"
                        . "pc.idComptoir, cpt.numero as num_comptoir,"
                        . "pp.idPorte, por.numero as num_porte")
                ->leftJoin('AppBundle:ProgrammeComptoir', 'pc', 'WITH', "pc.idComptoir = cpt.id")
                ->leftJoin('AppBundle:Programme', 'p', 'WITH', "p.id = pc.idProgramme")
                ->leftJoin('AppBundle:Vols', 'v', 'WITH', "v.id = p.idVols")
                ->leftJoin('AppBundle:Compagnie', 'c', 'WITH', "c.id = v.idCompagnie")
                ->leftJoin('AppBundle:ProgrammePorte', 'pp', 'WITH', "pp.idProgramme = p.id")
                ->leftJoin('AppBundle:Porte', 'por', 'WITH', "por.id = pp.idPorte")                
                ->where('cpt.id = '.$id);


       
    
        $result = $sql->getQuery()->getResult();
        return $result;
    }
}

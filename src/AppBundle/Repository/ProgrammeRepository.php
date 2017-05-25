<?php

namespace AppBundle\Repository;

/**
 * ProgrammeRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ProgrammeRepository extends \Doctrine\ORM\EntityRepository
{

    function getTomorrowsDate($format = 'Y-m-d H:i:s'){
    
        $date = \DateTime::createFromFormat( "Y-m-d H:i:s", date("Y-m-d 06:00:00") );
        $date->add(\DateInterval::createFromDateString('tomorrow'));

        return $date->format($format);
    }
    public function getProgrammeToday(){
        $today_startdatetime = \DateTime::createFromFormat( "Y-m-d H:i:s", date("Y-m-d 00:00:00") );
        $today_enddatetime = \DateTime::createFromFormat( "Y-m-d H:i:s", date("Y-m-d 23:59:59") );
        $tomorow_enddatetime = $this->getTomorrowsDate();
        $sql = $this->createQueryBuilder('p')
                ->select("p.heureDepart, p.heureArrivee, p.statut, p.checkIn, p.typeAffichage, p.situationBagage,"
                        . "v.nom as nom_vol, v.depart, v.destination, v.type, v.reseau, "
                        . "c.nom as compagnie, c.logo")
                ->innerJoin('AppBundle:Vols', 'v', 'WITH', "v.id = p.idVols")
                ->innerJoin('AppBundle:Compagnie', 'c', 'WITH', "c.id = v.idCompagnie")
                /*->where('p.dateVols >= :today_startdatetime')
                ->andWhere('p.dateVols <= :today_enddatetime');*/
                ->where('p.dateVols BETWEEN :today_startdatetime and :today_enddatetime OR p.dateVols BETWEEN :today_enddatetime and :tomorow_enddatetime');


        $sql->setParameter('today_startdatetime', $today_startdatetime)
            ->setParameter('today_enddatetime', $today_enddatetime)
            ->setParameter('tomorow_enddatetime', $tomorow_enddatetime);
    
        $result = $sql->getQuery()->getResult();
        return $result;
    }
    
    public function getCheckList(){
        $today_startdatetime = \DateTime::createFromFormat( "Y-m-d H:i:s", date("Y-m-d 00:00:00") );
        $today_enddatetime = \DateTime::createFromFormat( "Y-m-d H:i:s", date("Y-m-d 23:59:59") );
        $sql = $this->createQueryBuilder('p')
                ->select("p.id, p.heureDepart, p.heureArrivee, p.statut, p.checkIn, p.typeAffichage, p.situationBagage,"
                        . "v.nom as nom_vol, v.depart, v.destination, v.type, v.reseau, "
                        . "c.nom as compagnie, c.logo,"
                        . "pc.idComptoir, cpt.numero as num_comptoir")
                ->innerJoin('AppBundle:Vols', 'v', 'WITH', "v.id = p.idVols")
                ->innerJoin('AppBundle:Compagnie', 'c', 'WITH', "c.id = v.idCompagnie")
                ->leftJoin('AppBundle:ProgrammeComptoir', 'pc', 'WITH', "pc.idProgramme = p.id")
                ->leftJoin('AppBundle:Comptoir', 'cpt', 'WITH', "cpt.id = pc.idComptoir")
                ->where('p.dateVols >= :today_startdatetime')
                ->andWhere('p.dateVols <= :today_enddatetime');


        $sql->setParameter('today_startdatetime', $today_startdatetime)
            ->setParameter('today_enddatetime', $today_enddatetime);
    
        $result = $sql->getQuery()->getResult();
        return $result;
    }
}

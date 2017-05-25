<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Session\Session;
/**
 * Description of FrontController
 *
 * @author Hasina
 */
class FrontController extends Controller{
    public function listAction(){
        $programManager = $this->get('program.manager');
        $flights = $programManager->getFlightInformation();
        return $this->render("AppBundle:Front:list_a_afficher.html.twig", 
                array('flights' => $flights)
        );
    }
    /*
     * affichage programme vols
     */
    public function flightInformationAction(Request $request){
        $typeVol = $request->get('type');
        $reseau = $request->get('reseau');
        $programManager = $this->get('program.manager');        
        $flights = $programManager->getFlightInformation();
        $dateNow = new \DateTime('now');
        $dayName = date('l', strtotime($dateNow->format("Y-m-d")));
        return $this->render("AppBundle:Front:flight-information.html.twig", 
                array(
                    'title' => 'RAVINALA AIRPORTS',
                    'color' => "#3871AD",
                    'logo' => "plane.jpeg",
                    'typeDisplayed' => $typeVol,
                    'reseauDisplayed' => $reseau,
                    'flights' => $flights,
                    'dateTime' => $dateNow,
                    'day_name' => $dayName
                )
        );
    }
    
    /*
     * affichage situation bagage
     */
    public function baggageClaimAction(){
        $programManager = $this->get('program.manager');
        $baggages = $programManager->getFlightInformation();
        $dateNow = new \DateTime('now');
        $dayName = date('l', strtotime($dateNow->format("Y-m-d")));
        return $this->render("AppBundle:Front:baggage-claim.html.twig", 
                array(
                    'title' => 'SITUATION BAGAGE',
                    'color' => "#AA3434",
                    'logo' => "bagage.jpg",
                    'baggages' => $baggages,
                    'dateTime' => $dateNow,
                    'day_name' => $dayName
                )
        );
    }
    
    /*
     * affichage check in
     */
    public function ckeckInByComptoirAction(){
        $programManager = $this->get('program.manager');
        //compagnie, num_comptoir, numero_vol, depart time, destination, label <<CHECK IN>>
        //$baggages = $programManager->getFlightInformation();
        $dateNow = new \DateTime('now');
        $dayName = date('l', strtotime($dateNow->format("Y-m-d")));
        return $this->render("AppBundle:Front:check-in-by.html.twig", 
                array(
                    'title' => 'CHECK IN',
                    'color' => "#508346",
                    'logo' => "check-in-5.png",
                    'checkIn' => null,
                    'dateTime' => $dateNow,
                    'day_name' => $dayName
                )
        );
    }
    
    /*
     * checkIn list
     */
    public function ckeckInListAction(){
        $programManager = $this->get('program.manager');
        $checkInList = $programManager->getCheckList();
        //dump($checkInList) ; die ;
        $dateNow = new \DateTime('now');
        $dayName = date('l', strtotime($dateNow->format("Y-m-d")));
        return $this->render("AppBundle:Front:checkin_list.html.twig", 
                array(
                    'title' => 'CHECK IN LISTE',
                    'color' => "#508346",
                    'logo' => "check-in-5.png",
                    'checkInList' => $checkInList,
                    'dateTime' => $dateNow,
                    'day_name' => $dayName
                )
        );
    }
}

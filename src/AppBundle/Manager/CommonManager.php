<?php

namespace AppBundle\Manager;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Templating\EngineInterface;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\Translation\TranslatorInterface;

/**
 *  Common Manager : service to manage common tasks
 */
class CommonManager extends Controller {

    protected $mailer;
    protected $container;
    protected $templating;
    protected $translator;

    public function __construct(\Swift_mailer $mailer, Container $container, EngineInterface $templating, TranslatorInterface $translator) {
        $this->mailer = $mailer;
        $this->container = $container;
        $this->templating = $templating;
        $this->translator = $translator;
    }
    
    public function uploadFile($file) {
        $aValueL = array() ;
        //$webDir = realpath($this->container->getParameter('kernel.root_dir') . '/../web/');
        $directoryDocs = $this->container->getParameter('logo_directory'); // 'Images/';
        
        $oDate = new \DateTime('now');
        $sDate = $oDate->format('Ymd_his');
        
        if (isset($file) && !empty($file)) {
            $docMimetype = $file->getMimeType();
            $docOriginalName_ = $file->getClientOriginalName();
            $docOriginalName = str_replace(' ', '_', $docOriginalName_) ;
            $docTypeExtension = $file->getClientOriginalExtension();
            $docSize = $file->getClientSize();
            
            $file->move($directoryDocs, $sDate . '_' . $docOriginalName);
             
            $aValueL['docTitre'] = $sDate . '_' . $docOriginalName;
            $aValueL['docUrl'] = $directoryDocs . $sDate . '_' . $docOriginalName;
            $aValueL['docTypeExtension'] = $docTypeExtension;
            $aValueL['docMimeType'] = $docMimetype;
            $aValueL['docSize'] = $docSize;//en octets
        } else {
            $aValueL['error'] = "Taille du fichier dépasse la taille d'upload max du serveur." ;
        }
        
        return $aValueL;
    }

    /**
     * Send mail service
     * 
     * @param mixed $from : sender
     * @param mixed $to : recipients
     * @param mixed $subject : mail subject
     * @param mixed $body : mail body
     * @param mixed $templateMail : use to render mail body
     * @param mixed $templateMailParams : mail template parameters
     * @param mixed $attachment : mail attachement
     * @return int : 0 : mail not sent, 1 : mail sent
     */
    public function sendMail($from, $to, $subject, $body = "", $templateMail = null, $templateMailParams = array(), $attachment = null, $cc = "") {

        $cc = $this->redifineCc($to, $cc);

        if (!is_null($templateMail)) {
            $body = $this->templating->render($templateMail, $templateMailParams);
        }

        //Prepare message
        $message = \Swift_Message::newInstance()
                ->setSubject($subject)
                ->setFrom($from)
                ->setTo($to)
                ->setBody($body, 'text/html');

        if (!empty($cc)) {
            $message->setCc($cc);
        }

        //Attachement
        if ($attachment != null && $attachment != false) {
            $attachmentObject = \Swift_Attachment::fromPath($attachment);
            $message->attach($attachmentObject);
        }
        try {
            return $this->mailer->send($message);
        } catch (Exception $e) {
            return false;
        }
    }

    public function removeCarSpx($str) {
        $tabCar = array(" ", "\"", "\\", "^", "_", "-", "~", "#", "{", "}", "'", "[", "]", "(", ")", "@", "=", "/", ":", ",", "!", "?", "*", "&", "$", "€", "`", "|");
        return str_replace($tabCar, array(''), $str);
    }

    public function removeAccent($str) {
        $accents = array('À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'Ù', 'Ú', 'Û', 'Ü', 'Ý', 'à', 'á', 'â', 'ã', 'ä', 'å', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ð', 'ò', 'ó', 'ô', 'õ', 'ö', 'ù', 'ú', 'û', 'ü', 'ý', 'ÿ');
        $sans = array('A', 'A', 'A', 'A', 'A', 'A', 'C', 'E', 'E', 'E', 'E', 'I', 'I', 'I', 'I', 'O', 'O', 'O', 'O', 'O', 'U', 'U', 'U', 'U', 'Y', 'a', 'a', 'a', 'a', 'a', 'a', 'c', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'o', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'y', 'y');
        return str_replace($accents, $sans, $str);
    }

    public function generateRandom($taille, $number = FALSE) {
        if ($number) {
            $cars = "0123456789";
        } else {
            $cars = "azertyipqsdfghjklmwxcvbn123456789"; //Listes des caractères possibles
        }
        $mdp = '';
        $long = strlen($cars);
        srand((double) microtime() * 1000000); //Initialise le générateur de nombres aléatoires
        for ($i = 0; $i < $taille; $i++)
            $mdp = $mdp . substr($cars, rand(0, $long - 1), 1);
        return $mdp;
    }

    public function redifineCc($_to, $_cc) {
        $aTo = $aCc = array();
        if (!empty($_cc)) {
            if (is_array($_cc)) {
                foreach ($_cc as $cc) {
                    if (is_array($_to)) {
                        if (!in_array($cc, $_to)) {
                            array_push($aCc, $cc);
                        }
                    } else {
                        if ($cc != $_to) {
                            array_push($aCc, $cc);
                        }
                    }
                }
            } else {
                if (is_array($_to)) {
                    if (!in_array($_cc, $_to)) {
                        array_push($aCc, $_cc);
                    }
                } else {
                    if ($_cc != $_to) {
                        array_push($aCc, $cc);
                    }
                }
            }
            return $aCc;
        } else {
            return $_cc;
        }
    }

}

?>

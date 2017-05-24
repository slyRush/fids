<?php

namespace AppBundle\Controller;

use Sonata\AdminBundle\Controller\CRUDController as BaseController;

use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use Sonata\AdminBundle\Admin\AdminInterface;
use Sonata\AdminBundle\Datagrid\ProxyQueryInterface;
use Sonata\AdminBundle\Exception\ModelManagerException;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use Exporter\Source\DoctrineDBALConnectionSourceIterator;

class CRUDController extends BaseController
{

    /**
     * function rewrite exportAction de Sonata\AdminBundle\Controller\CRUDController
     * specification des colonnes à exporter à l'aide d'une requete SQL
     * @param Request $request
     * @return mixed
     */
    public function exportAction(Request $request)
    {

        $this->admin->checkAccess('export');

        $format = $request->get('format');

        $allowedExportFormats = (array) $this->admin->getExportFormats();

        if (!in_array($format, $allowedExportFormats)) {
            throw new \RuntimeException(
                sprintf(
                    'Export in format `%s` is not allowed for class: `%s`. Allowed formats are: `%s`',
                    $format,
                    $this->admin->getClass(),
                    implode(', ', $allowedExportFormats)
                )
            );
        }

        $filename = sprintf(
            'export_%s_%s.%s',
            strtolower(substr($this->admin->getClass(), strripos($this->admin->getClass(), '\\') + 1)),
            date('Y_m_d_H_i_s', strtotime('now')),
            $format
        );

        $dataSourceIterator = $this->admin->getDataSourceIterator();


        //DEBUT de rewrite ( Ceci est un exemple )
        //L'entité Fokontany à une relation avec l'entity Commune ( ManyToOne )
        //on veut afficher le nom du commune dans le fichier exporté
        //Table fonkotany (id,commune_id,code,nom)
        //Table commune (id,code,nom)

        $doctrineDatabaseConnection = $this->get('database_connection');

		$filter = $request->get('filter');
		 
        //si l'entité à exporter est egale à Fonkontany
        if($this->admin->getClass() == 'AppBundle\Entity\Fokontany'){

			$filter_nom_value = (isset($filter['nom']['value']) && $filter['nom']['value'] != "")? $filter['nom']['value'] : "";
            $filter_nom_type = (isset($filter['nom']['type']) && $filter['nom']['type'] != "")? $filter['nom']['type'] : "";

            $filter_code_value = (isset($filter['code']['value']) && $filter['code']['value'] != "")? $filter['code']['value'] : "";
            $filter_code_type = (isset($filter['code']['type']) && $filter['code']['type'] != "")? $filter['code']['type'] : "";

            // request SQL
            //ecrire la jointure entre fonkontany et commune ( auparavant on a seulement select * from fokontany )
            $sqlQuery = " select f.id, f.code, f.nom as fokontany, c.nom as commune from fokontany as f left join commune as c on c.id = f.commune_id where 1 ";
			
			if($filter_nom_value != ''){
                switch($filter_nom_type){
                    case '1': //contains
                        $sqlQuery .= " and f.nom like '%".$filter_nom_value."%' ";
                        break;
                    case '2': //does not contain
                        $sqlQuery .= " and f.nom not like '%".$filter_nom_value."%' ";
                        break;
                    case '3': //is equal to
                        $sqlQuery .= " and f.nom = '".$filter_nom_value."' ";
                        break;
                    default:
                        $sqlQuery .= " and f.nom like '%".$filter_nom_value."%' ";
                        break;
                }
            }

            if($filter_code_value != ''){
                switch($filter_code_type){
                    case '1': //contains
                        $sqlQuery .= " and f.code like '%".$filter_code_value."%' ";
                        break;
                    case '2': //does not contain
                        $sqlQuery .= " and f.code not like '%".$filter_code_value."%' ";
                        break;
                    case '3': //is equal to
                        $sqlQuery .= " and f.code = '".$filter_code_value."' ";
                        break;
                    default:
                        $sqlQuery .= " and f.code like '%".$filter_code_value."%' ";
                        break;
                }

            }

            // Preparing Source Data Iterator via DoctrineDBALConectionIterator
            $dataSourceIterator = new DoctrineDBALConnectionSourceIterator($doctrineDatabaseConnection, $sqlQuery);

        }

        //FIN de rewrite ( un exemple )

        return $this->get('sonata.admin.exporter')->getResponse(
            $format,
            $filename,
            $dataSourceIterator
        );
    }

}

<?php

namespace AppBundle\Controller;

use Sonata\AdminBundle\Controller\CRUDController as Controller;
use AppBundle\Entity\Programme;
use AppBundle\Repository\ProgrammeRepository;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormView;

class ProgrammeAdminController extends Controller
{
    /**
     * Create action.
     *
     * @return Response
     *
     * @throws AccessDeniedException If access is not granted
     */
    public function createAction()
    {
        $request = $this->getRequest();
        
        // the key used to lookup the template
        $templateKey = 'edit';

        $this->admin->checkAccess('create');

        $class = new \ReflectionClass($this->admin->hasActiveSubClass() ? $this->admin->getActiveSubClass() : $this->admin->getClass());

        if ($class->isAbstract()) {
            return $this->render(
                'SonataAdminBundle:CRUD:select_subclass.html.twig',
                array(
                    'base_template' => $this->getBaseTemplate(),
                    'admin' => $this->admin,
                    'action' => 'create',
                ),
                null,
                $request
            );
        }

        $object = $this->admin->getNewInstance();
        
        $preResponse = $this->preCreate($request, $object);
        if ($preResponse !== null) {
            return $preResponse;
        }

        $this->admin->setSubject($object);

        $form = $this->admin->getForm();
        $form->setData($object);
        $form->handleRequest($request);
        
        if ($form->isSubmitted()) {
            //TODO: remove this check for 4.0
            if (method_exists($this->admin, 'preValidate')) {
                $this->admin->preValidate($object);
            }
            
            $isFormValid = $form->isValid();

            // persist if the form was valid and if in preview mode the preview was approved
            if ($isFormValid && (!$this->isInPreviewMode() || $this->isPreviewApproved())) {
                $this->admin->checkAccess('create', $object);



                try {
                    
                    $object = $this->admin->create($object);
                    
                    /* relation programme comptoir et porte */
                    $uniqId = $request->query->get('uniqid') ;
                    $req = $request->request->get($uniqId) ;
                    $programManager = $this->get('program.manager');
                    //condition de validation du formulaire
                    // creer dans le programme manager une validation selon $req
                    // $id = $req['idVols']
                    //getTypeVolBy($id)
                    //Si typevol == 'national' ....
                     $subValidation = $programManager->validateOnPost($req);
                    /*echo '<pre>';
                    print_r($subValidation);
                    echo'</pre>';die;*/
                    if ($subValidation['isValid']){
                        if(isset($req['comptoir'])){
                            $programManager->manageRelation($req['comptoir'], $object, "Comptoir") ;
                        }
                        if(isset($req['porte'])){
                            $programManager->manageRelation($req['porte'], $object, "Porte") ;
                        }
                        /* relation programme comptoir et porte */

                        //Gestion status terminer
                        $programManager->manageStatusTerminer($object) ;

                        if ($this->isXmlHttpRequest()) {
                            return $this->renderJson(array(
                                'result' => 'ok',
                                'objectId' => $this->admin->getNormalizedIdentifier($object),
                            ), 200, array());
                        }

                        $this->addFlash(
                            'sonata_flash_success',
                            $this->trans(
                                'flash_create_success',
                                array('%name%' => $subValidation['error']),
                                'SonataAdminBundle'
                            )
                        );

                    }else {
                        $this->addFlash(
                            'sonata_flash_error',
                            $this->trans(
                                'flash_create_error',
                                array('%name%' => $subValidation['error']),
                                'SonataAdminBundle'
                            )
                        );
                    }


                    // redirect to edit mode
                    return $this->redirectTo($object);
                } catch (ModelManagerException $e) {
                    $this->handleModelManagerException($e);

                    $isFormValid = false;
                }
            }

            // show an error message if the form failed validation
            if (!$isFormValid) {
                if (!$this->isXmlHttpRequest()) {
                    $this->addFlash(
                        'sonata_flash_error',
                        $this->trans(
                            'flash_create_error',
                            array('%name%' => $this->escapeHtml($this->admin->toString($object))),
                            'SonataAdminBundle'
                        )
                    );
                }
            } elseif ($this->isPreviewRequested()) {
                // pick the preview template if the form was valid and preview was requested
                $templateKey = 'preview';
                $this->admin->getShow();
            }
        }

        $formView = $form->createView();
        
        $this->setFormTheme($formView, $this->admin->getFormTheme());

        return $this->render($this->admin->getTemplate($templateKey), array(
            'action' => 'create',
            'form' => $formView,
            'object' => $object,
        ), null);
    }
    
    /**
     * Sets the admin form theme to form view. Used for compatibility between Symfony versions.
     *
     * @param FormView $formView
     * @param string   $theme
     */
    private function setFormTheme(FormView $formView, $theme)
    {
        $twig = $this->get('twig');

        try {
            $twig
                ->getRuntime('Symfony\Bridge\Twig\Form\TwigRenderer')
                ->setTheme($formView, $theme);
        } catch (\Twig_Error_Runtime $e) {
            // BC for Symfony < 3.2 where this runtime not exists
            $twig
                ->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')
                ->renderer
                ->setTheme($formView, $theme);
        }
    }
    
    /**
     * Edit action.
     *
     * @return Response
     *
     * @throws AccessDeniedException If access is not granted
     */
    public function editAction($id = null)
    {
        $request = $this->getRequest();
        // the key used to lookup the template
        $templateKey = 'edit';

        $id = $request->get($this->admin->getIdParameter());
        $object = $this->admin->getObject($id);

        if (!$object) {
            throw $this->createNotFoundException(sprintf('unable to find the object with id : %s', $id));
        }

        $this->admin->checkAccess('edit', $object);

        $preResponse = $this->preEdit($request, $object);
        if ($preResponse !== null) {
            return $preResponse;
        }

        $this->admin->setSubject($object);

        /** @var $form Form */
        $form = $this->admin->getForm();
        $form->setData($object);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            //TODO: remove this check for 4.0
            if (method_exists($this->admin, 'preValidate')) {
                $this->admin->preValidate($object);
            }
            
            $isFormValid = $form->isValid();

            // persist if the form was valid and if in preview mode the preview was approved
            if ($isFormValid && (!$this->isInPreviewMode() || $this->isPreviewApproved())) {
                try {
                    $object = $this->admin->update($object);
                    
                    /* relation programme comptoir et porte */
                    $uniqId = $request->query->get('uniqid') ;
                    $req = $request->request->get($uniqId) ;
                    $programManager = $this->get('program.manager');
                    if(isset($req['comptoir'])){
                        $programManager->manageRelation($req['comptoir'], $object, "Comptoir") ;
                    }
                    if(isset($req['porte'])){
                        $programManager->manageRelation($req['porte'], $object, "Porte") ;
                    }
                    /* relation programme comptoir et porte */
                    //Gestion status terminer
                    $programManager->manageStatusTerminer($object) ;
                    
                    if ($this->isXmlHttpRequest()) {
                        return $this->renderJson(array(
                            'result' => 'ok',
                            'objectId' => $this->admin->getNormalizedIdentifier($object),
                            'objectName' => $this->escapeHtml($this->admin->toString($object)),
                        ), 200, array());
                    }

                    $this->addFlash(
                        'sonata_flash_success',
                        $this->trans(
                            'flash_edit_success',
                            array('%name%' => $this->escapeHtml($this->admin->toString($object))),
                            'SonataAdminBundle'
                        )
                    );

                    // redirect to edit mode
                    return $this->redirectTo($object);
                } catch (ModelManagerException $e) {
                    $this->handleModelManagerException($e);

                    $isFormValid = false;
                } catch (LockException $e) {
                    $this->addFlash('sonata_flash_error', $this->trans('flash_lock_error', array(
                        '%name%' => $this->escapeHtml($this->admin->toString($object)),
                        '%link_start%' => '<a href="'.$this->admin->generateObjectUrl('edit', $object).'">',
                        '%link_end%' => '</a>',
                    ), 'SonataAdminBundle'));
                }
            }

            // show an error message if the form failed validation
            if (!$isFormValid) {
                if (!$this->isXmlHttpRequest()) {
                    $this->addFlash(
                        'sonata_flash_error',
                        $this->trans(
                            'flash_edit_error',
                            array('%name%' => $this->escapeHtml($this->admin->toString($object))),
                            'SonataAdminBundle'
                        )
                    );
                }
            } elseif ($this->isPreviewRequested()) {
                // enable the preview template if the form was valid and preview was requested
                $templateKey = 'preview';
                $this->admin->getShow();
            }
        }

        $formView = $form->createView();
        // set the theme for the current Admin Form
        $this->setFormTheme($formView, $this->admin->getFormTheme());

        return $this->render($this->admin->getTemplate($templateKey), array(
            'action' => 'edit',
            'form' => $formView,
            'object' => $object,
        ), null);
    }
}
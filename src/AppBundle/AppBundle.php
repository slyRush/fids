<?php

namespace AppBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class AppBundle extends Bundle
{
    /**
     * fonction utilis�e pour rewriter le Sonata\AdminBundle\Controller\CRUDController
     *
     */
    public function getParent()
    {
        return 'SonataAdminBundle';
    }
}

<?php
namespace MyApp\MobileBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Description of SanteController
 *
 * @author leonardc
 */
class SanteController extends Controller {
   
    public function SanteIndexAction()
    {
        return $this->render('MyAppMobileBundle:MobileSante:index.html.twig', array(
                
           
        ));
    }
}

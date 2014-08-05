<?php
namespace MyApp\MobileBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Description of CorpoController
 *
 * @author leonardc
 */
class CorpoController extends Controller {
    
    public function CorpoIndexAction()
    {
        return $this->render('MyAppMobileBundle:MobileCorpo:index.html.twig', array(
                
           
        ));
    }
}

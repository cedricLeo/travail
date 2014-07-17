<?php
namespace MyApp\MobileBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Description of AttraitController
 *
 * @author leonardc
 */
class AttraitController extends Controller {
    
    public function AttraitIndexAction()
    {
        return $this->render('MyAppMobileBundle:MobileAttrait:index.html.twig', array(
                
           
        ));
    }
    
    
}

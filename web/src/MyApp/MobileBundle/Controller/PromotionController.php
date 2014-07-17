<?php
namespace MyApp\MobileBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Description of PromotionController
 *
 * @author leonardc
 */
class PromotionController extends Controller {
    
    public function PromotionIndexAction()
    {
        return $this->render('MyAppMobileBundle:MobilePromotion:index.html.twig', array(
                
           
        ));
    }
}

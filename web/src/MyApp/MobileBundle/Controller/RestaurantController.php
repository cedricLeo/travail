<?php
namespace MyApp\MobileBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Description of RestaurantController
 *
 * @author leonardc
 */
class RestaurantController extends Controller {
    
    public function RestaurantIndexAction()
    {
        return $this->render('MyAppMobileBundle:MobileRestaurant:index.html.twig', array(
                
           
        ));
    }
    
    
}

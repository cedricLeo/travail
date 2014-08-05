<?php
namespace MyApp\MobileBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class DefaultController extends Controller
{
    /**
     * Affiche la page d'accueil
     */
    public function indexAction()
    {
        return $this->render('MyAppMobileBundle:Mobile:index.html.twig');
    }
    
    /**
    * Contrôle le contenu des éditeurs CKE valide et retourne au controller les données
    * 
    */
   public function getSecureData($text)
   {       
        $text = trim($text);
        $tab = ["<?php>", "<php", "<?", "?>", "<script>", "</script>", "select", "SELECT", "INSERT", "insert", "UPDATE", "update", "DELETE", "delete", "root", "*", "%", ";", "{", "}", "[", "]", "$", "<", ">", "1=1"];
        $text = str_replace($tab, " ", $text);		
        return $text;
   }
   
   /**
    * Service pour l'envoie de courriel pour la fiche détaillée du client
    */
   public function sendMailAction()
   {
       $mailer = $this->get("courriel");
       $mailer->send("leonard.cedrioc7@gmail.com");
   }
    
}

<?php
namespace MyApp\AdminBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use MyApp\GlobalBundle\Controller\ControleDataSecureController;
use JMS\SecurityExtraBundle\Annotation\Secure;

/**
 * 
 * @author cedric
 * 
 * @Secure(roles="ROLE_SUPER_ADMIN")
 *
 */
class Quebec_en_saisonController extends Controller
{

/*####################################################################################*/
/*############### SECTION TYPES DE SAISONS ###########################################*/
/*####################################################################################*/
	/**
	 * Page du tableau de bord pour afficher les types de saisons
	 */
	public function typeSaisonAction()
	{
	
	}
	
	/**
	 * Page du tableau de bord pour ajouter un type de saison
	 */
	public function addTypeSaisonAction()
	{
	
	}
	
	/**
	 * Page du tableau de bord pour modifier un type de saison
	 */
	public function updateTypeSaisonAction($id)
	{
	
	}
	
	/**
	 * Suppr�ssion d'un type de saison
	 */
	public function deleteTypeSaisonAction($id)
	{
	
	}
/*####################################################################################*/
/*############### TYPES PAGES SAISONS ################################################*/
/*####################################################################################*/
	/**
	 * Page du tableau de bord pour afficher les types pages saisons
	 */
	public function typePageSaisonAction()
	{
	
	}
	
	/**
	 * Page du tableau de bord pour ajouter un type de page
	 */
	public function addTypePageSaisonAction()
	{
	
	}
	
	/**
	 * Page du tableau de bord pour modifier un type de page
	 */
	public function updateTypePageSaisonAction($id)
	{
	
	}
	
	/**
	 * Suppr�ssion d'un type de page
	 */
	public function deleteTypePageSaisonAction($id)
	{
	
	}
/*####################################################################################*/
/*############### PAGES STATIQUES ####################################################*/
/*####################################################################################*/
	/**
	 * Page du tableau de bord pour afficher les pages statiques
	 */
	public function pageStatiqueAction()
	{
	
	}
	
	/**
	 * Page du tableau de bord pour ajouter une page statique
	 */
	public function addPageStatiqueAction()
	{
	
	}
	
	/**
	 * Page du tableau de bord pour modifier une page statique
	 */
	public function updatePageStatiqueAction($id)
	{
	
	}
	
	/**
	 * Suppr�ssion d'une page statique
	 */
	public function deletePageStatiqueAction($id)
	{
	
	}	
/*####################################################################################*/
/*############### SAISONS ############################################################*/
/*####################################################################################*/
	/**
	 * Page du tableau de bord pour afficher les saisons
	 */
	public function saisonAction()
	{
	
	}
	
	/**
	 * Page du tableau de bord pour ajouter une saison
	 */
	public function addSaisonAction()
	{
	
	}
	
	/**
	 * Page du tableau de bord pour modifier une saison
	 */
	public function updateSaisonAction($id)
	{
	
	}
	
	/**
	 * Suppr�ssion d'une saison
	 */
	public function deleteSaisonAction($id)
	{
	
	}
/*####################################################################################*/
/*############### APER�U EN FRAN�AIS #################################################*/
/*####################################################################################*/
	/**
	 * Page du tableau de bord pour visualiser la page en fran�ais
	 */
	public function previewFrenchAction()
	{
	
	}
	
	/**
	 * Page du tableau de bord pour �diter
	 */
	public function editPageFrenchAction()
	{
	
	}
/*####################################################################################*/
/*############### APER�U EN ANGLAIS ##################################################*/
/*####################################################################################*/
	/**
	 * Page du tableau de bord pour visualiser la page en anglais
	 */
	public function previewAnglaisAction()
	{
	
	}
	
	/**
	 * Page du tableau de bord pour �diter 
	 */
	public function editePageAnglaisAction()
	{
	
	}
	
}
<?php
namespace MyApp\AdminBundle\Forms;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Doctrine\Common\Collections\ArrayCollection;
use MyApp\GlobalBundle\Entity\Politique_fr;

/**
 * 
 * @author leonardc
 * 
 * Classe pour la génération du formulaire de création et modification d'un hébergement 
 *
 */
class AddHebergementForm extends AbstractType
{
	private $role = "";
	
	public function buildForm(FormBuilder $builder, array $options)
	{
		$builder
		//Relation avec les catégories d'hébergement
		->add('categorie_hebergement_id', 'entity', array('class' => 'MyAppGlobalBundle:Categories_hebergements', 
														  'required' => true,
														  'multiple' => true,
														  'query_builder' => function(EntityRepository $er){
														   return $er->createQueryBuilder('c')->orderBy('c.nom_fr', 'ASC');
														   }))
		//Relation avec les provinces											   
		->add('province_id', 'entity', array('class' => 'MyAppGlobalBundle:Provinces_etats', 'property' => 'nom_fr','required' => true))
		//Relation avec les accomptes
		->add('acompte_id', 'entity', array('class' => 'MyAppGlobalBundle:Acomptes', 'property' => 'nom_fr','required' => true))
		//Relation avec les affiliations
		->add('affiliation_id', 'entity', array('class' => 'MyAppGlobalBundle:Affiliations', 
												'required' => false,
												'multiple' => true,
												'query_builder' => function(EntityRepository $er){
												return $er->createQueryBuilder('ha')->orderBy('ha.nom_fr', 'ASC');
												}))
		//Relation avec les activités										 	  
		/*->add('hebergement_activite_id', 'entity', array('class' => 'MyAppGlobalBundle:Hebergements_activites', 
														 'required' => false, 
				  										 'multiple' => true, 
														 'query_builder' => function(EntityRepository $er){
														 return $er->createQueryBuilder('ha')->orderBy('ha.nom_fr', 'ASC');
													 	  }))*/
		//Relation avec les styles d'hébergements
		/*->add('style_hebergement_id', 'entity', array('class' => 'MyAppGlobalBundle:Styles_hebergements', 
													  'required' => true, 
													  'multiple' => true,
													  'query_builder' => function(EntityRepository $er){
													  return $er->createQueryBuilder('sh')->orderBy('sh.nom_fr', 'ASC');
													  }))
		//Relation avec les services
		->add('hebergement_service_id', 'entity', array('class' => 'MyAppGlobalBundle:Hebergements_services', 
														'required' => true, 
														'multiple' => true,
														'query_builder' => function(EntityRepository $er){
														return $er->createQueryBuilder('hs')->orderBy('hs.nom_fr','ASC');
													  }))*/
		//Relation avec les devises
		->add('devise_id', 'entity', array('class' => 'MyAppGlobalBundle:Devises', 'property' => 'abreviation', 'required' => true, 'multiple' => true))
		//Relation avec les cotations
		->add('cotation_id', 'entity', array('class' => 'MyAppGlobalBundle:Cotations', 
											 'required' => false,
											 'query_builder' => function(EntityRepository $er){
											 return $er->createQueryBuilder('co')->orderBy('co.valeur','ASC');
											  }))
		//Relation avec les classifications
		->add('classification_id', 'entity', array('class' => 'MyAppGlobalBundle:Classifications', 'property' => 'valeur', 'required' => true))
		//Relation avec les modes de paiements
		/*->add('hebergement_paiements_id', 'entity', array('class' => 'MyAppGlobalBundle:Modes_paiements', 
														  'required' => true,
														  'multiple' => true,
														  'query_builder' => function(EntityRepository $er){
														  return $er->createQueryBuilder('mp')->orderBy('mp.nom_fr', 'ASC');
													  }))*/
		->add('utilisateur', 'entity', array('class' => 'MyAppGlobalBundle:Utilisateur',
													    'required' => true,
													    'query_builder' => function(EntityRepository $er){
													     return $er->createQueryBuilder('c')
													  			->where('c.role = :role ')
													  			->setParameter('role', $this->role)
													  			->orderBy('c.nom', 'ASC');
													  }))
		->add('nom_fr', 'text')
		->add('nom_en', 'text')
		->add('nom_abrege_fr', 'text', array("required" => false))
		->add('nom_abrege_en', 'text', array("required" => false))
		->add('adresse', 'text')
		->add('code_postal', 'text')
		->add('telephone', 'text')
		->add('telephone2', 'text', array("required" => false))
		->add('telephone_poste', 'text', array("required" => false))
		->add('telecopieur', 'text', array("required" => false))
		->add('sans_frais', 'text', array("required" => false))
		->add('courriel', 'email', array("required" => false))
		->add('siteweb', 'text', array("required" => false))
		->add('latitude', 'text')
		->add('longitude', 'text')
		->add('repertoire_fr', 'text')
		->add('repertoire_en', 'text')
		//->add('logo_doctrine', 'file', array("required" => false))
		//->add('texte_description_fr', 'textarea', array("required" => false))
		//->add('texte_description_en', 'textarea', array("required" => false))
		->add('texte_resume_fr', 'textarea', array("required" => false))
		->add('texte_resume_en', 'textarea', array("required" => false))
		->add('reservit_id', 'text', array("required" => false))
		->add('actif', 'choice', array('choices' => array('0' => 'Non actif', '1' => 'Actif')))
		->add('etablissement_saisonnier', 'checkbox', array("required" => false))
		->add('adsense', 'checkbox', array("required" => false))
		->add('corporatif', 'checkbox', array("required" => false))
		->add('tarif_preferentiel', 'checkbox', array("required" => false))
		//->add('nouveau_membre', 'checkbox', array("required" => false))
		->add('meta_titre_fr', 'text', array("required" => false))
		->add('meta_titre_en', 'text', array("required" => false))
		->add('meta_keywords_fr', 'text', array("required" => false))
		->add('meta_keywords_en', 'text', array("required" => false))
		->add('meta_description_fr', 'textarea', array("required" => false))
		->add('meta_description_en', 'textarea', array("required" => false))
		//->add('nombre_chambres_chalets', 'integer')
		->add('nombre_etages', 'text', array("required" => true))
		->add('aprouver', 'checkbox', array('required' => false))
		->add('checkin', 'text', array("required" => true))
		->add('checkout', 'text', array("required" => true))
		->add('email_corporatif', 'email', array("required" => false))
		//->add('photo_payante_doctrine', 'file', array("required" => false))
		//->add('photo_categorie_payante_doctrine', 'file', array("required" => false))
		->add('optvisibilite_grande_photo', 'checkbox', array("required" => false))
		->add('optvisibilite_photo_categorie', 'checkbox', array("required" => false))
		->add('optvisibilite_nos_suggestions', 'checkbox', array("required" => false))
		->add('optvisibilite_criteres_semblables', 'checkbox', array("required" => false))
		->add('optvisibilite_nouveautes', 'checkbox', array("required" => false))
		->add('optvisibilite_incontournables', 'checkbox', array("required" => false))
		/*->add('referencement_payant', 'checkbox', array("required" => false))
		->add('referencement_mini_site_update_souvent', 'checkbox', array("required" => false))*/
		->add('facebook_fr', 'text', array("required" => false))
		->add('facebook_en', 'text', array("required" => false))
		->add('twitter_fr', 'text', array("required" => false))
		->add('twitter_en', 'text', array("required" => false))
		->add('google_plus_fr', 'text', array("required" => false))
		->add('google_plus_en', 'text', array("required" => false))
		/*->add('galerie_hebergement', 'collection', array( 'type' => new Galerie_hebergementType(),
														  'allow_add' => true,
														  'allow_delete' => true,
						 								 ))*/
		->add('politique_hebergement_fr', new AddPolitiqueFrType(), array("required" => false))
		->add('politique_hebergement_en', new AddPolitiqueEnType(), array("required" => false))
		;											  
	}
	
	public function getDefaultOptions(array $options)
	{
		return array(
				'data_class' => 'MyApp\GlobalBundle\Entity\Hebergements',
		);
	}
	
	public function __construct($role)
	{
		$this->role = $role;
	}

	public function getName()
	{
		return 'add_hebergement';
	}
}
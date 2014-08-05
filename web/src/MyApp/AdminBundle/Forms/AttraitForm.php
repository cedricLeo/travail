<?php
namespace MyApp\AdminBundle\Forms;
use MyApp\GlobalBundle\Entity\Attraits;
use Symfony\Component\Form\FormError;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class AttraitForm extends AbstractType
{
	private $role = "";
	
	public function buildForm(FormBuilder $builder, array $options)
	{
		$builder
                ->add('soins_sante_id', 'entity', array('class' => 'MyAppGlobalBundle:Soins_sante',
									    		'required' => false,
	    										'multiple' => true,
									    		'query_builder' => function(EntityRepository $er){
									    		return $er->createQueryBuilder('c')->orderBy('c.nom_fr', 'ASC');
								    			}))
		->add('cuisine_id', 'entity', array('class' => 'MyAppGlobalBundle:Cuisines', 'property' => 'nomfr', "multiple" => true, "required" => false))
		->add('categorie_attrait', 'entity', array('class' => 'MyAppGlobalBundle:Attraits_categories', 'multiple' => true, 'property' => 'nomfr', 'required' => true))
		->add('hebergement_id', 'entity', array('class' => 'MyAppGlobalBundle:Hebergements', 'property' => 'nomfr', "required" => false))
		->add('attrait_service_id', 'entity', array('class' => 'MyAppGlobalBundle:Attraits_services', 'property' => 'nomfr','required' => false, "multiple" => true))
		//->add('paiement_id', 'entity', array('class' => 'MyAppGlobalBundle:Modes_paiements', 'property' => 'nomfr','required' => true, "multiple" => true))
		->add('devise_id', 'entity', array('class' => 'MyAppGlobalBundle:Devises', 'property' => 'abreviation','required' => true, "multiple" => true))
		->add('qcs_festival_attrait_id', 'entity', array('class' => 'MyAppGlobalBundle:Qcs_festival_attraits', 'property' => 'titrefr','required' => false, "multiple" => true))
		->add('qcs_echo_attrait_id', 'entity', array('class' => 'MyAppGlobalBundle:Qcs_echos_attraits', 'property' => 'titrefr', 'required' => false, "multiple" => true))
		->add('attrait_activite_id', 'entity', array('class' => 'MyAppGlobalBundle:Attraits_activites', 'property' => 'nom_fr', "multiple" => true, "required" => false))
		->add('qcs_thematique_attrait_id', 'entity', array('class' => 'MyAppGlobalBundle:Qcs_thematiques_attraits', 'property' => 'titrefr', 'required' => false, "multiple" => true))
		->add('province_id', 'entity', array('class' => 'MyAppGlobalBundle:Provinces_etats', 'property' => 'nomfr','required' => true))
		/*->add('region_id', 'entity', array('class' => 'MyAppGlobalBundle:Regions', 'property' => 'nomfr','required' => true))
		->add('zone_id', 'entity', array('class' => 'MyAppGlobalBundle:Zones', 'property' => 'nomfr','required' => true))
		->add('ville_id', 'entity', array('class' => 'MyAppGlobalBundle:Villes', 'property' => 'nomfr','required' => true))*/
		->add('utilisateur', 'entity', array('class' => 'MyAppGlobalBundle:Utilisateur',
											'required' => true,
											'query_builder' => function(EntityRepository $er){
											return $er->createQueryBuilder('c')
											          ->where('c.role = :role')
											          ->setParameter('role',$this->role)
                                                                                                  ->orderBy('c.nom', 'ASC');
											}))
		/*->add('type_soins_id', 'entity', array('class' => 'MyAppGlobalBundle:Types_soins_sante',
											'required' => false,
											'multiple' => true,
											'query_builder' => function(EntityRepository $er){
											return $er->createQueryBuilder('c')->orderBy('c.nom_fr', 'ASC');
											}))*/
		->add('nom_fr', 'text', array("required" => true))
		->add('nom_en', 'text')
		->add('repertoire_fr', 'text')
		->add('repertoire_en', 'text')
		->add('capacite', 'text', array("required" => true))
		->add('tarif_attrait', 'text', array("required" => true))
		//->add('image_doctrine', 'file', array("required" => false))
		->add('telephone', 'text')
		->add('telephone2', 'text', array('required' => false))
		->add('telephone_poste', 'text', array('required' => false))
		->add('sans_frais', 'text', array('required' => false))
		->add('telecopieur', 'text', array('required' => false))
		->add('siteweb', 'text', array('required' => false))
		->add('courriel', 'text', array('required' => false))
		->add('page_facebook_fr', 'text', array("required" => false))
		->add('page_facebook_en', 'text', array("required" => false))
		->add('twitter_fr', 'text', array("required" => false))
		->add('twitter_en', 'text', array("required" => false))
		->add('google_plus_fr', 'text', array("required" => false))
		->add('google_plus_en', 'text', array("required" => false))
		//->add('texte_description_fr', 'textarea', array("required" => false))
		//->add('texte_description_en', 'textarea', array("required" => false))
		->add('periode_pour_attrait', 'checkbox', array("required" => false))
		/*->add('emplacements_0_service_camping', 'integer', array("required" => false))
		->add('emplacements_1_service_camping', 'integer', array("required" => false))
		->add('emplacements_2_services_camping', 'integer', array("required" => false))
		->add('emplacements_3_services_camping', 'integer', array("required" => false))*/
		->add('approuve', 'checkbox', array("required" => false))
		->add('actif', 'choice', array('choices' => array('0' => 'Non actif', '1' => 'Actif')))
		->add('express', 'checkbox', array("required" => false))
		->add('payant', 'checkbox', array("required" => false))
		->add('adresse_web_cliquable', 'checkbox', array("required" => false))
		->add('meta_titre_fr', 'text', array("required" => true))
		->add('meta_titre_en', 'text', array("required" => true))
		->add('metakeywords_fr', 'text')
		->add('metakeywords_en', 'text')
                //->add('photo_payante_doctrine', 'file', array("required" => false))
		->add('metadescription_fr', 'textarea')
		->add('metadescription_en', 'textarea')
		->add('optvisibilite_grande_photo', 'checkbox', array("required" => false))
		->add('optvisibilite_photo_categorie', 'checkbox', array("required" => false))
		->add('optvisibilite_nos_suggestions', 'checkbox', array("required" => false))
		->add('optvisibilite_proximite', 'checkbox', array("required" => false))
		->add('optvisibilite_lien_hebergement', 'checkbox', array("required" => false))
		->add('optvisibilite_incontournables', 'checkbox', array("required" => false))	
		->add('adresse', 'text')
		->add('code_postal', 'text')
		->add('afficher_restaurant', 'checkbox', array("required" => false))
		->add('latitude', 'text', array("required" => true))
		->add('longitude', 'text', array("required" => true))
		//->add('logo_doctrine', 'file', array("required" => false))
		//Formulaire imbriqué pour les horaires.
		->add('lundi_matin_ete', new HoraireFicheClientForm(), array("required" => false))
                //Galerie photo
		/*->add('galerie_attraits', 'collection', array('type' 		 => new Galerie_attraitType(),
											   		  'allow_add' 	 => true,
													  'allow_delete' => true,
													  'required'	 => true,
													  ))*/
		->add('politique_attrait_fr', new AddPolitiqueAttraitFrType(), array("required" => false))
		->add('politique_attrait_en', new AddPolitiqueAttraitEnType(), array("required" => false))
		->add('description_attrait_fr', new AddTextesAttraitFrType(), array("required" => false))
		->add('description_attrait_en', new AddTextesAttraitEnType(), array("required" => false))
		;
	}
	
	public function getDefaultOptions(array $options)
	{
		return array(
				'data_class' => 'MyApp\GlobalBundle\Entity\Attraits',
		);
	}
	
	public function __construct($role)
	{
		$this->role = $role;
	}
	

	public function getName()
	{
		return 'add_attrait';
	}
}
<?php
namespace MyApp\AdminBundle\Forms;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Doctrine\Common\Collections\ArrayCollection;

class TexteHebergementFicheENForm extends AbstractType
{
	public function buildForm(FormBuilder $builder, array $options)
	{
		$builder
		//Catégories pour l'hébergement
		//Affiliations pour l'hébergement												  
		->add('affiliation_id', 'entity', array('class' => 'MyAppGlobalBundle:Affiliations',
														   'required' => false,
														   'multiple' => true,
														   'query_builder' => function(EntityRepository $er){
														  return $er->createQueryBuilder('a')->orderBy('a.nom_en','ASC');
														  }))
                //Relation avec les styles d'hébergements
		->add('style_hebergement_id', 'entity', array('class' => 'MyAppGlobalBundle:Styles_hebergements', 
													  'required' => true, 
													  'multiple' => true,
													  'query_builder' => function(EntityRepository $er){
													  return $er->createQueryBuilder('sh')->orderBy('sh.nom_en', 'ASC');
													  }))
                //Relation avec les services                                                                                     
                ->add('hebergement_service_id', 'entity', array('class' => 'MyAppGlobalBundle:Hebergements_services', 
														'required' => true, 
														'multiple' => true,
                                                                                                                'expanded' => true,
														'query_builder' => function(EntityRepository $er){
														return $er->createQueryBuilder('hs')->orderBy('hs.nom_en','ASC');
													  }))
                //Relation avec les modes de paiements
		->add('hebergement_paiements_id', 'entity', array('class' => 'MyAppGlobalBundle:Modes_paiements', 
														  'required' => true,
														  'multiple' => true,
														  'query_builder' => function(EntityRepository $er){
														  return $er->createQueryBuilder('mp')->orderBy('mp.nom_en', 'ASC');
													  }))
                 //Relation avec les activités                                                                                         
                ->add('hebergement_activite_id', 'entity', array('class' => 'MyAppGlobalBundle:Hebergements_activites', 
														 'required' => false, 
				  										 'multiple' => true, 
                                                                                                                 'expanded' => true,
														 'query_builder' => function(EntityRepository $er){
														 return $er->createQueryBuilder('ha')->orderBy('ha.nom_en', 'ASC');
													 	  }))                                                                                      
		->add('texte_resume_fr', 'textarea', array("required" => false))
		->add('texte_resume_en', 'textarea', array("required" => false))
		->add('texte_description_fr', 'textarea', array("required" => false))
		->add('texte_description_en', 'textarea', array("required" => false))
		->add('nombre_etages', 'text', array("required" => true))
		->add('nombre_chambre', 'text', array("required" => false))
		->add('date_debut_saisonnier', 'text', array("required" => false))
		->add('date_fin_saisonnier', 'text', array("required" => false))
		->add('photo_payante', 'file', array("required" => false))
		->add('photo_categorie_payante', 'file', array("required" => false))
		->add('logo', 'file', array("required" => false))
                ->add('checkin', 'text', array("required" => true))
		->add('checkout', 'text', array("required" => true))
                 ->add('prix_a_partir', 'text', array("required" => true))                                                                                                      
		//FORMULAIRES IMBRIQUÉS
		//Galerie photo
		->add('galerie_hebergement', 'collection', array( 'type' => new Galerie_hebergementType(),
														  'allow_add' => true,
														  'allow_delete' => true,
														  'required' => false,
						 								 ))
		//Textes descriptifs version fr
		->add('description_hebergement_fr', new AddDescriptionFrType(), array("required" => false))
		//Textes descriptifs version en
		->add('description_hebergement_en', new AddDescriptionEnType(), array("required" => false))
		//Textes politiques version fr
		->add('politique_hebergement_fr', new AddPolitiqueClientFrType(), array("required" => false))
		//Textes politiques version en
		->add('politique_hebergement_en', new AddPolitiqueClientEnType(), array("required" => false))
		//Calendrier pour les hautes dates hautes saison
		->add('calendrier', 'collection', array( 'type' => new AddDateHauteSaisonType(),
												 'allow_add' => true,
												 'allow_delete' => true,
												 'required'	=> false,
			  									));
	}
	
	public function getDefaultOptions(array $options)
	{
		return array(
				'data_class' => 'MyApp\GlobalBundle\Entity\Hebergements',
		);
	}

	public function getName()
	{
		return 'add_hebergement';
	}
}
<?php
namespace MyApp\AdminBundle\Forms;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use MyApp\GlobalBundle\Entity\Types_chambres;

/**
 * 
 * @author leonardc
 * 
 * Formulaire pour l'ajout et modification des chambres
 *
 */
class AddChambresForm extends AbstractType
{
	public function buildForm(FormBuilder $builder, array $options)
	{
		$builder
		->add('nom_fr', 'text', array("required" => true))
		->add('nom_en', 'text', array("required" => true))
		->add('quantite', 'text', array("required" => true))
		->add('description_fr', 'textarea', array("required" => false))
		->add('description_en', 'textarea', array("required" => false))
		->add('max_personne', 'text', array('required' => true))
		->add('actif', 'checkbox', array("required" => false))
                ->add('reserver_chambre_en_ligne', 'checkbox', array("required" => false))
		->add('tarif_min_basse_saison', 'text', array("required" => false))
		->add('tarif_max_basse_saison', 'text', array("required" => false))
		->add('tarif_min_haute_saison', 'text', array("required" => false))
		->add('tarif_max_haute_saison', 'text', array("required" => false))
		//->add('tarif_min_relache', 'text', array("required" => false))
		//->add('tarif_max_relache', 'text', array("required" => false))
		->add('description_tarif_basse_saison_fr', 'textarea', array("required" => false))
		->add('description_tarif_basse_saison_en', 'textarea', array("required" => false))
		->add('description_tarif_haute_saison_fr', 'textarea', array("required" => false))
		->add('description_tarif_haute_saison_en', 'textarea', array("required" => false))
		->add('texte_presentation_fr', 'textarea', array("required" => false))
		->add('texte_presentation_en', 'textarea', array("required" => false))
		->add('tarif_preferentiel', 'checkbox', array("required" => false))
		->add('dejeuner_continental', 'checkbox', array("required" => false))
		->add('dejeuner_americain', 'checkbox', array("required" => false))
		->add('dejeuner_buffet', 'checkbox', array("required" => false))
		->add('dejeuner_non_compris', 'checkbox', array("required" => false))
		->add('dejeuner_non_compris', 'checkbox', array("required" => false))
		->add('ordre_affichage', 'text', array("required" => false))
		->add('photo1_doctrine', 'file', array("required" => false))
		//Relation avec le type de chambre
		->add('type_chambre_id', 'entity', array('class'    => 'MyAppGlobalBundle:Types_chambres', 
												 'required' => true, 
												 'multiple' => true,
											     'query_builder' => function(EntityRepository $er){
												 return $er->createQueryBuilder('c')->orderBy('c.nom_fr', 'ASC');
												}))
		//Relation avec l'hébergement
		->add('hebergement', 'entity', array('class' 		 => 'MyAppGlobalBundle:Hebergements', 
											 'required' 	 => true, 
											 'query_builder' => function(EntityRepository $er){
											 return $er->createQueryBuilder('h')->orderBy('h.nom_fr', 'ASC');
											 }))
		//Relation avec le type de lit
		->add('lit_id', 'entity', array('class'		 	=> 'MyAppGlobalBundle:Lits',
									    'required' 		=> true,
										'multiple' 		=> true,
										'query_builder' => function(EntityRepository $er){
										return $er->createQueryBuilder('l')->orderBy('l.nom_fr', 'ASC');
										}))
		//Relation avec le type de lit
		->add('equipement_id', 'entity', array( 'class'		 	=> 'MyAppGlobalBundle:Equipements',
												'required' 		=> true,
												'multiple' 		=> true,
												'query_builder' => function(EntityRepository $er){
												return $er->createQueryBuilder('e')->orderBy('e.nom_fr', 'ASC');
												}))
		//Galerie photo imbriquée
		->add('galerie_photo_chambre', 'collection', array( 'type' 			=> new Galerie_chambresType(),
															'allow_add' 	=> true,
															'allow_delete'  => true,
														   ));
		
	}
	
	public function getDefaultOptions(array $options)
	{
		return array(
				'data_class' => 'MyApp\GlobalBundle\entity\Chambres',
		);
	}

	public function getName()
	{
		return 'add_chambre';
	}
}
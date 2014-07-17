<?php
namespace MyApp\AdminBundle\Forms;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

/**
 * 
 * @author Cédric Léonard
 * 
 * Formulaire pour l'ajout et modification corporatif version fr
 */
class AddSalleCorporatifType extends AbstractType
{
	public function buildForm(FormBuilder $builder, array $options)
	{
		$builder
		->add('actif','checkbox', array("required" => true))
		->add('nom_fr', 'text', array( "required" => true))
		->add('nom_en', 'text', array( "required" => true))
		->add('texte_salle_corporative_fr', 'textarea', array( "required" => true))
		->add('texte_salle_corporative_en', 'textarea', array( "required" => true))
		->add('largeur', 'text', array( "required" => true))
		//->add('hauteur', 'text', array( "required" => true))
		->add('profondeur', 'text', array( "required" => true))
		->add('email_corporatif', 'text', array( "required" => true))
		//Relation avec l'entité les Corporatifs_services pour afficher les services
		->add('corporatif_service_id', 'entity', array( 'class' =>  'MyAppGlobalBundle:Corporatifs_services',
																	'multiple' => true,
																	'required' => true,
																	'query_builder' => function(EntityRepository $er){
																	return $er->createQueryBuilder('sh')->orderBy('sh.nom_fr', 'ASC');
																	}))
		//Relation avec l'entité lTypes_evenements pour lee événements
		->add('type_evenement', 'entity', array( 'class' => 'MyAppGlobalBundle:Types_evenements',
															'multiple' => true,
															'required' => true,
															'query_builder' => function(EntityRepository $er){
															return $er->createQueryBuilder('sh')->orderBy('sh.nom_fr', 'ASC');
															}))
		->add('fichier_liste_salles_fr_doctrine', 'file', array( "required" => false))
		->add('fichier_liste_salles_en_doctrine', 'file', array( "required" => false))
		->add('fichier_plan_salles_fr_doctrine', 'file', array( "required" => false))
		->add('fichier_plan_salles_en_doctrine', 'file', array( "required" => false))
		->add('largeur_metre', 'text', array( "required" => true))
		//->add('hauteur_metre', 'text', array( "required" => true))
		->add('profondeur_metre', 'text', array( "required" => true))
		->add('banquet', 'text', array( "required" => false))
		->add('carre_ouvert', 'text', array( "required" => false))
		->add('chevron', 'text', array( "required" => false))
		->add('conference', 'text', array( "required" => false))
		->add('demi_lune', 'text', array( "required" => false))
		->add('ecole', 'text', array( "required" => false))
		->add('en_t', 'text', array( "required" => false))
		->add('en_u', 'text', array( "required" => false))
		->add('salon_commercial', 'text', array( "required" => false))
		->add('theatre', 'text', array( "required" => false))
		//Galerie photo imbriquée
		->add('galerie_corpo', 'collection', array( 'type' 		=> new Galerie_photo_CorporatifType,
													'allow_add' => true,
													'allow_delete' => true,
										));
		;
	}
	
	public function getDefaultOptions(array $options)
	{
		return array(
				'data_class' => 'MyApp\GlobalBundle\entity\Hebergements_salles_corporatives',
		);
	}

	public function getName()
	{
		return 'add_corporatif';
	}
}
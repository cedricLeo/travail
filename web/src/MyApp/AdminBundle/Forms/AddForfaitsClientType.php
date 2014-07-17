<?php
namespace MyApp\AdminBundle\Forms;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Doctrine\ORM\EntityRepository;

/**
 * 
 * @author leonardc
 * 
 * Formulaire d'ajout/modification des forfaits pour le client 
 */
class AddForfaitsClientType extends AbstractType
{
	
	public function buildForm(FormBuilder $builder, array $options)
	{
		
		$builder
		->add('nom_fr', 'text', array("required" => true))
		->add('nom_en', 'text', array("required" => true))
		->add('actif', 'checkbox', array("required" => false))
		->add('tarif', 'text', array("required" => true))
		->add('derniere_minute', 'checkbox', array("required" => false))
		->add('texte_fr', 'textarea', array('required' => false))
		->add('texte_en', 'textarea', array('required' => false))
		->add('titre_derniere_minute_fr', 'text', array("required" => false))
		->add('titre_derniere_minute_en', 'text', array("required" => false))
		->add('descriptif_derniere_minute_fr', 'textarea', array('required' => false))
		->add('descriptif_derniere_minute_en', 'textarea', array('required' => false))
		->add('image_principale_doctrine', 'file', array('required' => false))
		->add('date_debut', 'date', array('required' => true, 'years' => range(date('Y'), date('Y') + 10)))
		->add('date_de_fin', 'date', array('required' => true, 'years' => range(date('Y'), date('Y') + 10)))
		->add('reserver_forfait_en_ligne', 'checkbox', array("required" => false))
		//Relation avec l'hébergement
		->add('forfait_client_id', 'entity', array( 'class' => 'MyAppGlobalBundle:Forfaits',
                                                            'required' 	    => true,
                                                            'query_builder' => function(EntityRepository $er){
                                                            return $er->createQueryBuilder('f')->orderBy('f.nom_fr', 'ASC');
                                                           }))
		//Imbrication de la galerie photo
		->add('galerie_forfaits', 'collection', array(
                                                            'type' => new Galerie_forfaitType(),
                                                            'allow_add' => true,
                                                            'allow_delete' => true,
                                                            ));
	}
	
	public function getDefaultOptions(array $options)
	{
		return array(
				'data_class' => 'MyApp\GlobalBundle\Entity\Forfaits_clients',
				'virtual'    => true,
		);
	}

	public function getName()
	{
		return 'add_forfait_client';
	}
}
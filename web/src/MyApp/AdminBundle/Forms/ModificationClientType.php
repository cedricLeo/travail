<?php
namespace MyApp\AdminBundle\Forms;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class ModificationClientType extends AbstractType
{
	public function buildForm(FormBuilder $builder, array $options)
	{
		$builder
		->add('statut', 'checkbox', array("required" => false))
		->add('no_interne', 'text', array('required' => false))
		->add('prenom', 'text', array("required" => false))
		->add('nom', 'text', array("required" => true))
		->add('courriel', 'text', array("required" => true))
		->add('telephone', 'text', array("required" => true))
		->add('telecopieur', 'text', array("required" => false))
		->add('siteweb', 'text', array("required" => false))
		->add('sans_frais', 'text', array("required" => false))
		->add('adresse', 'text', array("required" => true))
		->add('code_postal', 'text', array("required" => true))
		->add('villes', 'entity', array("class" => "MyAppGlobalBundle:Villes", "property" => "nom_fr",  "required" => true))
		->add('regions', 'entity', array('class' => 'MyAppGlobalBundle:Regions', 'property' => 'nom_fr', 'required' => true))
		->add('utilisateurs', 'collection', array('type' => new FormAuthType()))
		;
	}

	public function getDefaultOptions(array $options)
	{
		return array(
				'data_class' => 'MyApp\GlobalBundle\Entity\Utilisateur',
		);
	}

	public function getName()
	{
		return 'add_utilisateur2';
	}
}
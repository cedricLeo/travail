<?php
namespace MyApp\AdminBundle\Forms;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Doctrine\Common\Collections\ArrayCollection;

class AddDateHauteSaisonType extends AbstractType
{
	public function buildForm(FormBuilder $builder, array $options)
	{
		$builder
		->add('titre_haute_saison_fr', 'text', array("required" => false))
		->add('titre_haute_saison_en', 'text', array("required" => false))
		->add('date_debut_saison', 'text', array("required" => false))
		->add('date_fin_saison', 'text', array("required" => false))
		->add('id', 'hidden', array("required" => false))
		;
	}
	
	public function getDefaultOptions(array $options)
	{
		return array(
				'data_class' => 'MyApp\GlobalBundle\Entity\Calendrier_saison',
		);
	}

	public function getName()
	{
		return 'add_calendrier';
	}
}
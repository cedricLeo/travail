<?php
namespace MyApp\AdminBundle\Forms;
use Doctrine\ORM\EntityManager;
use MyApp\GlobalBundle\Entity\HebergementsRepository;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;


class HoraireFicheClientForm extends AbstractType
{
	public function buildForm(FormBuilder $builder, array $options)
	{
		$builder
		->add('lundi_matin_ete', 'time', array("required" => false))
		->add('lundi_soir_ete', 'time', array("required" => false))
		->add('mardi_matin_ete', 'time', array("required" => false))
		->add('mardi_soir_ete', 'time', array("required" => false))
		->add('mercredi_matin_ete', 'time', array("required" => false))
		->add('mercredi_soir_ete', 'time', array("required" => false))
		->add('jeudi_matin_ete', 'time', array("required" => false))
		->add('jeudi_soir_ete', 'time', array("required" => false))
		->add('vendredi_matin_ete', 'time', array("required" => false))
		->add('vendredi_soir_ete', 'time', array("required" => false))
		->add('samedi_matin_ete', 'time', array("required" => false))
		->add('samedi_soir_ete', 'time', array("required" => false))
		->add('dimanche_matin_ete', 'time', array("required" => false))
		->add('dimanche_soir_ete', 'time', array("required" => false))
		
		->add('lundi_matin_hiver', 'time', array("required" => false))
		->add('lundi_soir_hiver', 'time', array("required" => false))
		->add('mardi_matin_hiver', 'time', array("required" => false))
		->add('mardi_soir_hiver', 'time', array("required" => false))
		->add('mercredi_matin_hiver', 'time', array("required" => false))
		->add('mercredi_soir_hiver', 'time', array("required" => false))
		->add('jeudi_matin_hiver', 'time', array("required" => false))
		->add('jeudi_soir_hiver', 'time', array("required" => false))
		->add('vendredi_matin_hiver', 'time', array("required" => false))
		->add('vendredi_soir_hiver', 'time', array("required" => false))
		->add('samedi_matin_hiver', 'time', array("required" => false))
		->add('samedi_soir_hiver', 'time', array("required" => false))
		->add('dimanche_matin_hiver', 'time', array("required" => false))
		->add('dimanche_soir_hiver', 'time', array("required" => false))
		->add('dimanche_soir_hiver', 'time', array("required" => false))
		;
	}
	
	public function getDefaultOptions(array $options)
	{
		return array(
				'data_class' => 'MyApp\GlobalBundle\Entity\Horaires', 
		);
	}

	public function getName()
	{
		return 'add_horaire';
	}
}
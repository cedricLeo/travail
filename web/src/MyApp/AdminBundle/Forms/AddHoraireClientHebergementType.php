<?php
namespace MyApp\AdminBundle\Forms;
use Doctrine\ORM\EntityManager;
use MyApp\GlobalBundle\Entity\HebergementsRepository;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class AddHoraireClientHebergementType extends AbstractType
{
	public function buildForm(FormBuilder $builder, array $options)
	{
		$builder
		->add('lundi_matin_ete', 'time')
		->add('lundi_soir_ete', 'time')
		->add('mardi_matin_ete', 'time')
		->add('mardi_soir_ete', 'time')
		->add('mercredi_matin_ete', 'time')
		->add('mercredi_soir_ete', 'time')
		->add('jeudi_matin_ete', 'time')
		->add('jeudi_soir_ete', 'time')
		->add('vendredi_matin_ete', 'time')
		->add('vendredi_soir_ete', 'time')
		->add('samedi_matin_ete', 'time')
		->add('samedi_soir_ete', 'time')
		->add('dimanche_matin_ete', 'time')
		->add('dimanche_soir_ete', 'time')

		->add('lundi_matin_hiver', 'time')
		->add('lundi_soir_hiver', 'time')
		->add('mardi_matin_hiver', 'time')
		->add('mardi_soir_hiver', 'time')
		->add('mercredi_matin_hiver', 'time')
		->add('mercredi_soir_hiver', 'time')
		->add('jeudi_matin_hiver', 'time')
		->add('jeudi_soir_hiver', 'time')
		->add('vendredi_matin_hiver', 'time')
		->add('vendredi_soir_hiver', 'time')
		->add('samedi_matin_hiver', 'time')
		->add('samedi_soir_hiver', 'time')
		->add('dimanche_matin_hiver', 'time')
		->add('dimanche_soir_hiver', 'time')
		;
	}

	public function getDefaultOptions(array $options)
	{
		return array(
				'data_class' => 'MyApp\GlobalBundle\Entity\Hebergements',
		);
	}

	public function getName()
	{
		return 'add_horaire';
	}
}
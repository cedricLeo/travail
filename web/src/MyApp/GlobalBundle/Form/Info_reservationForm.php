<?php
namespace MyApp\GlobalBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class Info_reservationForm extends AbstractType
{
	public function buildForm(FormBuilder $builder, array $options)
	{
		$builder
				->add('prenom')
				->add('nom')
				->add('adresse', 'textarea')
				->add('ville')
				->add('province_etat')
				->add('pays')
				->add('codepostal')
				->add('telephone')
				->add('telecopieur')
				->add('email')
				->add('confirmemail')
				->add('datearrive')
				->add('nbnuit')
				->add('nbadulte')
				->add('nbenfant')
				->add('ageenfant')
				->add('nbchambre')
				->add('chambrefumeur')
				->add('commentaire');
	}
	
	public function getName()
	{
		return 'inforeservation';
	}
}
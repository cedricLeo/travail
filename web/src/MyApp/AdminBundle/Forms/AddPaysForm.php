<?php
namespace MyApp\AdminBundle\Forms;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Doctrine\Common\Collections\ArrayCollection;

class AddPaysForm extends AbstractType
{
	public function buildForm(FormBuilder $builder, array $options)
	{
		$builder
		 ->add('nomfr', 'text')
         ->add('nomen', 'text')
         ->add('reservitId', 'text')
		 ->add('image_doctrine', 'file', array('required' => false))
		 ->add('affiche', 'checkbox', array('required' => false))
		;
	}

	public function getName()
	{
		return 'add_pays';
	}
}
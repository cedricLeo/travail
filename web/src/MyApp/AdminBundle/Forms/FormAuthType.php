<?php
namespace MyApp\AdminBundle\Forms;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
//use Doctrine\Common\Collections\ArrayCollection;

class FormAuthType extends AbstractType
{
	public function buildForm(FormBuilder $builder, array $options)
	{
		$builder
		->add('username', 'text')
		->add('password', 'password')
		->add('reset_password', 'checkbox', array('label' => 'Changer le mot de passe', 'required' => false))
		->add('email', 'text')
		->add('isActive', 'choice', array('choices' => array('1' => 'activé', '0' => 'non activé')))
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
		return 'add_customer2';
	}
}
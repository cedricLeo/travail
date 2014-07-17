<?php
namespace MyApp\AdminBundle\Forms;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Doctrine\Common\Collections\ArrayCollection;

class FormDistanceType extends AbstractType
{
	public function buildForm(FormBuilder $builder, array $options)
	{
		$builder
         ->add('distance_plage', 'text', array("required" => false))
         ->add('distance_animation', 'text', array("required" => false))
         ->add('distance_billard', 'text', array("required" => false))
         ->add('distance_peche', 'text', array("required" => false))
         ->add('distance_croquet', 'text', array("required" => false))
         ->add('distance_golf', 'text', array("required" => false))
         ->add('distance_marina', 'text', array("required" => false));
	}

	public function getName()
	{
		return 'add_distance';
	}
}
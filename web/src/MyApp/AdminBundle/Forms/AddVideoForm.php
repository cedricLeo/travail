<?php
namespace MyApp\AdminBundle\Forms;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use MyApp\GlobalBundle\Entity\Videos;

class AddVideoForm extends AbstractType
{
	public function buildForm(FormBuilder $builder, array $options)
	{
		$builder
		->add('titre_fr', 'text', array('required' => false))
		->add('titre_en', 'text', array('required' => false))
		->add('url_fr', 'textarea', array('required' => false))
		->add('url_en', 'textarea', array('required' => false))
		->add('path_video_fr', 'file', array('required' => false))
		->add('path_video_en', 'file', array('required' => false));
	}
	

	public function getName()
	{
		return 'add_movie';
	}
}
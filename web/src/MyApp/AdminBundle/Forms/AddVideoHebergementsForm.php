<?php
namespace MyApp\AdminBundle\Forms;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class AddVideoHebergementsForm extends AbstractType
{
	public function buildForm(FormBuilder $builder, array $options)
	{
		$builder
		->add('titre_fr', 'text', array('required' => false))
		->add('titre_en', 'text', array('required' => false))
		->add('url1_fr', 'textarea', array('required' => false))
		->add('url2_fr', 'textarea', array('required' => false))
		->add('url3_fr', 'textarea', array('required' => false))
		->add('url1_en', 'textarea', array('required' => false))
		->add('url2_en', 'textarea', array('required' => false))
		->add('url3_en', 'textarea', array('required' => false))
		->add('path1_video_fr', 'file', array('required' => false))
		->add('path2_video_fr', 'file', array('required' => false))
		->add('path3_video_fr', 'file', array('required' => false))
		->add('path1_video_en', 'file', array('required' => false))
		->add('path2_video_en', 'file', array('required' => false))
		->add('path3_video_en', 'file', array('required' => false))
		;
	}
	
	public function getDefaultOptions(array $options)
	{
		return array(
				'data_class' => 'MyApp\GlobalBundle\Entity\Videos',
		);
	}

	public function getName()
	{
		return 'add_video';
	}
}
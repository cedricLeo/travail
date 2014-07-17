<?php
namespace MyApp\AdminBundle\Forms;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Doctrine\Common\Collections\ArrayCollection;

class CustomerVideoTelechargeForm extends AbstractType
{

	public function buildForm(FormBuilder $builder, array $options)
	{

		$builder
			->add('url1_fr', 'textarea')
			->add('url2_fr', 'textarea')
			->add('url3_fr', 'textarea')
			->add('url1_en', 'textarea')
			->add('url2_en', 'textarea')
			->add('url3_en', 'textarea')
			->add('path1_video_fr', 'file')
			->add('path2_video_fr', 'file')
			->add('path3_video_fr', 'file')
			->add('path1_video_en', 'file')
			->add('path2_video_en', 'file')
			->add('path3_video_en', 'file')
		;
	}
	
	public function getDefaultOptions(array $options)
	{
		return array(
				'data_class' => 'MyApp\GlobalBundle\Entity\Attraits', 
		);
	}

	public function getName()
	{
		return 'add_video_telecharger_customer';
	}
}
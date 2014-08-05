<?php
namespace MyApp\GlobalBundle\Form;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class ReservationOnlineForm extends AbstractType
{
	public function buildForm(FormBuilder $builder, array $options)
	{
		$builder
			->add('datedebut', 'date', array('widget' => 'choice','format' => 'dd - MMMM - YYYY', 'years' => range(date('Y'), date('Y') + 12)))
			->add('chambre', 'choice', array('choices' => array('1' => '1', '2' => '2','3' => '3','4' => '4','5' => '5','6' => '6','7' => '7','8' => '8','9' => '9','10' => '10','11' => '11','12' => '12','13' => '13','14' => '14','15' => '15')))
			->add('datefin', 'date', array('widget' => 'choice','format' => 'dd - MMMM - YYYY', 'years' => range(date('Y'), date('Y') + 12)))
			->add('adulte', 'choice', array('choices' => array('1' => '1', '2' => '2','3' => '3','4' => '4','5' => '5','6' => '6','7' => '7','8' => '8','9' => '9','10' => '10','11' => '11','12' => '12','13' => '13','14' => '14','15' => '15','16' => '16','17' => '17','18' => '18','19' => '20','21' => '21','22' => '22','23' => '23','24' => '24','25' => '25','26' => '26','27' => '27','28' => '28','29' => '29','30' => '30')))
			->add('enfant', 'choice', array('choices' => array('0' => '0', '1' => '1', '2' => '2','3' => '3','4' => '4','5' => '5','6' => '6','7' => '7','8' => '8','9' => '9','10' => '10','11' => '11','12' => '12','13' => '13','14' => '14','15' => '15','16' => '16','17' => '17','18' => '18','19' => '20','21' => '21','22' => '22','23' => '23','24' => '24','25' => '25','26' => '26','27' => '27','28' => '28','29' => '29','30' => '30')))
		;
	}

	public function getName()
	{
		return 'reservationOnline';
	}
}
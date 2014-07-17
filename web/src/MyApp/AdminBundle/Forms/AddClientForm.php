<?php
namespace MyApp\AdminBundle\Forms;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Form\FormError;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\Common\Collections\ArrayCollection;

class AddClientForm extends AbstractType
{
	public function buildForm(FormBuilder $builder, array $options)
	{
		$builder
		->add('username', 'text')
		->add('password', 'password')
		->add('reset_password', 'checkbox', array('label' => 'Changer le mot de passe', 'required' => false))
		->add('email', 'text', array("required" => false))
		->add('isActive', 'choice', array('choices' => array('1' => 'activé', '0' => 'non activé')))
		->add('nom', 'text')
		->add('adresse', 'text')
		->add('code_postal', 'text')
		->add('villes', 'entity', array('class' => 'MyAppGlobalBundle:Villes',
                                                                                    'required' => true,
                                                                                    'query_builder' => function(EntityRepository $er){
                                                                                     return $er->createQueryBuilder('c')->orderBy('c.nom_fr', 'ASC');
                                                                                   }))
		->add('telephone', 'text')
		->add('telephone_poste', 'text', array("required" => false))
		->add('siteweb', 'text', array("required" => false))
		->add('sans_frais', 'text', array("required" => false))
		->add('telecopieur', 'text', array("required" => false))
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
		return 'add_customer';
	}
}
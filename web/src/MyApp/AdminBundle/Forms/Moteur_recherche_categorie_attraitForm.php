<?php
namespace MyApp\AdminBundle\Forms;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use MyApp\GlobalBundle\Entity\Attraits;

/**
 * Formulaire pour le moteur de recherche par catégorie d'attrait coté admin
 */
class Moteur_recherche_categorie_attraitForm extends AbstractType
{
	public function buildForm(FormBuilder $builder, array $options)
	{
		$builder
		//->add('categorie_attrait', 'entity', array('class' => 'MyAppGlobalBundle:Attraits_categories', 'property' => 'nomfr', 'required' => false));
		->add('statut', 'choice', array('choices' => array('0' => '', '1' => 'Activités familiales', '2' => 'Activités sportives et de plein air', '3' => 'Agrotourisme', '4' => 'Campings', '5' => 'Centres de santé et spas', '6' => 'Croisières', '7' => 'Culture', '8' => 'Écotourime', '9' => 'Festivals et événements', '10' => 'Parcs et randonnées pédestres' , '11' => 'Restaurants', '12' => 'Routes et circuits touristiques', '13' => 'Services', '14' => 'Shopping', '15' => 'Vestiges du passé'), 'required' => false));
	}

	public function getName()
	{
		return 'add_enginesearch_categorie_attrait';
	}
}
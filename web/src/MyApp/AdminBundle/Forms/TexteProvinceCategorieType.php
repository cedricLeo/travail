<?php
namespace MyApp\AdminBundle\Forms;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

/**
 * Description of TexteProvinceCategorieType
 *
 * @author cedric
 */
class TexteProvinceCategorieType extends AbstractType {
    
    public function buildForm(FormBuilder $builder, array $options)
    {
            $builder
            ->add('page_titre_fr', 'text', array('required' => false))
            ->add('page_metadescription_fr', 'textarea', array('required' => false))
            ->add('texte_fr', 'textarea', array('required' => false))
            ->add('page_titre_en', 'text', array('required' => false))
            ->add('page_metadescription_en', 'textarea', array('required' => false))
            ->add('texte_en', 'textarea', array('required' => false))
            ;
    }

    public function getName()
    {
            return 'add_texte_province_categorie';
    }       
}

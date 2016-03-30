<?php

namespace Citrax\Bundle\DatabaseSwiftMailerBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EmailType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('status')
            ->add('retries')
            ->add('errorMessage')
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Citrax\Bundle\DatabaseSwiftMailerBundle\Entity\Email'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'citrax_bundle_databaseswiftmailerbundle_email';
    }
}

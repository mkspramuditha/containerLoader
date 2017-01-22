<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichFileType;

class TyrePalletType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('tyre')
            ->add('description')
            ->add('standardLength')
            ->add('standardWidth')
            ->add('standardQuantity')
            ->add('italyLength')
            ->add('italyWidth')
            ->add('italyQuantity')
            ->add('usaLength')
            ->add('usaWidth')
            ->add('usaWidth')
            ->add('usaQuantity')
            ->add('save',SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\TyrePallet',
        ));
    }

    public function getName()
    {
        return 'app_bundle_tyre_palletg_type';
    }
}

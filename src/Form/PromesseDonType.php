<?php

namespace App\Form;

use App\Entity\Campagne;
use App\Entity\PromesseDon;
use App\Repository\CampagneRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Security;


class PromesseDonType extends AbstractType
{
    private $actualUser;

    public function __construct(Security $security)
    {
        $this->actualUser = $security;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        if($this->actualUser->isGranted('IS_AUTHENTICATED_FULLY'))
        {
            $builder
                ->add('email', EmailType::class,[
                    'required' => true,
                    'attr' => [
                        'placeholder'=>'toto@toto.fr'
                    ]
                ])
                ->add('prenom', TextType::class,[
                    'required' => true,
                    'attr' => [
                        'placeholder'=>'Nom'
                    ]
                ])
                ->add('nom',TextType::class,[
                    'required' => true,
                    'attr' => [
                        'placeholder'=>'Prenom'
                    ]
                ])
                ->add('montantDon',IntegerType::class,[
                    'required' => true,
                    'attr' => [
                        'placeholder'=>'10'
                    ]
                ])
                ->add('dateDeCreation', DateTimeType::class, [
                    'required' => true,
                    'input'=>'datetime_immutable'
                ])
                ->add('dateHonore')
                //->add('campagne')
            ;
        }
        else{
            $builder
                ->add('email', EmailType::class,[
                    'required' => true,
                    'attr' => [
                        'placeholder'=>'toto@toto.fr'
                    ]
                ])
                ->add('prenom', TextType::class,[
                    'required' => true,
                    'attr' => [
                        'placeholder'=>'Nom'
                    ]
                ])
                ->add('nom',TextType::class,[
                    'required' => true,
                    'attr' => [
                        'placeholder'=>'Prenom'
                    ]
                ])
                ->add('montantDon',IntegerType::class,[
                    'required' => true,
                    'attr' => [
                        'placeholder'=>'10'
                    ]
                ])
                ->add('dateDeCreation', DateTimeType::class, [
                    'required' => true,
                    'input' => 'datetime_immutable'
                ])
                //->add('dateHonore')
                //->add('campagne')
            ;
        }

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => PromesseDon::class,
        ]);
    }
}

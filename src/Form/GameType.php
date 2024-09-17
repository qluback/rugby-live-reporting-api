<?php

namespace App\Form;

use App\Entity\Game;
use App\Entity\Team;
use App\Entity\TeamCompeting;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GameType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('scoreHome')
            ->add('scoreVisitor')
            ->add('teamCompetingHome', TeamCompetingType::class)
            ->add('teamCompetingVisitor', TeamCompetingType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Game::class,
        ]);
    }
}

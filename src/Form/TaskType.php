<?php

namespace App\Form;

use App\Entity\Project;
use App\Entity\User;
use App\Entity\Statut;
use App\Entity\Task;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class TaskType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class)
            ->add('description', TextType::class)
            ->add('deadline', null, [
                'widget' => 'single_text',
            ])
            ->add('statutId', EntityType::class, [
                'class' => Statut::class,
                'choice_label' => 'label',
                'choice_value' => 'id',
            ])
            ->add('userId', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'firstName',
                'choice_value' => 'id',
                'required' => false, 
                
            ])
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Task::class,
        ]);
    }
}

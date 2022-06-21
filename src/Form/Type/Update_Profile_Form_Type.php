<?php
namespace App\Form\Type;

use App\Entity\User;
use DateTime;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Update_Profile_Form_Type extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data-class'=>User::class
        ]);
    }
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('fullname',TextType::class,['attr'=>['class'=>'put your class name here']])
        ->add('email',EmailType::class,['attr'=>['class'=>'put your class name here']])
        ->add('birthdate',DateType::class,['attr'=>['class'=>'put your class name here'],
        'widget'=>'single_text','format'=>'yyyy-MM-dd',])
        ->add('numberphone',TextType::class,['attr'=>['class'=>'put your class name here']])
        ->add('address',TextType::class,['attr'=>['class'=>'put your class name here']])
        ->add('avatar',FileType::class,['attr'=> ['class'=>'put your class name here']])
        ->add('save',SubmitType::class,['attr'=>['class'=>'put your class name here']]);
    }
}
?>
<?php

namespace Cupon\TiendaBundle\Form\Extranet;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TiendaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre')
            ->add('login', 'text', array('read_only' => true))
            ->add('password', 'repeated', array(
                'type' => 'password',
                'invalid_message' => 'Las dos contraseñas deben coincidir',
                'first_options'   => array('label' => 'Contraseña'),
                'second_options'  => array('label' => 'Repite Contraseña'),
                'required'        => false
            ))
            ->add('descripcion')
            ->add('direccion')
            ->add('ciudad')
            ->add('guardar', 'submit', array(
                'label' => 'Guardar cambios',
                'attr'  => array('class' => 'boton')
            ))
        ;
    }
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Cupon\TiendaBundle\Entity\Tienda',
        ));
    }
    public function getName()
    {
        return 'cupon_tiendabundle_tiendatype';
    }
}

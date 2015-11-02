<?php

namespace Cupon\UsuarioBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContext;
use Cupon\UsuarioBundle\Entity\Usuario;
use Cupon\UsuarioBundle\Form\Frontend\UsuarioType;

class DefaultController extends Controller
{
	public function comprasAction()
	{
		$usuario_id = 1;
		$em = $this->getDoctrine()->getManager();
		$compras = $em->getRepository('UsuarioBundle:Usuario')
					->findTodasLasCompras($usuario_id);
		
		return $this->render('UsuarioBundle:Default:compras.html.twig', array(
		'compras' => $compras
		));
	}
	
	public function loginAction()
	{
		$peticion = $this->getRequest();
		$sesion = $peticion->getSession();
		
		$error = $peticion->attributes->get(
			SecurityContext::AUTHENTICATION_ERROR,
			$sesion->get(SecurityContext::AUTHENTICATION_ERROR)
		);

		return $this->render('UsuarioBundle:Default:login.html.twig', array(
			'last_username' => $sesion->get(SecurityContext::LAST_USERNAME),
			'error' => $error
		));
	}
	
	public function cajaloginAction()
	{
		$peticion = $this->getRequest();
		$sesion = $peticion->getSession();
		
		$error = $peticion->attributes->get(
			SecurityContext::AUTHENTICATION_ERROR,
			$sesion->get(SecurityContext::AUTHENTICATION_ERROR)
		);

		return $this->render('UsuarioBundle:Default:cajalogin.html.twig', array(
			'last_username' => $sesion->get(SecurityContext::LAST_USERNAME),
			'error' => $error
		));
	}
	
	public function registroAction()
	{
		$peticion = $this->getRequest();

		$usuario = new Usuario();
		$formulario = $this->createForm(new UsuarioType(), $usuario);

		$formulario->handleRequest($peticion);

		if ($formulario->isValid()) {
			$encoder = $this->get('security.encoder_factory')
							->getEncoder($usuario);
			$usuario->setSalt(md5(time()));
			$passwordCodificado = $encoder->encodePassword(
				$usuario->getPassword(),
				$usuario->getSalt()
			);
			$usuario->setPassword($passwordCodificado);

			// guardar en la base de datos, por ahora NO
			// $em = $this->getDoctrine()->getManager();
			// $em->persist($usuario);
			// $em->flush();
			
			$this->get('session')->getFlashBag()->add('info',
				'¡Enhorabuena! Te has registrado correctamente en Cupon');
			
			return $this->redirect($this->generateUrl('portada'));
		}

		return $this->render('UsuarioBundle:Default:registro.html.twig', array(
			'formulario' => $formulario->createView())
		);
	}
	
	public function perfilAction()
	{
		$usuario = $this->get('security.context')->getToken()->getUser();
		$formulario = $this->createForm(new UsuarioType(), $usuario);
		
		$peticion = $this->getRequest();
		$formulario->handleRequest($peticion);
		
		
		
		return $this->render('UsuarioBundle:Default:perfil.html.twig', array(
			'usuario' => $usuario,
			'formulario' => $formulario->createView()
		));
	}
}
<?php
// src/Acme/StoreBundle/Controller/DefaultController.php
namespace Acme\StoreBundle\Controller;

use Acme\StoreBundle\Entity\Product;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

// these import the "@Route" and "@Template" annotations
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Symfony\Bundle\FrameworkBundle\Templating\TemplateReference,
    Symfony\Component\Routing\Exception\ResourceNotFoundException,
    Symfony\Component\Validator\ValidatorInterface;

use FOS\RestBundle\View\View,
    FOS\RestBundle\View\ViewHandler,
    FOS\RestBundle\View\RouteRedirectView;
    
use JMS\Serializer\SerializationContext;

class DefaultController extends Controller
{
    public function indexAction()
    {    
        //if (false === $this->get('security.context')->isGranted('ROLE_ADMIN')) {
        //	return $this->redirect($this->generateUrl('_demo_login'));
    	//}
        return $this->render('AcmeStoreBundle:Default:index.html.twig', array('name' => 'store process'));
    }
    public function add($a, $b)
    {
        return $a + $b;
    }
    public function newAction(Request $request)
    {
        // create a task and give it some dummy data for this example
    	$product = new Product();
    	$product->setName('');
    	$product->setPrice('');
    	$product->setDescriptionMain('');
    	
        $form = $this->createFormBuilder($product,array('action' => $this->generateUrl('acme_store_create'),'method' => 'POST'))
            ->add('name', 'text',array('required'=>TRUE))
            ->add('price', 'text',array('required'=>TRUE))
            ->add('DescriptionMain', 'text',array('required'=>FALSE))
            ->add('save', 'submit')
            ->getForm();
        
        $form->handleRequest($request);

        return $this->render('AcmeStoreBundle:Default:new.html.twig', array(
            'form' => $form->createView(),
        ));
    }
    public function createAction()
	{
		$request = $this->get('request');
        if ($request->isMethod('POST')) {
        $name = $request->request->get('form')['name'];
        $price = $request->request->get('form')['price'];
        $description_main = $request->request->get('form')['DescriptionMain'];
        $product = new Product();
    	$product->setName($name);
    	$product->setPrice($price);
    	$product->setDescriptionMain($description_main);

    	$em = $this->getDoctrine()->getManager();
    	$em->persist($product);
    	$em->flush();
    	return $this->redirect($this->generateUrl('acme_store_show',array('id'=>$product->getId())));    	
        } else {
        	return new Response('not valid ');
        }        
    	
	}
	public function showAction($id)
	{
    	$product = $this->getDoctrine()
        	->getRepository('AcmeStoreBundle:Product')
        	->find($id);

	    if (!$product) {
    	    throw $this->createNotFoundException(
            	'No product found for id '.$id
        	);
    	}
    	$tmp_arg = array();
    	$tmp_arg['name']= $product->getName();
    	$tmp_arg['price']= $product->getPrice();
    	$tmp_arg['description']= $product->getDescriptionMain();
    	return $this->render('AcmeStoreBundle:Default:show.html.twig', $tmp_arg);
		//return new Response('product details : '.print_r($tmp_arg,1));    	
	}
	public function updateAction($id)
	{
    	$em = $this->getDoctrine()->getManager();
    	$product = $em->getRepository('AcmeStoreBundle:Product')->find($id);

    	if (!$product) {
        	throw $this->createNotFoundException(
            	'No product found for id '.$id
	        );
    	}

    	$product->setName('New product name!');
    	$em->flush();

    	return $this->redirect($this->generateUrl('acme_store_show',array('id'=>$id)));
	}
	public function deleteAction($id)
	{
    	$em = $this->getDoctrine()->getManager();
    	$product = $em->getRepository('AcmeStoreBundle:Product')->find($id);

    	if (!$product) {
        	throw $this->createNotFoundException(
            	'No product found for id '.$id
	        );
    	}
    	$tmp_arg = array();
    	$tmp_arg['name']= $product->getName();
    	$tmp_arg['price']= $product->getPrice();
    	$tmp_arg['description']= $product->getDescriptionMain();
    	
    	$em->remove($product);
    	$em->flush();

    	return new Response('Deleted product id '.print_r($tmp_arg,1));
	}
	public function autologinAction()
	{
	/**
     * Authenticate as given user
	 */
	/*
    $user = 'sanjith';
    $providerKey = $this->container->getParameter('fos_user.firewall_name');
    $pw = 'password';
    $token = new \Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken($user, $pw, $providerKey, array("ROLE_ADMIN"));
    $this->get('security.context')->setToken($token);
    $event = new \Symfony\Component\Security\Http\Event\InteractiveLoginEvent($this->getRequest(), $token);
    $this->get('event_dispatcher')->dispatch('security.interactive_login', $event);

    $user = $this->get('security.context')->getToken()->getUser();
    */

    	return new Response('Autologin '.print_r($user,1));
	}
	public function demologinAction($accesskey)
	{
		if($accesskey==''){
	    	return new Response('Demo login falied');
		}
		$userobj = $this->getDoctrine()
        	->getRepository('AcmeStoreBundle:Demologin')
        	->findOneBy(array('accesskey'=>$accesskey));
		$client_ip = $this->container->get('request')->getClientIp();
		
		if(!$userobj) {
			throw $this->createNotFoundException(
					'Accesskey Not Found'
			);
		}
		$allowed_ip = $userobj->getClient_ip();
		$expireat = $userobj->getExpireat();
		$remaining_time = $expireat-time();
		$chkip = ($client_ip == $allowed_ip);
		$chkkey = ($remaining_time < 0);
	    if ($chkkey || !$chkip) {
	    	$errmsg = '';
	    	if(!$chkip) {
	    		$errmsg.= 'No Access for IP.';
	    	}	    	 
	    	$errmsg.= ' No access found for accesskey';
	    	
    	    throw $this->createNotFoundException(
    	    		$errmsg
        	);
    	}
    	$user = $userobj->getUname();
    	$providerKey = $this->container->getParameter('fos_user.firewall_name');
    	$token = new \Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken($user, null, $providerKey, array("ROLE_ADMIN"));
    	$this->get('security.context')->setToken($token);
    	$event = new \Symfony\Component\Security\Http\Event\InteractiveLoginEvent($this->getRequest(), $token);
    	$this->get('event_dispatcher')->dispatch('security.interactive_login', $event);

    	$user = $this->get('security.context')->getToken()->getUser();
    	//return new Response($userobj->getUname().'Autologin '.print_r($user,1));
    	return $this->redirect($this->generateUrl('acme_store_homepage'));
	}
    public function jsonpAction()
    {
        $data = array('foo' => 'bar');
        $view = new View($data);
        $view->setFormat('jsonp');

        return $this->viewHandler->handle($view);
    }
}
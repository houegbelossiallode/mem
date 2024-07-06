<?php 

namespace App\EventListener;


use Symfony\Component\HttpKernel\Event\ExceptionEvent;

use Symfony\Component\HttpFoundation\Session\SessionInterface;

class AccessDeniedListener 
{
     private $session; 
    
     public function __construct(SessionInterface $session) 
    { 
        $this->session = $session;
        
    }

    public function onAccessDenied(ExceptionEvent $event)
    {
        // Logic to handle access denied events
        // Example: Adding flash message
        $this->session->getFlashBag()->add('error', 'Access Denied: You are not authorized to access this resource.');
    }
  
}
    
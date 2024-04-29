<?php

namespace App\Services;
use App\Entity\User;
use Symfony\Component\Mailer\MailerInterface;
Use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\Address;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;

class MailerService
{
    public function __construct (private MailerInterface $mailer) {

    }

    public function sendEmail(
        $to = '',
        $subject = '',
        $content = '',
        $text = '',
       
        
    ): void{
        
        $email = (new TemplatedEmail())
        ->from(new Address('houegbelossiallode@gmail.com', 'Administratrice'))
        ->to($to)
        ->text($text)
        ->subject($subject)
        ->html( $content);
        $this->mailer->send($email);
    }
}
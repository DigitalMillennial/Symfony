<?php

namespace App\Service;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;

class MailService
{
    private $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function sendMail($expediteur, $destinataire, $sujet, $contenu)
    {
        $email = (new TemplatedEmail())
            ->from($expediteur)
            ->to($destinataire)
            ->subject($sujet)
            ->htmlTemplate('emails/contact_email.html.twig')
            ->context([
                'expediteur' => $expediteur, // Изменено с 'email' на 'expediteur'
                'sujet' => $sujet,
                'message' => $contenu,
            ]);

        $this->mailer->send($email);
    }
}

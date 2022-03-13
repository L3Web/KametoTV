<?php

namespace App\Services;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;

class MailerService
{
    private MailerInterface $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function sendEmail(string $subject, string $to, $template, array $parameters): void
    {
        $email = (new TemplatedEmail())
            ->to(new Address($to))
            ->subject($subject)
            ->htmlTemplate($template)
            ->context($parameters);
        $this->mailer->send($email);
    }
}
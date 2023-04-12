<?php
namespace App\Service\Mailer;

use App\DTO\CalculationEnquiryInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class EmailSender
{
    public const EMAIL_FROM = "noreply@credit-calculator.stancelewski.pl";
    public const EMAIL_ADMIN = "michal@stancelewski.pl";

    private MailerInterface $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function sendEmails(CalculationEnquiryInterface $calculation): bool
    {
        $mailer =  $this->mailer;

        $email = (new Email())
            ->from(EmailSender::EMAIL_FROM)
            ->to($calculation->getClient()->getEmail())
            ->addBcc(EmailSender::EMAIL_ADMIN)
            ->subject('Time for Symfony Mailer!')
            ->text('Sending emails is fun again!')
        ;

        $mailer->send($email);

        return true;
    }

}
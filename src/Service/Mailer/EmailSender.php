<?php
namespace App\Service\Mailer;

use App\DTO\CalculationEnquiryInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;

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

        $email = (new TemplatedEmail())
            ->from(EmailSender::EMAIL_FROM)
            ->to($calculation->getClient()->getEmail())
            ->addBcc(EmailSender::EMAIL_ADMIN)
            ->subject('New Credit Calculation for ' .
                $calculation->getClient()->getNameFirst() .
                ' ' .
                $calculation->getClient()->getNameLast() .
                ' - Credit Calculator By stancelewski.pl '
            )
            ->htmlTemplate('emails/calculation.html.twig')
            ->context([
                'calculation' => $calculation
            ])
        ;

        try {
            $mailer->send($email);
        }
        catch (TransportExceptionInterface $error) {
                // some error prevented the email sending; display an error message or try to resend the message
                return false;
        }
        return true;
    }

}
<?php
declare(strict_types=1);

namespace App\Service;

use App\Interfaces\CustomerEmailInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mime\Email;

class SendCustomerRegisterEmail implements CustomerEmailInterface
{
    private MailerInterface $mailer;
    private ContainerBagInterface $params;
    private Twig $twig;
    private LoggerInterface $logger;

    public function __construct(
        MailerInterface $mailer,
        ContainerBagInterface $params,
        Twig $twig,
        LoggerInterface $logger
    ) {
        $this->mailer = $mailer;
        $this->params = $params;
        $this->twig = $twig;
        $this->logger = $logger;
    }

    public function sendEmail(string $recipient): bool
    {
        $email = (new Email())
            ->from($this->params->get('app.sender_email') ?: $_ENV['MAILER_SENDER'])
            ->to($recipient)
            ->subject('Confirmation register account')
            ->html($this->twig->render('emails/registration.html.twig'));

        try {
            $this->mailer->send($email);
        } catch (TransportExceptionInterface $e) {
            $this->logger->error($e->getMessage());
            return false;
        }
        return true;
    }
}
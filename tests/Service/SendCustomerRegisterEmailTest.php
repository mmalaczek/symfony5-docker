<?php
declare(strict_types=1);

namespace Service;

use App\Service\SendCustomerRegisterEmail;
use App\Service\Twig;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;
use Symfony\Component\Mailer\MailerInterface;

final class SendCustomerRegisterEmailTest extends KernelTestCase
{
    private SendCustomerRegisterEmail $customerRegisterEmailService;

    protected function setUp(): void
    {
        $mailer = $this->createMock(MailerInterface::class);
        $params = $this->createMock(ContainerBagInterface::class);
        $twig = $this->createMock(Twig::class);
        $logger = $this->createMock(LoggerInterface::class);

        $this->customerRegisterEmailService = new SendCustomerRegisterEmail($mailer, $params, $twig, $logger);
    }

    public function testSendEmail()
    {
        $this->assertTrue($this->customerRegisterEmailService->sendEmail('mirek.malaczek@gmail.com'));
    }

    public function testNotSentEmail()
    {
        $this->assertFalse($this->customerRegisterEmailService->sendEmail('mirek.maladsdzekgmail.com'));
    }
}
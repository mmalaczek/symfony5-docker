<?php
declare(strict_types=1);

namespace App\Command;

use App\Interfaces\CustomerEmailInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Twig\Environment;

class SendCustomerRegisterEmailCommand extends Command
{
    private CustomerEmailInterface $customerRegisterEmailService;

    protected function configure(): void
    {
        $this->setName('send-register-email')
            ->setDescription('Send customer register email')
            ->addArgument('recipient', InputArgument::REQUIRED, 'Email customer recipient.');
    }

    public function __construct(
        CustomerEmailInterface $customerRegisterEmailService,
        string                 $name = null
    ) {
        $this->customerRegisterEmailService = $customerRegisterEmailService;
        parent::__construct($name);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('Start process...');
        if ($this->customerRegisterEmailService->sendEmail($input->getArgument('recipient'))) {
            $output->writeln('Email sent.');
        }
        $output->writeln('End process...');
        return Command::SUCCESS;
    }
}
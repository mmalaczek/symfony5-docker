<?php
declare(strict_types=1);

namespace App\Service;

use Symfony\Component\HttpKernel\KernelInterface;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class Twig extends Environment
{
    public function __construct(KernelInterface $kernel)
    {
        $loader = new FilesystemLoader("templates", $kernel->getProjectDir());
        parent::__construct($loader);
    }
}
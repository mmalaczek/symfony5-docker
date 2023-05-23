<?php

namespace App\Interfaces;

interface CustomerEmailInterface
{
    public function sendEmail(string $recipient): bool;
}
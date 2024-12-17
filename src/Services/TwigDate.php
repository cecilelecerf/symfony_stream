<?php
// src/Twig/DateExtension.php

namespace App\Services;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;
use DateTime;

class TwigDate extends AbstractExtension
{
    public function getFunctions(): array
    {
        return [
            new TwigFunction('days_ago', [$this, 'daysAgo']),
        ];
    }

    public function daysAgo($createdAt)
    {
        $currentDate = new DateTime();
        $diff = $currentDate->diff($createdAt);
        return $diff->days;
    }
}

<?php

namespace App\Interfaces;

interface ClientHttpInterface
{
    public function sendRequest(
        string $method = 'GET',
        string $endpoint = '',
        array $options = []
    );
}

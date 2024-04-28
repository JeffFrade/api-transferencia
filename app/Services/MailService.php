<?php

namespace App\Services;

use App\Core\Support\HttpClient;

class MailService extends HttpClient
{
    protected $baseUri = 'https://run.mocky.io/';
}

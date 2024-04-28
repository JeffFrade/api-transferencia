<?php

namespace App\Services;

use App\Core\Support\HttpClient;

class ApprovalService extends HttpClient
{
    protected $baseUri = 'https://run.mocky.io/';
}

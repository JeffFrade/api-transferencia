<?php

namespace App\Services;

use App\Repositories\TransferenceRepository;

class TransferenceService
{
    private $transferenceRepository;

    public function __construct(TransferenceRepository $transferenceRepository)
    {
        $this->transferenceRepository = $transferenceRepository;
    }
}

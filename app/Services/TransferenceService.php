<?php

namespace App\Services;

use App\Repositories\TransferenceRepository;

class TransferenceService
{
    private $transferenceRepository;
    private $approvalService;

    public function __construct(
        TransferenceRepository $transferenceRepository,
        ApprovalService $approvalService
    )
    {
        $this->transferenceRepository = $transferenceRepository;
        $this->approvalService = $approvalService;
    }

    public function send(array $data)
    {
        $response = $this->approvalService->sendRequest('GET', '/v3/5794d450-d2e2-4412-8131-73d0293ac1cc');
        dd($response);
    }
}

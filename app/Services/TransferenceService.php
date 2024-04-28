<?php

namespace App\Services;

use App\Exceptions\IsShopkeeperException;
use App\Repositories\TransferenceRepository;
use Log;
use UnauthorizedTransferException;

class TransferenceService
{
    private $transferenceRepository;
    private $approvalService;
    private $mailService;
    private $accountService;

    public function __construct(
        TransferenceRepository $transferenceRepository,
        ApprovalService $approvalService,
        MailService $mailService,
        AccountService $accountService
    )
    {
        $this->transferenceRepository = $transferenceRepository;
        $this->approvalService = $approvalService;
        $this->mailService = $mailService;
        $this->accountService = $accountService;
    }

    public function send(array $data)
    {
        $this->transferenceRepository->startTransaction();

        $this->isPersonalAccount($data['id_payer']);
        // TODO: Criar lógica de saque e depósito.
        $this->sendApprove();

        $this->transferenceRepository->commitTransaction();

        $this->sendEmail();

        return [
            'message' => 'Transferência realizada!'
        ];
    }

    private function sendApprove()
    {
        $response = $this->approvalService->sendRequest('GET', '/v3/5794d450-d2e2-4412-8131-73d0293ac1cc');
        $response = json_decode($response)->message;
        Log::info('Resposta do serviço de aprovação: ' . $response);

        if ($response !== 'Autorizado') {
            $this->transferenceRepository->rollbackTransaction();
            throw new UnauthorizedTransferException('Transação não autorizada', 406);
        }
    }

    private function sendEmail()
    {
        $emailMessage = $this->mailService->sendRequest('GET', '/v3/54dc2cf1-3add-45b5-b5a9-6bf7e7f1f4a6');
        Log::info('Envio de e-mail: ' . $emailMessage);
    }

    private function isPersonalAccount(int $idPayer)
    {
        $isPersonalAccount = $this->accountService
            ->isPersonalAccount($idPayer);

        if (!$isPersonalAccount) {
            Log::info('Tentativa de transferência por lojista, ID da conta: ' . $idPayer);
            $this->transferenceRepository->rollbackTransaction();
            throw new IsShopkeeperException(
                'Operação inválida, transferência de valores somente de pessoas físicas é permitida.',
                400
            );
        }
    }
}

<?php

namespace App\Services;

use App\Exceptions\AccountNotFoundException;
use App\Repositories\AccountRepository;
use Log;

class AccountService
{
    private $accountRepository;

    public function __construct(AccountRepository $accountRepository)
    {
        $this->accountRepository = $accountRepository;
    }

    public function isPersonalAccount(int $id)
    {
        $account = $this->edit($id);

        if (strlen($account->user->document) > 11) {
            return false;
        }

        return true;
    }

    public function hasBallance(int $id, float $value)
    {
        $account = $this->edit($id);

        if ($value <= $account->balance) {
            return true;
        }

        return false;
    }

    public function changeValues(
        int $idPayer,
        int $idPayee,
        float $value)
    {
        $accountPayer = $this->edit($idPayer);
        $accountPayee = $this->edit($idPayee);

        $this->accountRepository->update([
            'balance' => $accountPayer->balance - $value
        ], $idPayer);

        $this->accountRepository->update([
            'balance' => $accountPayee->balance + $value
        ], $idPayee);
    }

    public function edit(int $id)
    {
        $account = $this->accountRepository->findFirst('id', $id);

        if (empty($account)) {
            Log::error('Tentativa de acessar conta inválida de ID ' . $id);
            throw new AccountNotFoundException('Conta inexistente', 404);
        }

        return $account;
    }
}

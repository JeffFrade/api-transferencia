<?php

namespace App\Services;

use App\Repositories\AccountRepository;

class AccountService
{
    private $accountRepository;

    public function __construct(AccountRepository $accountRepository)
    {
        $this->accountRepository = $accountRepository;
    }

    public function isPersonalAccount(int $id)
    {
        $account = $this->accountRepository->findFirst('id', $id);

        if (strlen($account->user->document) > 11) {
            return false;
        }

        return true;
    }

    public function hasBallance(int $id, float $value)
    {
        $account = $this->accountRepository->findFirst('id', $id);

        if ($value <= $account->balance) {
            return true;
        }

        return false;
    }
}

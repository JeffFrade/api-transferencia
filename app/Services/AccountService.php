<?php

namespace App\Services;

use App\Exceptions\AccountNotFoundException;
use App\Repositories\AccountRepository;
use Log;

class AccountService
{
    private $accountRepository;
    private $userService;

    public function __construct(
        AccountRepository $accountRepository,
        UserService $userService
    )
    {
        $this->accountRepository = $accountRepository;
        $this->userService = $userService;
    }

    public function index(array $data)
    {
        $data = $this->accountRepository->index($data['id_user'] ?? null);

        if (count($data) <= 0) {
            throw new AccountNotFoundException('Não há contas para os filtros informados', 404);
        }

        return $data;
    }

    public function store(array $data)
    {
        $this->userService->edit($data['id_user']);

        Log::info('Criando a conta: ' . json_encode($data));
        return $this->accountRepository->create($data);
    }

    public function delete(int $id)
    {
        Log::info('Excluindo a conta: ' . $id);
        $this->edit($id);
        $this->accountRepository->delete($id);
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

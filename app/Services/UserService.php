<?php

namespace App\Services;

use App\Exceptions\UserNotFoundException;
use App\Helpers\StringHelper;
use App\Repositories\UserRepository;
use Log;

class UserService
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function index(array $data)
    {
        $data = $this->userRepository->index($data['search'] ?? '');

        if (count($data) <= 0) {
            throw new UserNotFoundException('Não há usuários para os filtros informados', 404);
        }

        return $data;
    }

    public function store(array $data)
    {
        $data['password'] = StringHelper::hashPassword($data['password']);
        Log::info('Criando o usuário: ' . json_encode($data));
        return $this->userRepository->create($data);
    }

    public function edit(int $id)
    {
        $user = $this->userRepository->findFirst('id', $id);

        if (empty($user)) {
            Log::error('Tentativa de acessar usuário inválido de ID ' . $id);
            throw new UserNotFoundException('Usuário inexistente', 404);
        }

        return $user;
    }

    public function delete(int $id)
    {
        Log::info('Excluindo o usuário: ' . $id);
        $this->edit($id);
        $this->userRepository->delete($id);
    }
}

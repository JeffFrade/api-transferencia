<?php

namespace App\Services;

use App\Exceptions\UserNotFoundException;
use App\Repositories\UserRepository;

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
        return $this->userRepository->create($data);
    }
}

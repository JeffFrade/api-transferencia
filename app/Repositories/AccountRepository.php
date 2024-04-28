<?php

namespace App\Repositories;

use App\Core\Support\AbstractRepository;
use App\Repositories\Models\Account;

class AccountRepository extends AbstractRepository
{
    public function __construct(Account $model)
    {
        $this->model = $model;
    }
}

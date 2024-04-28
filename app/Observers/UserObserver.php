<?php

namespace App\Observers;
use App\Repositories\AccountRepository;
use App\Repositories\Models\User;

class UserObserver
{
    public function deleting(User $user)
    {
        app(AccountRepository::class)->customDelete('id_user', $user->id);
    }
}

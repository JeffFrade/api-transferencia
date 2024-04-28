<?php

namespace App\Repositories\Models;

use Database\Factories\AccountFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Account extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'id_user',
        'balance'
    ];

    public static function newFactory()
    {
        return AccountFactory::new();
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id', 'id_user');
    }
}

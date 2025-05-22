<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class AccessroleIward extends Model
{
    use HasFactory;

    protected $connection = 'sso';
    protected $table = 'accessrole_ijnward';

    public function role()
    {
        return $this->belongsTo(Role::class,'role_id', 'id');
    }

    public function usersso()
    {
        return $this->belongsTo(UserSso::class,'user_id', 'id');
    }
}

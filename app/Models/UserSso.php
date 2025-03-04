<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSso extends Model
{
    use HasFactory;

    protected $connection = 'sso';
    protected $table = 'users';

    public function ijnwhd()
    {
        return $this->hasOne(AccessroleIward::class,'user_id','id');
    }
}

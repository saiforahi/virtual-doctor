<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UsersRoles extends Model
{
    protected $guarded = [];
    protected $fillable = [
        'user_id', 'role_id',
    ]; 
}

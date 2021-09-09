<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Features extends Model
{
    protected $guarded = [];
    protected $fillable = [
        'name', 'title','description', 'images',
    ];
}

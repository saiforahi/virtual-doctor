<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Department extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $guarded = [];
    protected $fillable = ['name','image'];

    public function specialityname()
    {
        return $this->belongsTo(Doctor::class, 'department_id');
    }
}

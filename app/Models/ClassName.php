<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClassName extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'classes';

    protected $fillable = [
        'code', 'name', 'mentor', 'description',
    ];
    public function Students()
    {
        return $this->hasMany('App\Models\Student', 'class_id', 'id');
    }

//    public function Admin()
//    {6
//        return $this->belongsTo('App\Models\Admin', 'admin_id', 'id');
//    }

}

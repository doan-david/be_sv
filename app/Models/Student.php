<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'code', 'name', 'username', 'password', 'email', 'gender', 'birthdate',
        'phone', 'address', 'hobby', 'image', 'status', 'description', 'class_id',
    ];

    public function classNames()
    {
        return $this->belongsTo('App\Models\Class', 'class_id', 'id');
    }
//    public function admin()
//    {
//        return $this->belongsTo('App\Models\Admin', 'admin_id', 'id');
//    }
}

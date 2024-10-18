<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    use HasFactory;

    public function Role()
    {
        return $this->belongsTo('App\Models\Role', 'role_id', 'id');
    }

    public function ClassName()
    {
        return $this->hasOne('App\Models\Class', 'admin_id', 'id');
    }

    public function Student()
    {
        return $this->hasOne('App\Models\Student', 'admin_id', 'id');
    }
}

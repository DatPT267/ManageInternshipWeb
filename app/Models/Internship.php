<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Internship extends Model
{
    const CREATED_AT = null;
    const UPDATED_AT = null;

    protected $table = "internshipclass";

    public function group()
    {
        return $this->hasMany('App\Models\Group', 'class_id', 'id');
    }

    public function user()
    {
        return $this->hasMany('App\Models\User', 'class_id', 'id');
    }
}

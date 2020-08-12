<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Internshipclass extends Model
{
    const CREATED_AT = null;
    const UPDATED_AT = null;

    protected $table = "internshipclass";

    public function group()
    {
        return $this->hasMany('App\Group', 'class_id', 'id');
    }
}

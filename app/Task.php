<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    const CREATED_AT = null;
    const UPDATED_AT = null;

    protected $table = "task";


    public function group()
    {
        return $this->hasMany('App\Group', 'id', 'group_id');
    }
}

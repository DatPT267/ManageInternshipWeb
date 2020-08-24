<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Check extends Model
{
    const CREATED_AT = null;
    const UPDATED_AT = null;

    protected $table = "check";

    public function task()
    {
        return $this->belongsTo('App\Task', 'task_id', 'id');
    }
}

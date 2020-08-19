<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Assign extends Model
{
    const CREATED_AT = null;
    const UPDATED_AT = null;

    protected $table = "assign";

    public function task()
    {
        return $this->belongsTo('App\Task', 'task_id', 'id');
    }
}

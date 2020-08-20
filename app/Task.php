<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    const CREATED_AT = null;
    const UPDATED_AT = null;

    protected $table = "task";

    public function project()
    {
        return $this->belongsTo('App\Project', 'project_id', 'id');
    }

    public function assign(){
        return $this->hasMany('App\Assign', 'task_id', 'id');
    }
}

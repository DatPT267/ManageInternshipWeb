<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetailCheck extends Model
{
    const CREATED_AT = null;
    const UPDATED_AT = null;

    protected $table = 'detailcheck';

    public function task()
    {
        return $this->belongsTo('App\Task', 'task_id', 'id');
    }

    public function check()
    {
        return $this->belongsTo('App\Check', 'check_id', 'id');
    }
}

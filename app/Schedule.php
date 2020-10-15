<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    const CREATED_AT = null;
    const UPDATED_AT = null;

    protected $table = "schedule";

    public function user()
    {
        return $this->belongsTo('App\user', 'user_id', 'id');
    }
    public function check()
    {
        return $this->hasMany('App\Check', 'schedule_id', 'id');
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Check extends Model
{
    const CREATED_AT = null;
    const UPDATED_AT = null;

    protected $table = "check";

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }

    public function schedule(){
        return $this->belongsTo('App\Schedule', 'schedule_id', 'id');
    }
}

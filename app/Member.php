<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    const CREATED_AT = null;
    const UPDATED_AT = null;

    protected $table = "member";

    public function user(){
        return $this->belongsTo('App\User', 'user_id', 'id');
    }
}

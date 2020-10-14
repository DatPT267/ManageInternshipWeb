<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    const CREATED_AT = null;
    const UPDATED_AT = null;

    protected $table = "review";

    public function member(){
        return $this->belongsTo('App\Member', 'reviewer_id', 'id');
    }
}

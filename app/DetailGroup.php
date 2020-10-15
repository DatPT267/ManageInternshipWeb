<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetailGroup extends Model
{
    const CREATED_AT = null;
    const UPDATED_AT = null;

    protected $table = "detailgroup";

    public function group()
    {
        return $this->belongsTo('App\Group', 'group_id', 'id');
    }
}

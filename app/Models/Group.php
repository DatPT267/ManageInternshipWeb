<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    const CREATED_AT = null;
    const UPDATED_AT = null;

    protected $table = "group";

    public function internshipClass()
    {
        return $this->belongsTo('App\Models\Internship', 'class_id', 'id');
    }
}

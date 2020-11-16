<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    const CREATED_AT = null;
    const UPDATED_AT = null;

    protected $table = "group";

    protected $fillable = [
        'name', 'topic', 'note', 'status', 'class_id'
    ];

    public function internshipClass()
    {
        return $this->belongsTo('App\Internshipclass', 'class_id', 'id');
    }

    public function review(){
        return $this->hasMany('App\Review', 'group_id', 'id');
    }

    public function member(){
        return $this->hasMany('App\Member', 'group_id', 'id');
    }
}

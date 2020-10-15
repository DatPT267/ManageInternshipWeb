<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    const CREATED_AT = null;
    const UPDATED_AT = null;

    protected $table = "projects";
    public function group(){
        return $this->hasMany('App\Group', 'project_id', 'id');
    }
}

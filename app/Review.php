<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    const UPDATED_AT = null;
    const REVIEWOF = [
        '0' => 'user',
        '1' => 'group'
    ];

    protected $fillable = ["content", "parent_id", "group_id", "reviewer_id", "user_id", "reviewOf"];

    protected $table = "review";


    public function reviewer(){
        return $this->belongsTo('App\User','reviewer_id', 'id');
    }

    public function replies(){
        return $this->hasMany(Review::class, 'parent_id');
    }

    public function group(){
        return $this->belongsTo('App\Group', 'group_id', 'id');
    }

    public function user(){
        return $this->belongsTo('App\User','reviewer_id', 'id');
    }

    public function scopeCheckGroup($query){
        return $query->where('reviewOf', 1);
    }

    public function scopeCheckUser($query){
        return $query->where('reviewOf', 0);
    }

    public function scopeCheckParent($query){
        return $query->where('parent_id', null);
    }


}

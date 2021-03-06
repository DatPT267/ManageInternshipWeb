<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;
    const CREATED_AT = null;
    const UPDATED_AT = null;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name','email' ,'account', 'password', 'phone', 'image', 'status', 'address','position','class_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function internshipClass(){
        return $this->belongsTo('App\Internshipclass', 'class_id', 'id');
    }

    public function check()
    {
        return $this->hasMany('App\Check', 'user_id', 'id');
    }
    public function task()
    {
        return $this->hasMany('App\Task', 'user_id', 'id');
    }
    public function member(){
        return $this->hasOne('App\Member', 'user_id', 'id');
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'name', 'lastname', 'email', 'message',
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function reply()
    {
        return $this->hasOne('App\Reply');
    }
}

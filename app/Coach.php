<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Coach extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'category_id', 'price', 'phone', 'msg_title', 'msg_body'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function category()
    {
        return $this->belongsTo('App\Category');
    }
}

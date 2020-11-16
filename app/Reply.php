<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'contact_id', 'reply_msg', 'readed',
    ];

    public function contact()
    {
        return $this->belongsTo('App\Contact');
    }
}

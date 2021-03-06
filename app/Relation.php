<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Relation extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'sender_id', 'receiver_id', 'active', 'finished',
    ];
}

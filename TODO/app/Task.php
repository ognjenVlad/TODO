<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    public $timestamps = false;
    
    protected $fillable = [
        'priority', 'text', 'completed', 'user_id'
    ];

}

<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class Skill extends Model
{
    protected $collection = 'skills';

    protected $fillable = [
        '_id',
        'name',
        'time_using',
        'user_id',
    ];

}

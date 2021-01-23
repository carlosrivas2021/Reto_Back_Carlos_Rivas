<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class Study extends Model
{
    protected $collection = 'studies';

    protected $dates = ['end_date', 'start_date'];

    protected $fillable = [
        '_id',
        'academy',
        'description',
        'end_date',
        'start_date',
        'user_id',
    ];

}

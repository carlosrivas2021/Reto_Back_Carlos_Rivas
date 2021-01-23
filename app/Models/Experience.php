<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class Experience extends Model
{
    protected $collection = 'experiences';

    protected $dates = ['end_date', 'start_date'];

    protected $fillable = [
        '_id',
        'company',
        'description',
        'end_date',
        'start_date',
        'user_id',
    ];

}

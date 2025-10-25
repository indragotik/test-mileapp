<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Task extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'mileapp';

    protected $fillable = [
        'title',
        'status',
        'priority',
    ];
}

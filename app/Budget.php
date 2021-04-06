<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Budget extends Model
{
    public function user()
    {
        # Budget Belongs To User
        # Defines An Inverse One-To-Many Relationship
        return $this->belongsTo('App\User');
    }

    public function activities()
    {
        # Budget Has Many Activities
        # Defines A One-To-Many Relationship
        return $this->hasMany('App\Activity');

    }
}

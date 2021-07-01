<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pending extends Model
{
    public function user()
    {
        # Pending Belongs To User
        # Defines An Inverse One-To-Many Relationship
        return $this->belongsTo('App\User');
    }

    public function text($text = null)
    {
        if ($text == null) {
            return $this->text;
        }
        else {
            $this->text = $text;
            return $this->text;
        }
    }
}

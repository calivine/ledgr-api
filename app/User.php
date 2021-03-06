<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function activities()
    {
        # User Has Many Activities
        # Defines A One-To-Many Relationship
        return $this->hasMany('App\Activity');
    }

    public function budgets()
    {
        # User Has Many Budgets
        # Defines A One-To-Many Relationship
        return $this->hasMany('App\Budget');
    }

    public function pending()
    {
        # User has many pending activities
        # Define a many-to-many relationship
        return $this->hasMany('App\Pending');
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;

class Account extends Model
{
    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function organizations()
    {
        return $this->hasMany(Organization::class);
    }

    public function employees()
    {
        return $this->hasMany(Employee::class);
    }
}

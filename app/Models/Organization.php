<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{

    protected $fillable = [
        'name', 'details'
    ];
    
    public function user()
    {
        return $this->hasMany(User::class, 'organization_id');
    }
}

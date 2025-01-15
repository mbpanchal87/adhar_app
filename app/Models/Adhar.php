<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Adhar extends Model
{
    protected $fillable = ['user_id', 'adhar_card'];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

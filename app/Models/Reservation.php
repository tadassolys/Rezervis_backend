<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $fillable = [
        'user_id',
        'reservable_id',
        'reservable_type',
        'start_date',
        'end_date',
        'status',
    ];

   
    public function reservable()
    {
        return $this->morphTo();
    }

   
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
}

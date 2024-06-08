<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Vehicle extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $keyType = 'uuid';
    protected $fillable = ['name', 'type', 'details', 'location'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($vehicle) {
            if (empty($vehicle->{$vehicle->getKeyName()})) {
                $vehicle->{$vehicle->getKeyName()} = (string) Str::uuid();
            }
        });
    }

   
    public function reservations()
    {
        return $this->morphMany(Reservation::class, 'reservable');
    }
}

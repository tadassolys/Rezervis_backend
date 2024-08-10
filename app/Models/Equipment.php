<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Equipment extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $keyType = 'uuid';
    protected $fillable = ['name', 'type', 'location', 'additional_details'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($equipment) {
            if (empty($equipment->{$equipment->getKeyName()})) {
                $equipment->{$equipment->getKeyName()} = (string) Str::uuid();
            }
        });
    }

    public function reservations()
    {
        return $this->morphMany(Reservation::class, 'reservable');
    }
}

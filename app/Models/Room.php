<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Room extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $keyType = 'uuid';
    protected $fillable = ['name', 'type', 'location', 'additional_details'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($room) {
            if (empty($room->{$room->getKeyName()})) {
                $room->{$room->getKeyName()} = (string) Str::uuid();
            }
        });
    }

    public function reservations()
    {
        return $this->morphMany(Reservation::class, 'reservable');
    }

    public function isReserved($startDate, $endDate) {
        return $this->reservations()->where(function($query) use ($startDate, $endDate) {
            $query->where('start_date', '<=', $endDate)
                  ->where('end_date', '>=', $startDate);
        })->exists();
    }
}

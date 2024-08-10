<?php

namespace App\Models;

use App\Casts\Time;
use App\Traits\Loggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Zoha\Metable;

class Event extends Model
{
    use HasFactory, Metable, SoftDeletes, Loggable;

    protected $guarded = [
        'id',
        'created_at',
        'updated_at'
    ];

    public function casts()
    {
        return [
            'start_date' => 'date:Y-m-d',
            'end_date' => 'date:Y-m-d',
            'start_time' => Time::class,
            'end_time' => Time::class,
            'created_at' => 'datetime:Y-m-d H:i',
            'updated_at' => 'datetime:Y-m-d H:i',
            'deleted_at' => 'datetime:Y-m-d H:i',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function groups()
    {
        return $this->hasMany(EventGroup::class);
    }

    public function isPassed(string|null $date = null): bool
    {
        if (!$date) {
            $date = $this->start_date;
        }
        return now()->format('Y-m-d') > date('Y-m-d', strtotime($date));
    }
}

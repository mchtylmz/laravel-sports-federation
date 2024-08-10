<?php

namespace App\Models;

use App\Enums\Gender;
use App\Enums\PeopleAdult;
use App\Enums\PeopleType;
use App\Enums\Status;
use App\Traits\Loggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Zoha\Metable;

class People extends Model
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
            'birth_date' => 'date:Y-m-d',
            'licensed_at' => 'date:Y-m-d',
            'registered_at' => 'date:Y-m-d',
            'created_at' => 'datetime:Y-m-d H:i',
            'updated_at' => 'datetime:Y-m-d H:i',
            'deleted_at' => 'datetime:Y-m-d H:i',
            'status' => Status::class,
            'type' => PeopleType::class,
            'gender' => Gender::class,
            'adult' => PeopleAdult::class,
        ];
    }

    public function getFullnameAttribute(): string
    {
        return $this->name . ' ' . $this->surname;
    }

    public function punishments()
    {
        return $this->hasMany(Punishment::class)->latest();
    }

    public function groups()
    {
        return $this->hasMany(EventGroup::class);
    }
}

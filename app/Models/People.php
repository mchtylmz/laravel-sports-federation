<?php

namespace App\Models;

use App\Enums\PeopleType;
use App\Enums\Status;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Zoha\Metable;

class People extends Model
{
    use HasFactory, Metable, SoftDeletes;

    protected $guarded = [
        'id',
        'created_at',
        'updated_at'
    ];

    public function casts()
    {
        return [
            'registered_at' => 'date:Y-m-d',
            'created_at' => 'datetime:Y-m-d H:i',
            'updated_at' => 'datetime:Y-m-d H:i',
            'deleted_at' => 'datetime:Y-m-d H:i',
            'status' => Status::class,
            'type' => PeopleType::class
        ];
    }

    public function getFullnameAttribute(): string
    {
        return $this->name . ' ' . $this->surname;
    }
}

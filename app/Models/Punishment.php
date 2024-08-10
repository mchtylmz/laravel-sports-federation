<?php

namespace App\Models;

use App\Enums\PeopleType;
use App\Enums\Status;
use App\Traits\Loggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Punishment extends Model
{
    use HasFactory, Loggable;

    protected $guarded = [
        'id',
        'created_at',
        'updated_at'
    ];

    public function casts()
    {
        return [
            'created_at' => 'datetime:Y-m-d H:i',
            'updated_at' => 'datetime:Y-m-d H:i'
        ];
    }

    public function people()
    {
        return $this->belongsTo(People::class);
    }
}

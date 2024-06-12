<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Zoha\Metable;

class Federation extends Model
{
    use HasFactory, SoftDeletes, Metable;

    protected $guarded = [
        'id',
        'created_at',
        'updated_at'
    ];

    public function casts()
    {
        return [
          'created_at' => 'datetime:Y-m-d H:i',
          'updated_at' => 'datetime:Y-m-d H:i',
          'deleted_at' => 'datetime:Y-m-d H:i',
        ];
    }
}

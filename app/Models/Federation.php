<?php

namespace App\Models;

use App\Traits\Loggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Zoha\Metable;

class Federation extends Model
{
    use HasFactory, SoftDeletes, Metable, Loggable;

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

    public function directors()
    {
        return $this->hasMany(Director::class)->orderBy('sort', 'ASC');
    }


    public function peoples()
    {
        return $this->hasMany(People::class)->orderBy('name', 'ASC');
    }

    public function notes()
    {
        return $this->hasMany(Note::class)->latest();
    }
}

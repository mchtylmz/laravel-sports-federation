<?php

namespace App\Models;

use App\Enums\Status;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Zoha\Metable;

class Club extends Model
{
    use HasFactory, Metable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [
        'id',
        'created_at',
        'updated_at'
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'created_at' => 'datetime:Y-m-d H:i',
            'updated_at' => 'datetime:Y-m-d H:i',
            'deleted_at' => 'datetime:Y-m-d H:i',
            'status' => Status::class
        ];
    }

    public function federation()
    {
        return $this->belongsTo(Federation::class);
    }
}

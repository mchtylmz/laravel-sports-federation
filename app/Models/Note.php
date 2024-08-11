<?php

namespace App\Models;

use App\Traits\Loggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Note extends Model
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
            'updated_at' => 'datetime:Y-m-d H:i',
            'read_at' => 'datetime:Y-m-d H:i',
        ];
    }

    public function read()
    {
        $this->update([
            'is_read' => 1,
            'read_at' => now()
        ]);

        cache()->delete(sprintf('user_note_count_%d', auth()->id()));
    }
}

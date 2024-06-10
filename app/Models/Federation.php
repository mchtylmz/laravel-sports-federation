<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Federation extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'logo',
        'name',
        'document_number'
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Zoha\Metable;

class Team extends Model
{
    use HasFactory, SoftDeletes, Metable;
}

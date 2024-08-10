<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    use HasFactory;

    /**
     * @var bool
     */
    public $timestamps = false;
    /**
     * @var array|string[]
     */
    public $dates = ['log_date'];
    /**
     * @var array|string[]
     */
    protected $appends = ['dateHumanize', 'json_data'];

    /**
     * @return mixed
     */
    public function getDateHumanizeAttribute()
    {
        return Carbon::parse($this->log_date)->diffForHumans();
    }

    /**
     * @return mixed
     */
    public function getJsonDataAttribute()
    {
        return json_decode($this->data, true);
    }

    /**
     * @return mixed
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

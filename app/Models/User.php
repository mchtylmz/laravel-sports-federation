<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Enums\PermitEnum;
use App\Enums\Status;
use App\Traits\Loggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Zoha\Metable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, Metable, SoftDeletes, Loggable;

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
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime:Y-m-d H:i',
            'last_login' => 'datetime:Y-m-d H:i',
            'password' => 'hashed',
            'created_at' => 'datetime:Y-m-d H:i',
            'updated_at' => 'datetime:Y-m-d H:i',
            'deleted_at' => 'datetime:Y-m-d H:i',
            'status' => Status::class,
            'permit' => PermitEnum::class,
        ];
    }

    public function events()
    {
        return $this->hasMany(Event::class);
    }

    public function federation()
    {
        $federation_id = $this->getMeta('federation_id');

        return Federation::where('id', $federation_id)->first();
    }
}

<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'role_id',
        'email',
        'password',
        'balance',
        'status',
        'isMember',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
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
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function sentFriendships()
    {
        return $this->hasMany(Friendship::class, 'sender_id');
    }

    public function receivedFriendships()
    {
        return $this->hasMany(Friendship::class, 'receiver_id');
    }

    public function locals()
    {
        return $this->hasMany(Local::class, 'creator_id');
    }

    public function participations()
    {
        return $this->hasMany(Participation::class);
    }

    public function messages()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }
}

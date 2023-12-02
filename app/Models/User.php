<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $primaryKey = 'national_id';

    public function transactions(): HasMany {
        return $this->hasMany(Transaction::class);
    }

    public function examinations(): HasMany {
        return $this->hasMany(Examination::class);
    }

    public function pawns(): HasMany {
        return $this->hasMany(Pawn::class);
    }

    public function posts(): HasMany {
        return $this->hasMany(Post::class);
    }

    public function comments(): HasMany {
        return $this->hasMany(Comment::class);
    }

    public function isOwner(): bool{
        return $this->role == 'owner';
    }

    public function isSeller(): bool{
        return $this->role == 'seller';
    }

    public function isAccountant(): bool{
        return $this->role == 'accountant';
    }

    public function isCustomer(): bool{
        return $this->role == 'customer';
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'national_id',
        'password',
        'name',
        'surname',
        'phone_number',
        'image_path'
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
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        // 'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function getJWTIdentifier(){
        return $this->getKey();
    }

    public function getJWTCustomClaims(){
        return [
            'provider' => 'Pawn Shop'
        ];
    }
}

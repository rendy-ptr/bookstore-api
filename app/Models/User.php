<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject, MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'tbl_m_user';
    protected $primaryKey = 'id_tmu';

    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nik_tmu',
        'name_tmu',
        'role_tmu',
        'username_tmu',
        'password_tmu',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password_tmu',
        'remember_token',
    ];
    
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        // 'password_tmu' => 'string',
    ];

    public function getAuthPassword()
    {
        return $this->password_tmu;
    }

    public function setPasswordTmuAttribute($password)
    {
        $this->attributes['password_tmu'] = Hash::make($password);
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [
            'sub' => (string) $this->getKey(), // Menggunakan primary key model sebagai subjek
            'name' => $this->name_tmu, // Menambahkan klaim tambahan jika diperlukan
        ];
    }
}

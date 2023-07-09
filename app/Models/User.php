<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable,SoftDeletes;

    const ROLEADMIN = 'admin';
    const STORAGE_PATH = "/app/public/uplaods/images/user/";
    const UPLOAD_PATH = "public/uplaods/images/user";
    const LINK_PATH = "storage/uplaods/images/user/";


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'first_name',
        'last_name',
        'image',
        'permissions',
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
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'permissions' => 'array',
    ];

    public function getNameAttribute($val)
    {
        return $val == null ? $this->first_name ." ". $this->last_name : $val;
    }

    public function setFirstNameAttribute($val)
    {
        $this->attributes['first_name'] = $val;
        $this->attributes['name'] = $val;
    }

    public function getImageAttribute($val)
    {
        return $val == null ? asset('assets/images/dummy.png') : asset(self::LINK_PATH . $val);
    }

    public function scopeUserRole($query){
        return $query->where('role','!=',self::ROLEADMIN);
    }
}

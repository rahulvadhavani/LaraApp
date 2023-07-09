<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory,SoftDeletes;

    const STORAGE_PATH = "/app/public/uplaods/images/post/";
    const UPLOAD_PATH = "public/uplaods/images/post";
    const LINK_PATH = "storage/uplaods/images/post/";

    protected $fillable = [
        'title',
        'description',
        'image',
        'user_id',
    ];


    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'created_at' => 'datetime',
    ];

    public function getImageAttribute($val)
    {
        return $val == null ? asset('assets/images/dummy.png') : asset(self::LINK_PATH . $val);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'image'];

    const STORAGE_PATH = "/app/public/uplaods/images/category/";
    const UPLOAD_PATH = "public/uplaods/images/category";
    const LINK_PATH = "storage/uplaods/images/category/";

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s'
    ];

    public function getImageAttribute($val)
    {
        return $val == null ? asset('assets/images/dummy.png') : asset(self::LINK_PATH . $val);
    }
}

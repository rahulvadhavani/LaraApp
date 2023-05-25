<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mcq extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    public function options()
    {
        return $this->hasMany(MCQOption::class);
    }
}

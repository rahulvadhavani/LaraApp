<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class McqOption extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function mcq()
    {
        return $this->belongsTo(MCQ::class);
    }
}

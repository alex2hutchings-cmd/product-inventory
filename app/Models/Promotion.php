<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'value',
        'discount_type',
        'promotable_type',
        'promotable_id',
    ];

    public function promotable()
    {
        return $this->morphTo();
    }
}

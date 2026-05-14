<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'image_id',
        'category_id',
        'base_price',
    ];

    protected $appends = ['price'];

    public function image()
    {
        return $this->belongsTo(Image::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function promotion()
    {
        return $this->morphOne(Promotion::class, 'promotable');
    }

    public function getPriceAttribute()
    {

        $price = $this->base_price;

        $promotion = null;

        if ($this->promotion) {
            $promotion = $this->promotion;
        } else if ($this->category->promotion) {
            $promotion = $this->category->promotion;
        }

        if ($promotion) {
            if ($promotion->discount_type == 'flat') {
                $price = $this->base_price - $promotion->value;
            } else if ($promotion->discount_type == 'percentage') {
                $price = $this->base_price * (100 - $promotion->value)/100;
            }
        }

        return $price;
    }
}

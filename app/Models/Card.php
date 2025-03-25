<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    use HasFactory;

    protected $fillable=[
        "user_id",
        "session_id",
        "product_variant_id",
        "qty"
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product_variant()
    {
        return $this->belongsTo(ProductVariants::class);
    }

}

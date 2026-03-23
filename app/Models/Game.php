<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model;

class Game extends Model
{
    use HasFactory;

    protected $connection = 'mongodb';
    protected $collection = 'games';

    protected $fillable = [
        'name',
        'slug',
        'category_ids',
        'description',
        'price',
        'image',
        'download_link',
        'publisher',    
        'platforms',     
        'languages',     
        'sold_count',
        'is_active',
    ];

    protected $casts = [
        'price' => 'integer',      
        'sold_count' => 'integer',
        'is_active' => 'boolean',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function getPriceFormatAttribute()
    {
        return number_format($this->price, 0, ',', '.') . ' đ';
    }
}
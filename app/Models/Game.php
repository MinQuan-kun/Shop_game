<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
// SỬA DÒNG NÀY: Dùng Model của MongoDB thay vì SQL chuẩn
use MongoDB\Laravel\Eloquent\Model; 

class Game extends Model
{
    use HasFactory;

    protected $connection = 'mongodb';
    protected $collection = 'games';  

    protected $fillable = [
        'name',
        'slug',
        'category_id',
        'description',
        'price',
        'image',
        'download_link',
        'sold_count',
        'is_active',
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
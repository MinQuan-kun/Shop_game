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

    public function getDirectDownloadLinkAttribute()
    {
        // Lấy link gốc từ database
        $url = $this->download_link;

        // Kiểm tra xem có phải link Google Drive không
        if (strpos($url, 'drive.google.com') !== false) {
            // Tách lấy File ID
            // Hỗ trợ cả dạng /file/d/ID/view và ?id=ID
            preg_match('/\/d\/([a-zA-Z0-9_-]+)/', $url, $matches);

            if (isset($matches[1])) {
                $fileId = $matches[1];
                // Trả về link tải trực tiếp
                return "https://drive.google.com/uc?export=download&id=" . $fileId;
            }
        }

        // Nếu không phải link Drive thì trả về link gốc
        return $url;
    }
}

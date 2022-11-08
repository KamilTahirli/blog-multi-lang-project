<?php

namespace App\Models;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PostTranslation extends Model
{
    use HasFactory;
    protected $table = 'post_translations';
    protected $fillable = ['title', 'post_id', 'slug', 'content', 'locale'];

    public function author()
    {
        return $this->belongsTo(User::class);
    }

    protected $casts = [
        'created_at' => "datetime:d-m-Y",
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}

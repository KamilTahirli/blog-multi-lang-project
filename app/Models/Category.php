<?php

namespace App\Models;
use App\Models\PostTranslation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;

    protected $table = 'categories';
    protected $fillable = ['name', 'slug'];

    protected $casts = [
        'created_at' => "datetime:d-m-Y",
    ];
    
    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}

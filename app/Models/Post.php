<?php
namespace App\Models;

use App\Models\User;
use App\Models\Category;
use App\Models\PostTranslation;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;

class Post extends Model implements TranslatableContract
{
    use Translatable;

    protected $table = 'posts';
    
    public $translatedAttributes = ['title', 'content', 'slug'];


    protected $fillable =
    [
        'category_id',
        'images',
        'author_id',
        'status'
    ];

    protected $casts = [
        'created_at' => "datetime:d-m-Y",
    ];

   

}

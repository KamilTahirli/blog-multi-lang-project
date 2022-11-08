<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\PostTranslation;
use Illuminate\Support\Facades\Auth;

class MainController extends Controller
{
    public function index()
    {
        $posts = PostTranslation::join('posts', 'post_translations.post_id', '=', 'posts.id')
        ->orderBy('post_translations.created_at', 'DESC')
        ->where('post_translations.locale', app()->getLocale())
        ->with('author')
        ->with('category')
        ->paginate(12);
        return view('frontend.index', compact('posts'));
    }

   
}

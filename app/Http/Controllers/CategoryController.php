<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\PostTranslation;
use Illuminate\Support\Facades\Lang;
use App\Http\Requests\CategoryRequest;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend.categories.index');
    }

    public function category_detail($category_slug)
    {
         $category = Category::where('slug', $category_slug)->firstOrFail();

          $posts = PostTranslation::join('posts', 'post_translations.post_id', '=', 'posts.id')
         ->orderBy('post_translations.created_at', 'DESC')
         ->where('post_translations.locale', app()->getLocale())
         ->where('posts.category_id', $category->id)
         ->with('author')
         ->with('category')
         ->paginate(12);
        
         return view('frontend.categories.detail', compact('category', 'posts'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {
        Category::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name)
        ]);
        return response()->json(['success' => Lang::get('translate.elave_edildi')], 200);
    }

    public function categories_list()
    {
        $categories = Category::orderBy('created_at', 'DESC')->paginate(5);
        return response()->json(['categories' => $categories, 200]);
    }

    public function all_categories()
    {
        $all_categories = Category::all();
        return response()->json(['all_categories' => $all_categories, 200]);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryRequest $request, Category $category)
    {
        $category->update([
         'name' => $request->name,
         'slug' => Str::slug($request->name),
        ]);

        return response()->json(['success' => Lang::get('translate.duzelish_edildi')], 200);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return response()->json(['success' => Lang::get('translate.silindi')], 200);
    }
}

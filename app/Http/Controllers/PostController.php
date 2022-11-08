<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\PostTranslation;
use App\Http\Requests\PostRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend.posts.index');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostRequest $request, $lang = null, $post_id)
    {
        $locale = $lang === 'null' ? app()->getLocale() : $lang;


        if ($post_id == 'null') {
            $imgName = time().'.'.$request->images->extension();
            $path = 'posts/images';
            $request->images->move(public_path($path), $imgName);
            $post = Post::create([
                'category_id' => $request->category_id,
                'author_id' => Auth::user()->id,
                'images' => $imgName,
           ]);

            $postID = $post->id;
        } else {
            $postID = $post_id;
        }


        $checkLangPost = PostTranslation::where('post_id', $postID)->where('locale', $locale)->first();



        if (empty($checkLangPost)) {
            PostTranslation::create([
                'title' => $request->title,
                'content' => $request->content,
                'slug' => Str::slug($request->title),
                'post_id' => $postID,
                'locale' => $locale,
            ]);
            return response()->json(['success' => Lang::get('translate.elave_edildi')], 200);
        } else {
            return response()->json(['error' => Lang::get('translate.post_yaradilib')], 422);
        }
    }


    public function posts_list()
    {
        $posts = PostTranslation::join('posts', 'post_translations.post_id', '=', 'posts.id')
        ->orderBy('post_translations.created_at', 'DESC')
        ->where('post_translations.locale', app()->getLocale())
        ->with('author')
        ->paginate(10);

        foreach ($posts->items() as $post) {
            $post->translations = PostTranslation::where('post_id', $post->id)->select('id', 'locale')->get();
        }

        return response()->json(['posts' => $posts, 200]);
    }


    public function edit($lang, $post_id)
    {
        $post = PostTranslation::join('posts', 'post_translations.post_id', '=', 'posts.id')
        ->where('locale', $lang)
        ->where('post_id', $post_id)
        ->first();

        if (!empty($post)) {
            return response()->json(['post' => $post], 200);
        } else {
            return response()->json(['error' => 'Not found'], 422);
        }
    }

    public function show($lang, $post_id)
    {
        $postData = PostTranslation::join('posts', 'post_translations.post_id', '=', 'posts.id')
        ->where('locale', $lang)
        ->where('post_id', $post_id)
        ->with('author')
        ->first();

        if (!empty($postData)) {
            return response()->json(['postData' => $postData], 200);
        } else {
            return response()->json(['error' => 'Not found'], 422);
        }
    }

    public function getTranslate($lang, $post_id)
    {
        $getTranslate = PostTranslation::join('posts', 'post_translations.post_id', '=', 'posts.id')
        ->where('locale', $lang)
        ->where('post_id', $post_id)
        ->first();

        return response()->json(['getTranslate' => $getTranslate], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(PostRequest $request, Post $post)
    {
        if ($request->hasFile('images')) {
            $imgName = time().'.'.$request->images->extension();
            $path = 'posts/images';
            $request->images->move(public_path($path), $imgName);
        } else {
            $imgName = $post->images;
        }

        $post->update([
            'category_id' => $request->category_id,
            'images' => $imgName,
            'author_id' => $post->author_id,
        ]);

        $getPostData = PostTranslation::where('post_id', $post->id)
        ->where('locale', $request->locale)
        ->first();

        if (!empty($getPostData)) {
            $getPostData->title = $request->title;
            $getPostData->content = $request->content;
            $getPostData->slug = Str::slug($request->title);
            $getPostData->locale = $request->locale;
            $getPostData->save();

            return response()->json(['success' => Lang::get('translate.duzelish_edildi')], 200);
        } else {
            return response()->json(['error' => 'Not Found'], 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy($lang, $post_id)
    {
        $post = PostTranslation::join('posts', 'post_translations.post_id', '=', 'posts.id')
        ->where('locale', $lang)
        ->where('post_id', $post_id)
        ->delete();
    }


    public function post_detail($category_slug, $post_slug)
    {
        $category = Category::where('slug', $category_slug)->first();

        if (!empty($category)) {
            $post = PostTranslation::join('posts', 'post_translations.post_id', '=', 'posts.id')
            ->orderBy('post_translations.created_at', 'DESC')
            ->where('post_translations.slug', $post_slug)
            ->with('author')
            ->with('category')
            ->firstOrFail();

            if (!empty($post)) {
                $postLangData = PostTranslation::where('post_id', $post->id)
                ->where('locale', '!=', $post->locale)
                ->get(['slug', 'locale']);
            }
        } else {
            return redirect()->back();
        }


        return view('frontend.posts.detail', compact('category', 'post', 'postLangData'));
    }


    public function search(Request $request)
    {
        $q = $_GET['q'];


        if (!empty($q)) {
            $posts = PostTranslation::join('posts', 'post_translations.post_id', '=', 'posts.id')
            ->orderBy('post_translations.created_at', 'DESC')
            ->where('post_translations.title', 'like', '%'.$request->q.'%')
            ->orWhere('post_translations.content', 'like', '%'.$request->q.'%')
            ->with('author')
            ->with('category')
            ->paginate(12)->setPath('');
             $pagination = $posts->appends(array(
                'q' => $q
              ));
            return view('frontend.posts.search', compact('posts'));
        } else {
            return redirect()->route('home.page');
        }
    }
}

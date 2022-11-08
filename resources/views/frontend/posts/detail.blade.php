@extends('frontend.layouts.master')

@section('title') {{Str::limit($post->title, 60)}} @endsection
@section('description'){{Str::limit($post->content, 160)}}@endsection

@section('content')

<section class="d-flex justify-content-center">
    <div class="container text-center">

                <div class="single-blog-box-layout3">

               <div class="d-flex justify-content-center">
                <div class="responsive-images">
                    <img class="img-wh" src="{{ url('posts/images/', $post->images) }}">
                    </div>
               </div>
                    
                    <div class="single-blog-content mt-3">
                        <div class="blog-entry-content">

                            <h2 class="item-title">{{ $post->title }}</h2>
                           
                            <ul class="entry-meta meta-color-dark">
                                <li><i class="fas fa-tag"></i><a href="{{ url($post->category->slug) }}">{{ $post->category->name }}</a></li>
                                <li><i class="fas fa-calendar-alt"></i>{{Carbon\Carbon::parse($post->created_at)->format('d/m/Y')}}</li>
                                <li> 
                                    @if(!empty($post->author->photo))
                                    <img style="width: 18px !important; height: 18px !important; border-radius: 100px;" src="{{url('users/photos', $post->author->photo)}}">
                                    @else
                                    <img style="width: 18px !important; height: 18px !important; border-radius: 100px;" src="{{url('backend/img/no-avatar.png')}}">
                                    @endif
                                    {{ $post->author->name }}
                                </li>
                            </ul>

                            @if(count($postLangData)  > 0)

                            <ul class="entry-meta meta-color-dark">
                               @foreach($postLangData as $langData)
                                <li>
                                    <div class="d-flex flex-row">
                                        <span class="mt-1">{{ __('translate.goruntule') }}</span>
                                        <a class="ml-3" href="{{ url($post->category->slug, $langData->slug) }}">
                                            <img class="i-20" src="{{url('frontend/icon/', $langData->locale.'.'.'svg')}}">
                                        </a>
                                    </div>
                                </li>
                               @endforeach
                            </ul>
                            @endif

                        </div>
                        <div class="blog-details">

                            <p>{{ $post->content }}</p>

                            
                        </div>
                    </div>
                </div>
            </div>
</section>

@endsection

@extends('frontend.layouts.master')
@section('title') {{ $category->name }} @endsection
@section('description') {{__('translate.home_description')}} @endsection
@section('content')

        <!-- Blog Area Start Here -->
        <section class="blog-wrap-layout9">
            <div class="container">
                <div class="section-heading-3">
                    <h2>{{__('translate.son_postlar')}}</h2>
                </div>
                <div class="row gutters-40 menu-list" id="no-equal-gallery">
                    @forelse($posts as $post)
                    <div class="col-lg-4 col-md-6 col-sm-6 col-12 no-equal-item">
                        <div class="blog-box-layout5">
                            <a href="{{ url($post->category->slug, $post->slug) }}" class="item-img-resp">
                                <img class="resp-img" src="{{ url('posts/images', $post->images) }}">
                            </a>
                            <div class="item-content">
                                <ul class="entry-meta meta-color-dark">
                                    <li><i class="fas fa-tag"></i><a href="{{url($post->category->slug)}}">{{ $post->category->name }}</a></li>
                                    <li><i class="fas fa-calendar-alt"></i>{{Carbon\Carbon::parse($post->created_at)->format('d/m/Y')}}</li>
                                    <li>
                                    <img style="width: 18px !important; height: 18px !important; border-radius: 100px;" src="{{url('users/photos', $post->author->photo)}}">
                                     {{ $post->author->name }}
                                   </li>
                                </ul>
                                <h3 class="item-title">
                                    <a href="{{ url($post->category->slug, $post->slug) }}">
                                      {{ Str::limit($post->title, 30) }}
                                   </a>
                               </h3>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="alert alert-warning col-12">{{__('translate.siyahi_boshdur')}}</div>
                    @endforelse
            </div>
           <div class="d-flex justify-content-center"> {{ $posts->links() }} </div>
        </section>
 
	@endsection
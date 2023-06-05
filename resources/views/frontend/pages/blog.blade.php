@extends('frontend.layouts.master')

@section('title','E-SHOP || Blog Page')
@section('page-title','E-BAZAAR || Blog  page')
<style>


</style>
@section('main-content')
    <!-- Breadcrumbs -->
    <div class="breadcrumbs">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="bread-inner">
                        <ul class="bread-list">
                            <li><a href="{{('home')}}">Home<i class="ti-arrow-right"></i></a></li>

                            <li class="active"><a href="javascript:void(0);">Blog</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Breadcrumbs -->
        @php
            $storeAndUrl = Helper::getStoreAndUrlBySlug();
            $last_slug = $storeAndUrl['last_slug'];
        @endphp
    <!-- Start Blog Single -->
    <section class="blog-single shop-blog grid section">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-12">
                    <div class="row">
                        @if ($posts)
                            @foreach ($posts as $post)
                                <div class="col-md-4 col-12 mb-5">
                                    <!-- Start Single Blog  -->
                                    <div class="shop-single-blog">
                                        <img src="{{ asset('images/posts/' . $post->photo) }}"
                                            alt="{{ $post->photo }}">
                                        <div class="content">
                                            <p class="date">{{ $post->created_at->format('d M , Y. D') }}</p>
                                            <a href="{{ route('blog.detail', ['post_slug' => $post->slug, 'slug' => $last_slug]) }}" class="title">{{ Str::limit($post->title, 70, $end = '...') }}</a>
                                            <a href="{{ route('blog.detail', ['post_slug' => $post->slug, 'slug' => $last_slug]) }}" class="more-btn text-warning">Continue Reading</a>
                                        </div>
                                    </div>
                                    <!-- End Single Blog  -->
                                </div>
                            @endforeach
                            <div class="col-12">
                                @if( method_exists($posts,'links') )
                                   {{$posts->appends($_GET)->links()}}
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
                <div class="col-lg-4 col-12">
                    <div class="main-sidebar">
                        <!-- Single Widget -->
                        <div class="single-widget search">
                            <form class="form" method="POST" action="{{route('blog.search', [$last_slug])}}">
                                @csrf
                                <input type="text" placeholder="Search Here..." name="search">
                                <button class="button" type="sumbit"><i class="fa fa-search"></i></button>
                            </form>
                        </div>
                        <!--/ End Single Widget -->
                        <!-- Single Widget -->
                        <div class="single-widget category">
                            <h3 class="title">Blog Categories</h3>
                            <ul class="categor-list">
                                @foreach($categories as $cat)
                                <li>
                                    <a href="{{route('blog.category',[$last_slug, $cat->slug])}}">{{$cat->title}} </a>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                        <!--/ End Single Widget -->
                        <!-- Single Widget -->
                        <div class="single-widget recent-post">
                            <h3 class="title">Recent post</h3>
                            @foreach($recent_posts as $post)
                                <!-- Single Post -->
                                <div class="single-post">
                                    <div class="image">
                                        <img src="{{ asset('images/posts/'.$post->photo )}}" alt="{{$post->photo}}">
                                    </div>
                                    <div class="content">
                                        <h5><a href="{{ route('blog.detail', ['post_slug' => $post->slug, 'slug' => $last_slug]) }}">{{$post->title}}</a></h5>
                                        <ul class="comment">
                                            <li><i class="fa fa-calendar" aria-hidden="true"></i>{{$post->created_at->format('d M, y')}}</li>
                                            <li><i class="fa fa-user" aria-hidden="true"></i> 
                                                Anonymous
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <!-- End Single Post -->
                            @endforeach
                        </div>

                        <div class="single-widget side-tags">
                            <h3 class="title">Tags</h3>
                            <ul class="tag">
                                @foreach($tags as $tag)
                                    <li>
                                        <a href="{{route('blog.tag', [$last_slug, $tag->slug])}}">{{$tag->title}} </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <!--/ End Single Widget -->
                        <!-- Single Widget -->
                        <div class="single-widget newsletter">
                            <h3 class="title">Newslatter</h3>
                            <div class="letter-inner">
                                <h4>Subscribe & get news <br> latest updates.</h4>
                                <form method="POST" action="{{route('subscribe')}}" class="form-inner">
                                    @csrf
                                    <input type="email" name="email" placeholder="Enter your email">
                                    <button type="submit" class="btn " style="width: 100%">Submit</button>
                                </form>
                            </div>
                        </div>
                        <!--/ End Single Widget -->
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--/ End Blog Single -->
@endsection
@push('styles')
    <style>
        .pagination{
            display:inline-flex;
        }
    </style>

@endpush
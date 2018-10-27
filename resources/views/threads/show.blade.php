@extends('layouts.app')

@section('title')

{{$thread->title}}
@endsection


@section('content')
<!-- Start top-section Area -->
<section class="top-section-area section-gap">
    <div class="container">
        <div class="row justify-content-between align-items-center d-flex">
            <div class="col-lg-8 top-left">
                <h1 class="text-white mb-20">{{$thread->title}}</h1>
            </div>
        </div>
        @can('update', $thread)
            <form method="POST" action="{{route('threads.destroy', $thread->slug)}}">
                @csrf
                {{method_field('DELETE')}}
                <button type="submit" class="btn btn-danger float-right"><i class="fa fa-trash"></i></button>
            </form>
        @endcan
    </div>
</section>
<!-- End top-section Area -->


<!-- Start post Area -->
<div class="post-wrapper pt-100">
    <!-- Start post Area -->
    <section class="post-area">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="single-page-post">
                        <img class="img-fluid" src="{{$thread->image()}}" alt="">
                        <div class="top-wrapper ">
                            <div class="row d-flex justify-content-between">
                                <h2 class="col-lg-8 col-md-12 text-uppercase">
                                    {{$thread->title}}
                                </h2>
                                <div class="col-lg-4 col-md-12 right-side d-flex justify-content-end">
                                    <div class="desc">
                                        <h2>{{$thread->user->username}}</h2>
                                        <h3>{{$thread->created_at}}</h3>
                                    </div>
                                    <div class="user-img">
                                        <img src="{{$thread->user->image}}" alt="{{$thread->user->name}}" width="30" height="30">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="single-post-content">
                            <p>
                                {{$thread->body}}
                            </p>
                        </div>

                        <div class="bottom-wrapper">
                            <div class="row">
                                <div class="col-lg-4 single-b-wrap col-md-12">
                                    <i class="fa fa-thumbs-o-up" aria-hidden="true"></i>
                                    {{$thread->likes_count}} {{str_plural('Like', $thread->likes_count)}}
                                </div>
                                <div class="col-lg-4 single-b-wrap col-md-12">
                                    <i class="fa fa-comment-o" aria-hidden="true"></i> {{$thread->comments_count}} {{str_plural('Comment', $thread->comments_count)}}
                                </div>
                                <div class="col-lg-4 single-b-wrap col-md-12">
                                    <ul class="social-icons">
                                        <li><a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                                        <li><a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                                        <li><a href="#"><i class="fa fa-dribbble" aria-hidden="true"></i></a></li>
                                        <li><a href="#"><i class="fa fa-behance" aria-hidden="true"></i></a></li>
                                    </ul>
                                    <div class="addthis_inline_share_toolbox"></div>
                                </div>
                            </div>
                        </div>


                        <!-- Start comment-sec Area -->
                        <section class="comment-sec-area pt-80 pb-80">
                            <div class="container">
                                <div class="row flex-column">
                                    <h5 class="text-uppercase pb-80">{{$thread->comments_count}} {{str_plural('Comment', $thread->comments_count)}}</h5>
                                    <br>
                                    @foreach($thread->comments as $comment)
                                        @include('threads.comment')
                                    @endforeach
                                </div>
                            </div>
                        </section>
                        <!-- End comment-sec Area -->

                        <!-- Start commentform Area -->
                        <section class="commentform-area  pb-120 pt-80 mb-100">
                            <div class="container">
                                @auth
                                    <h5 class="text-uppercas pb-50">Leave a Comment</h5>
                                    <div class="row flex-row d-flex">
                                        <div class="col-lg-12">
                                            <form action="{{route('comments.store', $thread->slug)}}" method="POST">
                                                @csrf
                                                <textarea name="body" class="form-control" placeholder="Your Comment ....."></textarea>
                                                <button type="submit" class="primary-btn mt-20">Post Comment</button>
                                            </form>
                                        </div>
                                    </div>
                                @else
                                    <div class="alert alert-danger">
                                        Please <a href="{{route('login')}}">Login</a> To Add Your Comment !.
                                    </div>
                                @endauth
                            </div>
                        </section>
                        <!-- End commentform Area -->

                    </div>
                </div>
                <div class="col-lg-4 sidebar-area ">
                    <div class="single_widget search_widget">
                        <div id="imaginary_container">
                            <div class="input-group stylish-input-group">
                                <input type="text" class="form-control"  placeholder="Search" >
                                <span class="input-group-addon">
                                    <button type="submit">
                                        <span class="lnr lnr-magnifier"></span>
                                    </button>
                                </span>
                            </div>
                        </div>
                    </div>


                    <div class="single_widget cat_widget">
                        <h4 class="text-uppercase pb-20">Post Details</h4>
                        <ul>
                            <li>
                                <a href="{{route('channels.show', $thread->channel->slug)}}"> Channel <span>{{$thread->channel->name}}</span></a>
                            </li>

                            <li>
                                <a href="{{route('profile', $thread->user->username)}}"> By  <span>{{$thread->user->username}}</span></a>
                            </li>
                            <li>
                                <a>Since <span>{{$thread->created_at}}</span></a>
                            </li>
                            <li>
                                <a>{{str_plural('Comment', $thread->comments_count)}} <span>{{$thread->comments_count}}</span></a>
                            </li>
                            <li>
                                <a>{{str_plural('Like', $thread->likes_count)}} <span>{{$thread->likes_count}}</span></a>
                            </li>
                        </ul>
                    </div>

                    <div class="single_widget recent_widget">
                        <h4 class="text-uppercase pb-20">Recent Posts</h4>
                        <div class="active-recent-carusel">
                            <div class="item">
                                <img src="img/asset/slider.jpg" alt="">
                                <p class="mt-20 title text-uppercase">Home Audio Recording <br>
                                    For Everyone</p>
                                <p>02 Hours ago <span> <i class="fa fa-heart-o" aria-hidden="true"></i>
                                06 <i class="fa fa-comment-o" aria-hidden="true"></i>02</span></p>
                            </div>
                            <div class="item">
                                <img src="img/asset/slider.jpg" alt="">
                                <p class="mt-20 title text-uppercase">Home Audio Recording <br>
                                    For Everyone</p>
                                <p>02 Hours ago <span> <i class="fa fa-heart-o" aria-hidden="true"></i>
                                06 <i class="fa fa-comment-o" aria-hidden="true"></i>02</span></p>
                            </div>
                            <div class="item">
                                <img src="img/asset/slider.jpg" alt="">
                                <p class="mt-20 title text-uppercase">Home Audio Recording <br>
                                    For Everyone</p>
                                <p>02 Hours ago <span> <i class="fa fa-heart-o" aria-hidden="true"></i>
                                06 <i class="fa fa-comment-o" aria-hidden="true"></i>02</span></p>
                            </div>
                        </div>
                    </div>


                    <div class="single_widget cat_widget">
                        <h4 class="text-uppercase pb-20">post archive</h4>
                        <ul>
                            <li>
                                <a href="#">Dec'17 <span>37</span></a>
                            </li>
                            <li>
                                <a href="#">Nov'17 <span>37</span></a>
                            </li>
                            <li>
                                <a href="#">Oct'17 <span>37</span></a>
                            </li>
                            <li>
                                <a href="#">Sept'17 <span>37</span></a>
                            </li>
                            <li>
                                <a href="#">Aug'17 <span>37</span></a>
                            </li>
                            <li>
                                <a href="#">Jul'17 <span>37</span></a>
                            </li>
                            <li>
                                <a href="#">Jun'17 <span>37</span></a>
                            </li>
                        </ul>
                    </div>
                    <div class="single_widget tag_widget">
                        <h4 class="text-uppercase pb-20">Tag Clouds</h4>
                        <ul>
                            <li><a href="#">Lifestyle</a></li>
                            <li><a href="#">Art</a></li>
                            <li><a href="#">Adventure</a></li>
                            <li><a href="#">Food</a></li>
                            <li><a href="#">Technology</a></li>
                            <li><a href="#">Fashion</a></li>
                            <li><a href="#">Adventure</a></li>
                            <li><a href="#">Food</a></li>
                            <li><a href="#">Technology</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End post Area -->
</div>
<!-- End post Area -->
@endsection

@push('js')
    <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5b1e90b0b8b646b3"></script>
@endpush
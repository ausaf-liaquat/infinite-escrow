@extends($activeTemplate.'layouts.frontend')
@section('content')
    <div class="section blog-section" style="background: #f7f7f7;">
        <div class="container container-restricted">
            <div class="row gy-5 g-lg-4">
                <div class="col-lg-12 col-xxl-12">
                    <div class="blog-details px-md-3">
                        

                        <div class="blog-details__body">
                            <h3 class="text-center">
                                {{__(@$blog->data_values->title)}}
                                
                            </h3>
                            <p class="text-center"> {{showDateTime(@$blog->created_at,'F d, Y')}}</p>
                            <div class="blog-details__img blog-details__img-xl">
                                {{-- <img src="https://placehold.co/425x300" alt="image" class="blog-post__img-is"> --}}
                                <img src="{{ getImage('assets/images/frontend/blog/'.@$blog->data_values->image,'425x300') }}" alt="image" class="blog-details__img-is"/>
                            </div>  
                            <div class="mt-4 contact-section__content-text">
                                @php echo @$blog->data_values->description_nic; @endphp
                            </div>



                       
                        </div>
                    </div>
                </div>

                {{-- <div class="col-lg-4 col-xxl-3">
                    <aside class="sidebar">
                        <nav class="sidebar-nav">
                        <ul class="list list--column">
                            <li class="list--column__item">
                                <div class="widget">
                                    <h4 class="widget__title mb-4">@lang('Recent Blogs')</h4>
                                    <ul class="list list--column widget-category">
                                        @foreach ($recentBlogs as $rBlog)
                                            <li class="list--column__item widget-category__item">
                                                <div class="d-flex pb-3">
                                                    <div class="me-3 flex-shrink-0">
                                                        <div class="user__img user__img--md">
                                                            <img src="{{ getImage('assets/images/frontend/blog/thumb_'.@$rBlog->data_values->image,'440x240') }}" alt="image" class="user__img-is"/>
                                                        </div>
                                                    </div>
                                                    <div class="article">
                                                        <h6 class="blog-post__title fw-md mt-0 mb-2">
                                                            <a href="{{ route('blog.details',[$rBlog->id,slug(__(@$blog->data_values->title))]) }}" class="t-link d-block text--accent t-link--base">
                                                                {{shortDescription(__(@$rBlog->data_values->title),22)}}
                                                            </a>
                                                        </h6>
                                                        <ul class="list list--row align-items-center">
                                                        <li class="list--row__item">
                                                            <div class="user align-items-center">
                                                            <p class="mb-0 sm-text t-heading-font">
                                                                {{__(@$rBlog->data_values->written_by)}}
                                                            </p>
                                                            </div>
                                                        </li>
                                                        <li class="list--row__item">
                                                            <p class="mb-0 sm-text t-heading-font text--accent">
                                                                {{showDateTime(@$blog->created_at,'F d, Y')}}
                                                            </p>
                                                        </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </li>
                        </ul>
                        </nav>
                    </aside>
                </div> --}}
            </div>
            <div class="container">
                <div class="row g-4 g-lg-3 g-xxl-4 justify-content-center">
                    <div class="col-md-4 col-lg-4">
        
                        <div class="card border-0">
                            <div class="card-body">
                                <div class="blog-post">
    
                                   
                                    <div class="blog-post__body">
                                        <h5 class="mt-0">
                                            Read More
                                        </h5>
                                        <p>
                                            What I Wish I Knew Before Starting a UX Research Career What I Wish I Knew Before Starting a UX Research Career
    
                                        </p>
                                     <p>What I Wish I Knew Before Starting a UX Research Career</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @foreach ($recentBlogs as $blog)
                        <div class="col-md-4 col-lg-4">
        
                            <div class="card border-0">
                                <div class="card-body">
                                    <div class="blog-post">
        
                                        <a href="{{ route('blog.details', [$blog->id, slug(__(@$blog->data_values->title))]) }}"
                                            class="blog-post__img t-link">
                                            {{-- <img src="https://placehold.co/440x420" alt="image" class="blog-post__img-is"> --}}
                                            <img src="{{ getImage('assets/images/frontend/blog/thumb_'.@$blog->data_values->image,'440x240') }}" alt="image" class="blog-post__img-is">
                                        </a>
                                        <div class="blog-post__body">
                                            <h5 class="mt-0">
                                                <a href="{{ route('blog.details', [$blog->id, slug(__(@$blog->data_values->title))]) }}"
                                                    class="t-link blog-post__title">
                                                    {{ shortDescription(__(@$blog->data_values->title), 60) }}
                                                </a>
                                            </h5>
                                            <p>
                                                {{ shortDescription(__(strip_tags(@$blog->data_values->description_nic)), 90) }}
                                                <span class="float-end mt-3">
                                                    <a style="text-decoration: none" class="text--accent"
                                                        href="{{ route('blog.details', [$blog->id, slug(__(@$blog->data_values->title))]) }}">
                                                        Read more <i class="fas fa-arrow-right"></i></a>
                                                </span>
        
                                            </p>
                                            {{-- <ul class="list list--row">
                                                <li class="list__item">
                                                    <div class="d-flex align-items-center">
                                                        <span class="flex-shrink-0 text--base d-inline-block lg-text me-2">
                                                            <i class="fas fa-user"></i>
                                                        </span>
                                                        <span class="d-block sm-text">
                                                            {{ __(@$blog->data_values->written_by) }}
                                                        </span>
                                                    </div>
                                                </li>
                                                <li class="list__item">
                                                    <div class="d-flex align-items-center">
                                                        <span class="flex-shrink-0 text--base d-inline-block lg-text me-2">
                                                            <i class="fas fa-calendar-alt"></i>
                                                        </span>
                                                        <span class="d-block sm-text">
                                                            {{ showDateTime(@$blog->created_at, 'd F Y') }}
                                                        </span>
                                                    </div>
                                                </li>
                                            </ul> --}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
@push('style')
    <style>
        .section {
    padding-top: clamp(98px, 8vw, 3px);
    padding-bottom: clamp(16px, 8vw, 11px);
}


    </style>
@endpush
@push('shareImage')
    <!-- Google / Search Engine Tags -->
    <meta itemprop="name" content="{{ __(@$blog->data_values->title) }}">
    <meta itemprop="description" content="{{ strip_tags(__(@$blog->data_values->description_nic)) }}">
    <meta itemprop="image" content="{{ getImage('assets/images/frontend/blog/'.@$blog->data_values->image,'425x300') }}">

    <!-- Facebook Meta Tags -->
    <meta property="og:image" content="{{ getImage('assets/images/frontend/blog/'.@$blog->data_values->image,'425x300') }}"/>
    <meta property="og:type" content="website">
    <meta property="og:title" content="{{ __(@$blog->data_values->title) }}">
    <meta property="og:description" content="{{ strip_tags(__(@$blog->data_values->description_nic)) }}">
    <meta property="og:image:type" content="{{ getImage('assets/images/frontend/blog/'.@$blog->data_values->image,'425x300') }}" />
    <meta property="og:image:width" content="425" />
    <meta property="og:image:height" content="300" />
    <meta property="og:url" content="{{ url()->current() }}">
@endpush

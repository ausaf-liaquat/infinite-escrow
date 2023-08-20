@php
    $blogContent = getContent('blog.content', true);
    $blogElements = getContent('blog.element', false, 3, true);
@endphp

<section class="section blog-section bg--light"
    style="padding-top: clamp(58px, 8vw, 3px);padding-bottom: clamp(138px, 8vw, 11px);">
    <div class="section__head">
        <div class="container">
            <div class="row g-4 justify-content-center">
                <div class="col-md-8 col-lg-7 col-xl-6">
                    <h3 class="mt-0 text-center" data-aos="zoom-in">
                        {{ __(@$blogContent->data_values->heading) }}
                    </h3>
                    <p class="section__para mb-0 text-center mx-auto" data-aos="zoom-in">
                        {{ __(@$blogContent->data_values->heading) }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row g-4 g-lg-3 g-xxl-4 justify-content-center">
            @foreach ($blogElements as $blog)
                <div class="col-md-6 col-lg-4">

                    <div class="card border-0" data-aos="zoom-in">
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
</section>

@extends('layout.app')

@section('content')
@include("include.search")

<div class="row tm-row">
    @foreach($blogsWithCategories as $row)
    <article class="col-12 col-md-6 tm-post">
        <hr class="tm-hr-primary">
        <a href="{{ route('website.blog', $row->url_slug) }}" class="effect-lily tm-post-link tm-pt-60">
            <div class="tm-post-link-inner">
                @if($row->image)
                <img src="{{ asset('public/'.$row->image) }}" alt="Image" class="img-fluid">
                @else
                <img src="{{ asset('public/img/placeholder.jpg') }}" alt="Image" class="img-fluid">
                @endif
            </div>
            <span class="position-absolute tm-new-badge">New</span>
            <h2 class="tm-pt-30 tm-color-primary tm-post-title">{{ $row->blog_title }}</h2>
        </a>
        <p class="tm-pt-30">
            {!! $row->description !!}
        </p>
        <div class="d-flex justify-content-between tm-pt-15">
            <span class="tm-color-primary">{{ $row->category_names }}</span>
            <span class="tm-color-primary">{{ date("d M Y", strtotime($row->created_at)) }}</span>
        </div>
    </article>
    @endforeach
</div>

<div class="row tm-row tm-mt-100 tm-mb-75">
    <div class="pagination">
        {{ $blogs->links() }}

    </div>
</div>

<!--
<div class="row tm-row tm-mt-100 tm-mb-75">
    <div class="tm-paging-wrapper pagination">
        <span class="d-inline-block mr-3">Page</span>
        <nav class="tm-paging-nav d-inline-block">
            <ul>
                <li class="tm-paging-item active">
                    <a href="#" class="mb-2 tm-btn tm-paging-link">1</a>
                </li>
                <li class="tm-paging-item">
                    <a href="#" class="mb-2 tm-btn tm-paging-link">2</a>
                </li>
                <li class="tm-paging-item">
                    <a href="#" class="mb-2 tm-btn tm-paging-link">3</a>
                </li>
                <li class="tm-paging-item">
                    <a href="#" class="mb-2 tm-btn tm-paging-link">4</a>
                </li>
            </ul>
        </nav>
    </div>
</div> -->
@endsection

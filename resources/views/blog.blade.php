@extends('layout.app')

@section('content')
@include("include.search")

<div class="row tm-row">
    <div class="col-lg-8 tm-post-col">
        <div class="tm-post-full">
            <div class="mb-4">
                @if($blog->image)
                <img src="{{ asset('public/'.$blog->image) }}" alt="Image" class="img-fluid">
                @else
                <img src="{{ asset('public/img/placeholder.jpg') }}" alt="Image" class="img-fluid">
                @endif

                <h2 class="pt-4 tm-color-primary tm-post-title">{{ $blog->blog_title }}</h2>
                <p class="tm-mb-40">{{ date("d M Y", strtotime($blog->created_at)) }}</p>
                {!! $blog->description !!}

                <span class="d-block text-right tm-color-primary">{{ $categoryNames }}</span>
            </div>

            <!-- Comments -->
            <div>
                <h2 class="tm-color-primary tm-post-title">Comments</h2>
                <hr class="tm-hr-primary tm-mb-45">

                @if(count($comments))
                @foreach($comments as $row)
                <div class="tm-comment tm-mb-45">
                    <figure class="tm-comment-figure">
                        <img src="{{ asset('public/img/user.png') }}" alt="Image" class="mb-2 rounded-circle img-thumbnail" width="64px">
                        <figcaption class="tm-color-primary text-center">{{ $row->full_name }}</figcaption>
                    </figure>
                    <div>
                        <p>
                            {{ $row->comment }}
                        </p>
                    </div>
                </div>
                @endforeach
                @else
                <p class="text-danger">
                    <small><em> No comments yet, be the 1st one to post a comment.</em></small>
                </p>
                @endif

                <!-- Comment Form -->

                <div class="alert alert-danger" id="error_msg" style="display:none"></div>
                <div class="alert alert-success" id="success_msg" style="display:none"></div>

                <form action="{{ route('submit-comment') }}" method="post" id="commentForm" class="mb-5 tm-comment-form">
                    @csrf
                    <input type="hidden" value="{{ $blog->id }}" name="blog_id" />
                    <h2 class="tm-color-primary tm-post-title mb-4">Your comment</h2>
                    <div class="mb-4">
                        <input class="form-control" name="full_name" type="text" placeholder="Name">
                    </div>
                    <div class="mb-4">
                        <textarea class="form-control" name="comment" rows="6" placeholder="Comment"></textarea>
                    </div>
                    <div class="text-right">
                        <button type="submit" class="tm-btn tm-btn-primary tm-btn-small">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <aside class="col-lg-4 tm-aside-col">
        <div class="tm-post-sidebar">
            <hr class="mb-3 tm-hr-primary">
            <h2 class="mb-4 tm-post-title tm-color-primary">Categories</h2>
            <ul class="tm-mb-75 pl-5 tm-category-list">
                @foreach($categories as $row)
                <li><a href="{{ route('website.blogs', $row->url_slug) }}" class="tm-color-primary">{{ $row->category_name }}</a></li>
                @endforeach
            </ul>
            <hr class="mb-3 tm-hr-primary">

            <h2 class="tm-mb-40 tm-post-title tm-color-primary">Related Posts</h2>

            @if(count($relatedPosts))
            @foreach($relatedPosts as $row)
            <a href="{{ route('website.blog', $row->url_slug) }}" class="d-block tm-mb-40">
                <figure>
                    @if($row->image)
                    <img src="{{ asset('public/'.$row->image) }}" alt="Image" class="mb-3 img-fluid">
                    @else
                    <img src="{{ asset('public/img/placeholder.jpg') }}" alt="Image" class="mb-3 img-fluid">
                    @endif
                    <figcaption class="tm-color-primary">{{ $row->blog_title }}</figcaption>
                </figure>
            </a>
            @endforeach
            @else
            <div class="alert alert-warning">No record found</div>
            @endif

        </div>
    </aside>
</div>

<script>
    // Step 1 - Add an event listner to the form with id "registerForm"
    document.getElementById("commentForm").addEventListener("submit", function(e) {
        // Prevent the default form submit event/behaviour
        e.preventDefault();

        // Get references of error and success message elemetns
        let error_msg = document.getElementById("error_msg");
        let success_msg = document.getElementById("success_msg");

        // Hide both error and success message initially
        error_msg.style.display = "none";
        success_msg.style.display = "none";

        // Validation for form fields - You need to work on

        // Get form data using FormData class/constructor
        const formData = new FormData(e.target);
        const url = this.getAttribute("action");

        // Make a POST request using Fetch API
        fetch(url, {
                method: "POST",
                headers: {
                    'Content-Type': "application/json",
                    'Accept': 'application/json'
                },
                body: JSON.stringify(Object.fromEntries(formData)),
            })
            .then(response => {
                return response.json();
            })
            .then(result => {
                // check the status of the result
                if (result.status == true) {
                    // Display success message and update the content
                    success_msg.style.display = "block";
                    success_msg.innerHTML = result.message;
                    this.reset();
                } else {
                    // Display error message and update the content
                    error_msg.style.display = "block";
                    error_msg.innerHTML = result.message;
                }
            })
            .catch(error => {
                console.log("Error", error);
                // Display error message and update the content
                error_msg.style.display = "block";
                error_msg.innerHTML = "Internal server error";
            });
    })
</script>
@endsection

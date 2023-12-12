@extends('layout.admin-app')

@section('content')
<!-- Start Content-->
<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">Blog Detail</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-xl-12 col-lg-6">
            <!-- project card -->
            <div class="card d-block">
                <div class="card-body">
                    <div class="dropdown float-right">
                        <a href="#" class="dropdown-toggle arrow-none card-drop" data-toggle="dropdown" aria-expanded="false">
                            <i class="dripicons-dots-3"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item"><i class="mdi mdi-pencil mr-1"></i>Edit</a>
                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item"><i class="mdi mdi-delete mr-1"></i>Delete</a>
                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item"><i class="mdi mdi-email-outline mr-1"></i>Invite</a>
                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item"><i class="mdi mdi-exit-to-app mr-1"></i>Leave</a>
                        </div>
                    </div>
                    <!-- project title-->
                    <h3 class="mt-0 font-20">
                        {{ $blog->blog_title }}
                    </h3>

                    {!! $blog->description !!}

                    <div class="mb-2">
                        <h5>Categories</h5>
                        @foreach($blog_categories as $row)
                        <div class="badge badge-secondary mb-3">{{ $row->category_name }}</div>
                        @endforeach
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-4">
                                <h5>Created On</h5>
                                <p>{{ date("d-m-Y, h:i a", strtotime($blog->created_at)) }}</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-4">
                                <h5>Update On</h5>
                                <p>{{ date("d-m-Y, h:i a", strtotime($blog->updated_at)) }}</p>
                            </div>
                        </div>
                    </div>
                </div> <!-- end card-body-->

            </div> <!-- end card-->

            <div class="card">
                <div class="card-body">
                    <h4 class="mt-0 mb-3">Comments ({{ count($comments) }})</h4>
                    <div class="mt-2">
                        @foreach($comments as $row)
                        <div class="media">
                            <div class="media-body">
                                <h5 class="mt-0">
                                    <span class="text-reset">{{ $row->full_name }}</span>
                                    <small class="text-muted">{{ date("d-m-Y, h:i a", strtotime($row->created_at)) }}</small>
                                </h5>
                                {{ $row->comment }}
                            </div>

                            <a href="#" class="btn btn-success btn-sm">Approve</a>
                            <a href="#" class="btn btn-danger btn-sm ml-2">Reject</a>
                        </div>
                        <hr>
                        @endforeach

                    </div>
                </div> <!-- end card-body-->
            </div>
            <!-- end card-->
        </div> <!-- end col -->

    </div>


</div> <!-- container -->
@endsection

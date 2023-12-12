@extends('layout.admin-app')

@section('content')
<!-- Start Content-->
<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">

                <h4 class="page-title">Dashboard</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-md-6 col-xl-3">
            <div class="widget-rounded-circle card-box">
                <div class="row">
                    <div class="col-6">
                        <div class="avatar-lg rounded-circle bg-soft-primary border-primary border">
                            <i class="fe-list font-22 avatar-title text-primary"></i>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="text-right">
                            <h3 class="mt-1"><span data-plugin="counterup">{{ $categories }}</span></h3>
                            <p class="text-muted mb-1 text-truncate">Categories</p>
                        </div>
                    </div>
                </div> <!-- end row-->
            </div> <!-- end widget-rounded-circle-->
        </div> <!-- end col-->

        <div class="col-md-6 col-xl-3">
            <div class="widget-rounded-circle card-box">
                <div class="row">
                    <div class="col-6">
                        <div class="avatar-lg rounded-circle bg-soft-success border-success border">
                            <i class="fe-shopping-cart font-22 avatar-title text-success"></i>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="text-right">
                            <h3 class="text-dark mt-1"><span data-plugin="counterup">{{ $blogs }}</span></h3>
                            <p class="text-muted mb-1 text-truncate">Total Blogs</p>
                        </div>
                    </div>
                </div> <!-- end row-->
            </div> <!-- end widget-rounded-circle-->
        </div> <!-- end col-->

        <div class="col-md-6 col-xl-3">
            <div class="widget-rounded-circle card-box">
                <div class="row">
                    <div class="col-6">
                        <div class="avatar-lg rounded-circle bg-soft-info border-info border">
                            <i class="fe-bar-chart-line- font-22 avatar-title text-info"></i>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="text-right">
                            <h3 class="text-dark mt-1"><span data-plugin="counterup">{{ $comments }}</h3>
                            <p class="text-muted mb-1 text-truncate">Comments</p>
                        </div>
                    </div>
                </div> <!-- end row-->
            </div> <!-- end widget-rounded-circle-->
        </div> <!-- end col-->

        <div class="col-md-6 col-xl-3">
            <div class="widget-rounded-circle card-box">
                <div class="row">
                    <div class="col-6">
                        <div class="avatar-lg rounded-circle bg-soft-warning border-warning border">
                            <i class="fe-eye font-22 avatar-title text-warning"></i>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="text-right">
                            <h3 class="text-dark mt-1"><span data-plugin="counterup">{{ $today_blogs }}</span></h3>
                            <p class="text-muted mb-1 text-truncate">Today's Blogs</p>
                        </div>
                    </div>
                </div> <!-- end row-->
            </div> <!-- end widget-rounded-circle-->
        </div> <!-- end col-->

        <!--Recent comments-->
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">Recent Comments on Blogs</h4>

                    <table class="table dt-responsive nowrap w-100">
                        <thead class="thead-light">
                            <tr>
                                <th>Sr No</th>
                                <th>Comment By</th>
                                <th>Comment</th>
                                <th>Blog Title</th>
                                <th>Created On</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>01</td>
                                <td>Ramesh Siyag</td>
                                <td>Very useful tutorial for <br>the beginners</td>
                                <td>Laravel Blog</td>
                                <td>21 Nov 2023</td>
                                <td><span class="badge badge-danger">Inactive</span></td>
                                <td>
                                    <a href="#" class="btn btn-success btn-sm">Approve</a>
                                    <a href="#" class="btn btn-danger btn-sm">Reject</a>
                                </td>
                            <tr>

                            <tr>
                                <td>02</td>
                                <td>Jatin Singh</td>
                                <td>This blog is very helpful, <br>very well written.</td>
                                <td>Laravel Blog</td>
                                <td>19 Nov 2023</td>
                                <td><span class="badge badge-success">Active</span></td>
                                <td>
                                    <a href="#" class="btn btn-danger btn-sm">Delete</a>
                                </td>
                            <tr>

                            <tr>
                                <td>03</td>
                                <td>Ali Saikh</td>
                                <td>Amazing write-up!</td>
                                <td>Criket News</td>
                                <td>19 Nov 2023</td>
                                <td><span class="badge badge-success">Active</span></td>
                                <td>
                                    <a href="#" class="btn btn-danger btn-sm">Delete</a>
                                </td>
                            <tr>

                            <tr>
                                <td>04</td>
                                <td>Monika Satyawali</td>
                                <td>Nice post.<br>Thank you for posting something like this</td>
                                <td>How to solve poverty in Africa</td>
                                <td>18 Nov 2023</td>
                                <td><span class="badge badge-success">Active</span></td>
                                <td>
                                    <a href="#" class="btn btn-danger btn-sm">Delete</a>
                                </td>
                            <tr>
                        </tbody>
                    </table>
                </div> <!-- end card body-->
            </div> <!-- end card -->
        </div><!-- end col-->
    </div>
    <!-- end row-->


</div> <!-- container -->
@endsection

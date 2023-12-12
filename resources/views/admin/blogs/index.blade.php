@extends('layout.admin-app')

@section('content')
<!-- Start Content-->
<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">Manage Blogs</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <!--Include alert file-->
        @include('admin.include.alert')

        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">All Blogs</h4>

                    <table id="basic-datatable" class="table dt-responsive nowrap w-100">
                        <thead>
                            <tr>
                                <th>Sr No</th>
                                <th>Title</th>
                                <th>Created On</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($blogs as $key => $row)
                            <tr>
                                <td>{{ ++$key }}</td>
                                <td><a href="{{ route('blog', $row->id) }}">{{ $row->blog_title }}</a></td>
                                <td>{{ date("d-m-Y, h:i a", strtotime($row->created_at)) }}</td>
                                <td>
                                    <span class="badge @if($row->status == 'active') badge-success @else badge-danger @endif">
                                        {{ $row->status }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('blogs.edit', $row->id) }}" class="btn btn-blue btn-sm">Edit</a>
                                    @if($row->status == 'active')
                                    <a href="{{ route('update-status', ['blogs', $row->id, 'inactive']) }}" class="btn btn-danger btn-sm">Inactive</a>
                                    @else
                                    <a href="{{ route('update-status', ['blogs', $row->id, 'active']) }}" class="btn btn-success btn-sm">Active</a>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>

                    </table>

                </div> <!-- end card body-->
            </div> <!-- end card -->
        </div><!-- end col-->
    </div>
</div> <!-- container -->
@endsection

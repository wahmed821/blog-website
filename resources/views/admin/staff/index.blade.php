@extends('layout.admin-app')

@section('content')
<!-- Start Content-->
<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">Manage Staff</h4>
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
                    <h4 class="header-title">All Staff Members</h4>

                    <table id="basic-datatable" class="table dt-responsive nowrap w-100">
                        <thead>
                            <tr>
                                <th>Sr No</th>
                                <th>Full Name</th>
                                <th>Created On</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($users as $key => $row)
                            <tr>
                                <td>{{ ++$key }}</td>
                                <td>{{ $row->name }}</td>
                                <td>{{ date("d-m-Y, h:i a", strtotime($row->created_at)) }}</td>
                                <td>
                                    <a href="{{ route('staffs.edit', $row->id) }}" class="btn btn-blue btn-sm">Edit</a>
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

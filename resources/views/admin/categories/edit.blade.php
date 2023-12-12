@extends('layout.admin-app')

@section('content')
<!-- Start Content-->
<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">Edit Category</h4>
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
                    <h4 class="header-title">Fill the Form</h4>
                    <hr>
                    <form method="post" action="{{ route('categories.store') }}">
                        @csrf

                        <input type="hidden" name="id" class="form-control" value="{{ $category->id }}">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label>Category Name</label>
                                    <input type="text" name="category_name" class="form-control" value="{{ $category->category_name }}">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="simpleinput">Status</label>
                                    <select name="status" class="form-control" name="status">
                                        <option value="">Please select</option>
                                        <option value="active" @if($category->status == 'active') selected @endif>Active</option>
                                        <option value="inactive" @if($category->status == 'inactive') selected @endif>Inactive</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <button type="submit" class="btn btn-success waves-effect waves-light">Save</button>
                            </div>
                        </div>
                    </form>
                    <!-- end row-->

                </div> <!-- end card-body -->
            </div> <!-- end card -->
        </div><!-- end col -->
    </div>


</div> <!-- container -->
@endsection

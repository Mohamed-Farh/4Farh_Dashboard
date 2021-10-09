@extends('layouts.admin_auth_app')

@section('title', 'Create Admin')

@section('style')
    <link rel="stylesheet" href="{{ asset('backend/vendor/select2/css/select2.min.css') }}">
@endsection

@section('content')


    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex">
            <h6 class="m-0 font-weight-bold text-primary">Create Admin</h6>
            <div class="ml-auto">
                <a href="{{ route('admin.admins.index') }}" class="btn btn-primary">
                    <span class="icon text-white-50">
                        <i class="fa fa-home"></i>
                    </span>
                    <span class="text">Admins</span>
                </a>
            </div>
        </div>
        <div class="card-body">

            <form action="{{ route('admin.admins.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-4">
                        <div class="form-group">
                            <label for="first_name">Admin First Name</label>
                            <input type="text" name="first_name" value="{{ old('first_name') }}" class="form-control">
                            @error('first_name')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>

                    <div class="col-4">
                        <div class="form-group">
                            <label for="last_name">Admin Last Name</label>
                            <input type="text" name="last_name" value="{{ old('last_name') }}" class="form-control">
                            @error('last_name')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>

                    <div class="col-4">
                        <div class="form-group">
                            <label for="username">Admin UserName</label>
                            <input type="text" name="username" value="{{ old('username') }}" class="form-control">
                            @error('username')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>
                </div>

                <div class="row pt-4">
                    <div class="col-3">
                        <div class="form-group">
                            <label for="email">Admin E-Mail</label>
                            <input type="email" name="email" value="{{ old('email') }}" class="form-control">
                            @error('email')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>

                    <div class="col-3">
                        <div class="form-group">
                            <label for="mobile">Admin Mobile</label>
                            <input type="text" name="mobile" value="{{ old('mobile') }}" class="form-control">
                            @error('mobile')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>

                    <div class="col-3">
                        <div class="form-group">
                            <label for="password">Admin Password</label>
                            <input type="password" name="password" class="form-control">
                            @error('password')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>

                    <div class="col-3">
                        <label for="status">Admin Status</label>
                        <select name="status" class="form-control">
                            <option value="1" {{ old('status') == 1 ? 'selected' : null }}>Active</option>
                            <option value="0" {{ old('status') == 0 ? 'selected' : null }}>Inactive</option>
                        </select>
                        @error('status')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>
                </div>


                <div class="row mt-4">
                    <div class="col-12">
                        <label for="permissions">Admin Permissions</label>
                        <select name="permissions[]" class="form-control select2" multiple="multiple">
                            @forelse ($permissions as $permission )
                                <option value="{{ $permission->id }}" {{ in_array($permission->id, old('permission',[]) ) ? 'selected' : null }}>{{ $permission->display_name }}</option>
                            @empty
                            @endforelse
                        </select>
                        @error('permissions')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>
                </div>

                <div class="row pt-4">
                    <div class="col-12">
                        <div class="form-group">
                            <label for="user_image">Admin Profile</label>
                            <input type="file" name="user_image" id="category_image" class="file-input-overview">
                            <span class="form-text text-muted">Image Width Should be (500px) X (500px)</span>
                            @error('user_image')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>
                </div>

                <div class="form-group pt-4">
                    <button type="submit" name="submit" class="btn btn-primary">Add Admin</button>
                </div>
            </form>
        </div>
    </div>



@endsection

@section('script')
    <script src="{{ asset('backend/vendor/select2/js/select2.full.min.js') }}"></script>
    <script>
        $(function() {
            $(".select2").select2({
                tags:true,
                closeOnSelect: false,
                minimumResultForsearch: Infinity
            });

            $('#category_image').fileinput({
                theme: "fas",
                maxFileCount: 1,
                allowedFileTypes: ['image'],
                showCancel: true,
                showRemove: false,
                showUpload: false,
                overwriteInitial: false,
            });
        });
    </script>
@endsection

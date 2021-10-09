@extends('layouts.admin_auth_app')

@section('title', 'Edit User')

@section('style')
    <link rel="stylesheet" href="{{ asset('backend/vendor/select2/css/select2.min.css') }}">
@endsection

@section('content')

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex">
            <h6 class="m-0 font-weight-bold text-primary">Edit User => {{ $user->full_name }}</h6>
            <div class="ml-auto">
                <a href="{{ route('admin.users.index') }}" class="btn btn-primary">
                    <span class="icon text-white-50">
                        <i class="fa fa-home"></i>
                    </span>
                    <span class="text">Users</span>
                </a>
            </div>
        </div>
        <div class="card-body">

            <form action="{{ route('admin.users.update', $user->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                <div class="row">
                    <div class="col-4">
                        <div class="form-group">
                            <label for="first_name">User First Name</label>
                            <input type="text" name="first_name" value="{{ old('first_name', $user->first_name ) }}" class="form-control">
                            @error('first_name')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>

                    <div class="col-4">
                        <div class="form-group">
                            <label for="last_name">User Last Name</label>
                            <input type="text" name="last_name" value="{{ old('last_name', $user->last_name ) }}" class="form-control">
                            @error('last_name')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>

                    <div class="col-4">
                        <div class="form-group">
                            <label for="username">User UserName</label>
                            <input type="text" name="username" value="{{ old('username', $user->username ) }}" class="form-control">
                            @error('username')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>
                </div>

                <div class="row pt-4">
                    <div class="col-3">
                        <div class="form-group">
                            <label for="email">User E-Mail</label>
                            <input type="email" name="email" value="{{ old('email', $user->email ) }}" class="form-control">
                            @error('email')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>

                    <div class="col-3">
                        <div class="form-group">
                            <label for="mobile">User Mobile</label>
                            <input type="text" name="mobile" value="{{ old('mobile', $user->mobile ) }}" class="form-control">
                            @error('mobile')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>

                    <div class="col-3">
                        <div class="form-group">
                            <label for="password">User Password</label>
                            <input type="password" name="password" class="form-control">
                            @error('password')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>

                    <div class="col-3">
                        <label for="status">User Status</label>
                        <select name="status" class="form-control">
                            <option value="1" {{ old('status', $user->status ) == 1 ? 'selected' : null }}>Active</option>
                            <option value="0" {{ old('status', $user->status ) == 0 ? 'selected' : null }}>Inactive</option>
                        </select>
                        @error('status')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-12">
                        <label for="permissions">User Permissions</label>
                        <select name="permissions[]" class="form-control select2" multiple="multiple">
                            @forelse ($permissions as $permission )
                                <option value="{{ $permission->id }}" {{ in_array($permission->id, old('permission', $userPermissions) ) ? 'selected' : null }}>{{ $permission->display_name }}</option>
                            @empty
                            @endforelse
                        </select>
                        @error('permissions')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>
                </div>

                <div class="row pt-4">
                    <div class="col-12">
                        <div class="form-group">
                            <label for="user_image">User Profile</label>
                            <input type="file" name="user_image" id="category_image" class="file-input-overview">
                            <span class="form-text text-muted">Image Width Should be (500px) X (500px)</span>
                            @error('user_image')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>
                </div>

                <div class="form-group pt-4">
                    <button type="submit" name="submit" class="btn btn-primary">Update User</button>
                </div>
            </form>
        </div>
    </div>



    @endsection

    @section('script')
        <script src="{{ asset('backend/vendor/select2/js/select2.full.min.js') }}"></script>
        <script>
            $(function () {

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
                initialPreview:[
                    @if ($user->user_image != '')
                        "{{url('assets/users/'.$user->user_image)}}"
                    @endif
                ],
                initialPreviewAsData: true,
                initialPreviewFileType: 'image',
                initialPreviewConfig: [
                    @if ($user->user_image != '')
                    {
                         caption: "{{ $user->user_image }}",
                         size: '1000',
                         width: "120px",
                         url: "{{ route('admin.users.removeImage', ['user_id'=>$user->id, '_token' => csrf_token()]) }}",
                         key: "{{ $user->id }}"
                    },
                    @endif
                ],
            });
        });
    </script>
@endsection

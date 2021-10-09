@extends('layouts.admin_auth_app')

@section('title', 'Edit Customer')

@section('content')


    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex">
            <h6 class="m-0 font-weight-bold text-primary">Edit Customer => {{ $customer->full_name }}</h6>
            <div class="ml-auto">
                <a href="{{ route('admin.customers.index') }}" class="btn btn-primary">
                    <span class="icon text-white-50">
                        <i class="fa fa-home"></i>
                    </span>
                    <span class="text">Customers</span>
                </a>
            </div>
        </div>
        <div class="card-body">

            <form action="{{ route('admin.customers.update', $customer->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                <div class="row">
                    <div class="col-4">
                        <div class="form-group">
                            <label for="first_name">Customer First Name</label>
                            <input type="text" name="first_name" value="{{ old('first_name', $customer->first_name ) }}" class="form-control">
                            @error('first_name')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>

                    <div class="col-4">
                        <div class="form-group">
                            <label for="last_name">Customer Last Name</label>
                            <input type="text" name="last_name" value="{{ old('last_name', $customer->last_name ) }}" class="form-control">
                            @error('last_name')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>

                    <div class="col-4">
                        <div class="form-group">
                            <label for="username">Customer UserName</label>
                            <input type="text" name="username" value="{{ old('username', $customer->username ) }}" class="form-control">
                            @error('username')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>
                </div>

                <div class="row pt-4">
                    <div class="col-3">
                        <div class="form-group">
                            <label for="email">Customer E-Mail</label>
                            <input type="email" name="email" value="{{ old('email', $customer->email ) }}" class="form-control">
                            @error('email')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>

                    <div class="col-3">
                        <div class="form-group">
                            <label for="mobile">Customer Mobile</label>
                            <input type="text" name="mobile" value="{{ old('mobile', $customer->mobile ) }}" class="form-control">
                            @error('mobile')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>

                    <div class="col-3">
                        <div class="form-group">
                            <label for="password">Customer Password</label>
                            <input type="password" name="password" class="form-control">
                            @error('password')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>

                    <div class="col-3">
                        <label for="status">Customer Status</label>
                        <select name="status" class="form-control">
                            <option value="1" {{ old('status', $customer->status ) == 1 ? 'selected' : null }}>Active</option>
                            <option value="0" {{ old('status', $customer->status ) == 0 ? 'selected' : null }}>Inactive</option>
                        </select>
                        @error('status')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>
                </div>

                <div class="row pt-4">
                    <div class="col-12">
                        <div class="form-group">
                            <label for="user_image">Customer Profile</label>
                            <input type="file" name="user_image" id="category_image" class="file-input-overview">
                            <span class="form-text text-muted">Image Width Should be (500px) X (500px)</span>
                            @error('user_image')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>
                </div>

                <div class="form-group pt-4">
                    <button type="submit" name="submit" class="btn btn-primary">Update Customer</button>
                </div>
            </form>
        </div>
    </div>



@endsection

@section('script')
    <script>
        $(function () {
            $('#category_image').fileinput({
                theme: "fas",
                maxFileCount: 1,
                allowedFileTypes: ['image'],
                showCancel: true,
                showRemove: false,
                showUpload: false,
                overwriteInitial: false,
                initialPreview:[
                    @if ($customer->user_image != '')
                        "{{url('assets/customers/'.$customer->user_image)}}"
                    @endif
                ],
                initialPreviewAsData: true,
                initialPreviewFileType: 'image',
                initialPreviewConfig: [
                    @if ($customer->user_image != '')
                    {
                         caption: "{{ $customer->user_image }}",
                         size: '1000',
                         width: "120px",
                         url: "{{ route('admin.customers.removeImage', ['customer_id'=>$customer->id, '_token' => csrf_token()]) }}",
                         key: "{{ $customer->id }}"
                    },
                    @endif
                ],
            });
        });
    </script>
@endsection

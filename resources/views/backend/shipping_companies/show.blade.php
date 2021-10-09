@extends('layouts.admin_auth_app')

@section('title', '{{ $admin->full_name }}')

@section('content')


    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex">
            <h6 class="m-0 font-weight-bold text-primary">Admin ({{ $admin->full_name }})</h6>
            <div class="ml-auto">
                <a href="{{ route('admin.users.index') }}" class="btn btn-primary">
                    <span class="icon text-white-50">
                        <i class="fa fa-home"></i>
                    </span>
                    <span class="text">Admins</span>
                </a>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-hover">
                <tbody>
                    <tr>
                        <td colspan="4">
                            @if ($admin->user_image != '')
                                <img src="{{ asset('assets/admins/' . $admin->user_image) }}" class="img-fluid">
                            @else
                                <img src="{{ asset('assets/admins/default.png') }}" class="img-fluid">
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Name</th>
                        <td>{{ $admin->name }} ({{ $admin->username }})</td>
                        <th>Email</th>
                        <td>{{ $admin->email }}</td>
                    </tr>
                    <tr>
                        <th>Mobile</th>
                        <td>{{ $admin->mobile }}</td>
                        <th>Status</th>
                        <td>{{ $admin->status == 1 ? 'Active' : 'InActive' }}</td>
                    </tr>
                    <tr>
                        <th>Created date</th>
                        <td>{{ $admin->created_at->format('d-m-Y h:i a') }}</td>
                        <th></th>
                        <td></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>




@endsection

@extends('layouts.admin_auth_app')

@section('title', 'All Admins')

@section('content')


<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex">
        <h6 class="m-0 font-weight-bold text-primary">Admins</h6>
        <div class="ml-auto">
            <a href="{{ route('admin.admins.create') }}" class="btn btn-primary">
                <span class="icon text-white-50">
                    <i class="fa fa-plus"></i>
                </span>
                <span class="text">Add new Admin</span>
            </a>
        </div>
    </div>

    @include('backend.admins.filter')

    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
            <tr>
                <th>Image</th>
                <th>Name</th>
                <th>Email & Mobile</th>
                <th>Status</th>
                <th>Created at</th>
                <th class="text-center" style="width: 30px;">Actions</th>
            </tr>
            </thead>
            <tbody>
            @forelse($admins as $admin)
                <tr>
                    <td>
                        @if ($admin->user_image != '')
                            <img class="rounded-circle" src="{{ asset('assets/users/' . $admin->user_image) }}" width="60" height="60" alt="{{ $admin->full_name }}">
                        @else
                            <img src="{{ asset('assets/users/avatar.png') }}" width="60">
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.admins.show', $admin->id) }}">{{ $admin->full_name }}</a>
                        <p class="text-gray-400"><b>{{ $admin->username }}</b></p>
                    </td>
                    <td>
                        {{ $admin->email }}
                        <p class="text-gray-400"><b>{{ $admin->mobile }}</b></p>
                    </td>
                    <td>{{ $admin->status == 1 ? 'Active' : 'Inactive'}}</td>
                    <td>{{ $admin->created_at->format('d-m-Y h:i a') }}</td>
                    <td>
                        <div class="btn-group">
                            <a href="{{ route('admin.admins.edit', $admin->id) }}" class="btn btn-primary"><i class="fa fa-edit"></i></a>
                            <a href="javascript:void(0)" onclick="if (confirm('Are You Sure To Delete This Admin?') ) { document.getElementById('user-delete-{{ $admin->id }}').submit(); } else { return false; }" class="btn btn-danger"><i class="fa fa-trash"></i></a>
                            <form action="{{ route('admin.admins.destroy', $admin->id) }}" method="post" id="user-delete-{{ $admin->id }}" style="display: none;">
                                @csrf
                                @method('DELETE')
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">No Admins found</td>
                </tr>
            @endforelse
            </tbody>
            <tfoot>
            <tr>
                <th colspan="6">
                    <div class="float-right">
                        {!! $admins->appends(request()->input())->links() !!}
                    </div>
                </th>
            </tr>
            </tfoot>
        </table>
    </div>
</div>


@endsection

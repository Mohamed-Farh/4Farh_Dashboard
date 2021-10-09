@extends('layouts.admin_auth_app')

@section('title', 'All Customers')

@section('content')


<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex">
        <h6 class="m-0 font-weight-bold text-primary">Customers</h6>
        <div class="ml-auto">
            <a href="{{ route('admin.customers.create') }}" class="btn btn-primary">
                <span class="icon text-white-50">
                    <i class="fa fa-plus"></i>
                </span>
                <span class="text">Add new Customer</span>
            </a>
        </div>
    </div>

    @include('backend.customers.filter')

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
            @forelse($customers as $customer)
                <tr>
                    <td>
                        @if ($customer->user_image != '')
                            <img class="rounded-circle" src="{{ asset('assets/customers/' . $customer->user_image) }}" width="60" height="60" alt="{{ $customer->full_name }}">
                        @else
                            <img src="{{ asset('assets/customers/avatar.png') }}" width="60">
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.customers.show', $customer->id) }}">{{ $customer->full_name }}</a>
                        <p class="text-gray-400"><b>{{ $customer->username }}</b></p>
                    </td>
                    <td>
                        {{ $customer->email }}
                        <p class="text-gray-400"><b>{{ $customer->mobile }}</b></p>
                    </td>
                    <td>{{ $customer->status == 1 ? 'Active' : 'Inactive'}}</td>
                    <td>{{ $customer->created_at->format('d-m-Y h:i a') }}</td>
                    <td>
                        <div class="btn-group">
                            <a href="{{ route('admin.customers.edit', $customer->id) }}" class="btn btn-primary"><i class="fa fa-edit"></i></a>
                            <a href="javascript:void(0)" onclick="if (confirm('Are You Sure To Delete This Customer?') ) { document.getElementById('user-delete-{{ $customer->id }}').submit(); } else { return false; }" class="btn btn-danger"><i class="fa fa-trash"></i></a>
                            <form action="{{ route('admin.customers.destroy', $customer->id) }}" method="post" id="user-delete-{{ $customer->id }}" style="display: none;">
                                @csrf
                                @method('DELETE')
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">No Customers found</td>
                </tr>
            @endforelse
            </tbody>
            <tfoot>
            <tr>
                <th colspan="6">
                    <div class="float-right">
                        {!! $customers->appends(request()->input())->links() !!}
                    </div>
                </th>
            </tr>
            </tfoot>
        </table>
    </div>
</div>


@endsection

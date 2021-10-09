@extends('layouts.admin_auth_app')

@section('title', 'All Customer Addresses')

@section('content')


    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex">
            <h6 class="m-0 font-weight-bold text-primary">Customer Addresses</h6>
            <div class="ml-auto">
                @ability('superAdmin', 'manage_customer_addresses,create_customer_addresses')
                    <a href="{{ route('admin.customer_addresses.create') }}" class="btn btn-primary">
                        <span class="icon text-white-50">
                            <i class="fa fa-plus"></i>
                        </span>
                        <span class="text">Add New Customer Address</span>
                    </a>
                @endability
            </div>
        </div>

        @include('backend.customer_addresses.filter')

        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>Customer Name</th>
                    <th>Title</th>
                    <th>Shipping Info</th>
                    <th>Location</th>
                    <th>Address</th>
                    <th>Zip Code</th>
                    <th>PO_Box</th>
                    <th class="text-center" style="width: 30px;">Actions</th>
                </tr>
                </thead>
                <tbody>
                @forelse($customer_addresses as $customer_address)
                    <tr>
                        <td>
                            <a href="{{ route('admin.customers.show', $customer_address->user_id) }}">{{ $customer_address->user->full_name }}</a>
                        </td>
                        <td>
                            <a href="{{ route('admin.customer_addresses.show', $customer_address->id) }}">{{ $customer_address->address_title }}</a>
                            <p class="text-gray-400"><b>{{ $customer_address->defaultAddress() }}</b></p>
                        </td>
                        <td>
                            {{ $customer_address->first_name .' '. $customer_address->last_name }}
                            <p class="text-gray-400">{{ $customer_address->email }}<br>{{ $customer_address->mobile }}</p>
                        </td>
                        <td>{{ $customer_address->country->name .' - '. $customer_address->state->name .' - '. $customer_address->city->name }}</td>
                        <td>{{ $customer_address->address }}</td>
                        <td>{{ $customer_address->zip_code }}</td>
                        <td>{{ $customer_address->po_box }}</td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                @ability('superAdmin', 'manage_customer_addresses,update_customer_addresses')
                                   <a href="{{ route('admin.customer_addresses.edit', $customer_address->id) }}" class="btn btn-primary"><i class="fa fa-edit"></i></a>
                                @endability

                                @ability('superAdmin', 'manage_customer_addresses,delete_customer_addresses')
                                    <a href="javascript:void(0)"
                                        onclick="
                                                if (confirm('Are You Sure You Want To Delete This Record ?') )
                                                    { document.getElementById('customer_address_delete_{{ $customer_address->id }}').submit(); }
                                                else
                                                    { return false; }"
                                        class="btn btn-danger"><i class="fa fa-trash"></i>
                                    </a>
                                @endability
                            </div>
                            <form action="{{ route('admin.customer_addresses.destroy', $customer_address->id) }}" method="post" id="customer_address_delete_{{ $customer_address->id }}" class="d-none">
                                @csrf
                                @method('DELETE')
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center">No Customer Addresses found</td>
                    </tr>
                @endforelse
                </tbody>
                <tfoot>
                <tr>
                    <th colspan="8">
                        <div class="float-right">
                            {!! $customer_addresses->appends(request()->input())->links() !!}
                        </div>
                    </th>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>



@endsection

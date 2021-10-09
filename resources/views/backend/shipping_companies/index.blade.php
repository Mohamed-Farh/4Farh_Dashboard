@extends('layouts.admin_auth_app')

@section('title', 'All ShippingCompanies')

@section('content')


    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex">
            <h6 class="m-0 font-weight-bold text-primary">ShippingCompanies</h6>
            <div class="ml-auto">
                <a href="{{ route('admin.shipping_companies.create') }}" class="btn btn-primary">
                    <span class="icon text-white-50">
                        <i class="fa fa-plus"></i>
                    </span>
                    <span class="text">Add new ShippingCompany</span>
                </a>
            </div>
        </div>

        @include('backend.shipping_companies.filter')

        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Company Name</th>
                        <th>Code</th>
                        <th>Description</th>
                        <th>Fast</th>
                        <th>Cost</th>
                        <th>Countries Count</th>
                        <th>Status</th>
                        <th>Created at</th>
                        <th class="text-center" style="width: 30px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($shipping_companies as $shippingCompany)
                        <tr>
                            <td>{{ $shippingCompany->name }}</td>
                            <td>{{ $shippingCompany->code }}</td>
                            <td>{{ $shippingCompany->description }}</td>
                            <td>{{ $shippingCompany->fast() }}</td>
                            <td>{{ $shippingCompany->cost }}</td>
                            <td>{{ $shippingCompany->countries_count }}</td>
                            <td>{{ $shippingCompany->status() }}</td>
                            <td>{{ $shippingCompany->created_at->format('d-m-Y h:i a') }}</td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{ route('admin.shipping_companies.edit', $shippingCompany->id) }}"
                                        class="btn btn-primary"><i class="fa fa-edit"></i></a>
                                    <a href="javascript:void(0)"
                                        onclick="if (confirm('Are You Sure To Delete This ShippingCompany?') ) { document.getElementById('user-delete-{{ $shippingCompany->id }}').submit(); } else { return false; }"
                                        class="btn btn-danger"><i class="fa fa-trash"></i></a>
                                </div>
                                <form action="{{ route('admin.shipping_companies.destroy', $shippingCompany->id) }}"
                                    method="post" id="user-delete-{{ $shippingCompany->id }}" style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center">No ShippingCompanies found</td>
                        </tr>
                    @endforelse
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="9">
                            <div class="float-right">
                                {!! $shipping_companies->appends(request()->input())->links() !!}
                            </div>
                        </th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>


@endsection

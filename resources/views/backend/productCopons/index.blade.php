@extends('layouts.admin_auth_app')

@section('title', 'All Product Copons')

@section('content')


    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex">
            <h6 class="m-0 font-weight-bold text-primary">Product Copons</h6>
            <div class="ml-auto">
                @ability('superAdmin', 'manage_productCopons,create_productCopons')
                    <a href="{{ route('admin.productCopons.create') }}" class="btn btn-primary">
                        <span class="icon text-white-50">
                            <i class="fa fa-plus"></i>
                        </span>
                        <span class="text">Add New Copon</span>
                    </a>
                @endability
            </div>
        </div>

        @include('backend.productCopons.filter')

        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>Code</th>
                    <th>Value</th>
                    <th>Description</th>
                    <th>Use Times</th>
                    <th>Validaty Date</th>
                    <th>Greater Than</th>
                    <th>Status</th>
                    <th>Created at</th>
                    <th class="text-center" style="width: 30px;">Actions</th>
                </tr>
                </thead>
                <tbody>
                @forelse($copons as $copon)
                    <tr>
                        <td>{{ $copon->code }}</td>
                        <td>{{ $copon->type == 'fixed' ? '$' : '%' }} {{ $copon->value }}</td>
                        <td>{{ $copon->description ?? ''}}</td>
                        <td>{{ $copon->used_times . '/' . $copon->use_times}}</td>
                        <td>{{ $copon->start_date != '' ? $copon->start_date->format('Y-m-d') . '-' . $copon->expire_date->format('Y-m-d') : '-' }}</td>
                        <td>{{ $copon->greater_than ?? '-' }}</td>
                        <td>{{ $copon->status == 1 ? 'Active' : 'Inactive'}}</td>
                        <td>{{ $copon->created_at->format('d-m-Y h:i a') }}</td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                @ability('superAdmin', 'manage_productCopons,update_productCopons')
                                   <a href="{{ route('admin.productCopons.edit', $copon->id) }}" class="btn btn-primary"><i class="fa fa-edit"></i></a>
                                @endability

                                @ability('superAdmin', 'manage_productCopons,delete_productCopons')
                                    <a href="javascript:void(0)"
                                        onclick="
                                                if (confirm('Are You Sure You Want To Delete This Record ?') )
                                                    { document.getElementById('productCopons_delete_{{ $copon->id }}').submit(); }
                                                else
                                                    { return false; }"
                                        class="btn btn-danger"><i class="fa fa-trash"></i>
                                    </a>
                                @endability
                            </div>
                            <form action="{{ route('admin.productCopons.destroy', $copon->id) }}" method="post" id="productCopons_delete_{{ $copon->id }}" class="d-none">
                                @csrf
                                @method('DELETE')
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">No Product Copons found</td>
                    </tr>
                @endforelse
                </tbody>
                <tfoot>
                <tr>
                    <th colspan="7">
                        <div class="float-right">
                            {!! $copons->appends(request()->input())->links() !!}
                        </div>
                    </th>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>



@endsection

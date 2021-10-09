@extends('layouts.admin_auth_app')

@section('title', 'All City')

@section('content')


    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex">
            <h6 class="m-0 font-weight-bold text-primary">Cities</h6>
            <div class="ml-auto">
                @ability('superAdmin', 'manage_cities,create_cities')
                    <a href="{{ route('admin.cities.create') }}" class="btn btn-primary">
                        <span class="icon text-white-50">
                            <i class="fa fa-plus"></i>
                        </span>
                        <span class="text">Add New City</span>
                    </a>
                @endability
            </div>
        </div>

        @include('backend.cities.filter')

        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>State Name</th>
                    <th>Status</th>
                    <th class="text-center" style="width: 30px;">Actions</th>
                </tr>
                </thead>
                <tbody>
                @forelse($cities as $city)
                    <tr>
                        <td>{{ $city->name }}</td>
                        <td>{{ $city->state->name }}</td>
                        <td>{{ $city->status == 1 ? 'Active' : 'Inactive'}}</td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                @ability('superAdmin', 'manage_cities,update_cities')
                                   <a href="{{ route('admin.cities.edit', $city->id) }}" class="btn btn-primary"><i class="fa fa-edit"></i></a>
                                @endability

                                @ability('superAdmin', 'manage_cities,delete_cities')
                                    <a href="javascript:void(0)"
                                        onclick="
                                                if (confirm('Are You Sure You Want To Delete This Record ?') )
                                                    { document.getElementById('city_delete_{{ $city->id }}').submit(); }
                                                else
                                                    { return false; }"
                                        class="btn btn-danger"><i class="fa fa-trash"></i>
                                    </a>
                                @endability
                            </div>
                            <form action="{{ route('admin.cities.destroy', $city->id) }}" method="post" id="city_delete_{{ $city->id }}" class="d-none">
                                @csrf
                                @method('DELETE')
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">No Cities found</td>
                    </tr>
                @endforelse
                </tbody>
                <tfoot>
                <tr>
                    <th colspan="7">
                        <div class="float-right">
                            {!! $cities->appends(request()->input())->links() !!}
                        </div>
                    </th>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>



@endsection

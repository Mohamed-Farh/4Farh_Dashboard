@extends('layouts.admin_auth_app')

@section('title', 'All Countries')

@section('content')


    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex">
            <h6 class="m-0 font-weight-bold text-primary">Countries</h6>
            <div class="ml-auto">
                @ability('superAdmin', 'manage_countries,create_countries')
                    <a href="{{ route('admin.countries.create') }}" class="btn btn-primary">
                        <span class="icon text-white-50">
                            <i class="fa fa-plus"></i>
                        </span>
                        <span class="text">Add New Country</span>
                    </a>
                @endability
            </div>
        </div>

        @include('backend.countries.filter')

        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>State Count</th>
                    <th>Status</th>
                    <th class="text-center" style="width: 30px;">Actions</th>
                </tr>
                </thead>
                <tbody>
                @forelse($countries as $country)
                    <tr>
                        <td>{{ $country->name }}</td>
                        <td>{{ $country->states->count() }}</td>
                        <td>{{ $country->status == 1 ? 'Active' : 'Inactive'}}</td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                @ability('superAdmin', 'manage_countries,update_countries')
                                   <a href="{{ route('admin.countries.edit', $country->id) }}" class="btn btn-primary"><i class="fa fa-edit"></i></a>
                                @endability

                                @ability('superAdmin', 'manage_countries,delete_countries')
                                    <a href="javascript:void(0)"
                                        onclick="
                                                if (confirm('Are You Sure You Want To Delete This Record ?') )
                                                    { document.getElementById('country_delete_{{ $country->id }}').submit(); }
                                                else
                                                    { return false; }"
                                        class="btn btn-danger"><i class="fa fa-trash"></i>
                                    </a>
                                @endability
                            </div>
                            <form action="{{ route('admin.countries.destroy', $country->id) }}" method="post" id="country_delete_{{ $country->id }}" class="d-none">
                                @csrf
                                @method('DELETE')
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">No Countries Found</td>
                    </tr>
                @endforelse
                </tbody>
                <tfoot>
                <tr>
                    <th colspan="7">
                        <div class="float-right">
                            {!! $countries->appends(request()->input())->links() !!}
                        </div>
                    </th>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>



@endsection

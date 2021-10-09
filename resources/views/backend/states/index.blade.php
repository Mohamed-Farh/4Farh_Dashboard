@extends('layouts.admin_auth_app')

@section('title', 'All States')

@section('content')


    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex">
            <h6 class="m-0 font-weight-bold text-primary">States</h6>
            <div class="ml-auto">
                @ability('superAdmin', 'manage_states,create_states')
                    <a href="{{ route('admin.states.create') }}" class="btn btn-primary">
                        <span class="icon text-white-50">
                            <i class="fa fa-plus"></i>
                        </span>
                        <span class="text">Add New State</span>
                    </a>
                @endability
            </div>
        </div>

        @include('backend.states.filter')

        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Country Name</th>
                    <th>Cities Count</th>
                    <th>Status</th>
                    <th class="text-center" style="width: 30px;">Actions</th>
                </tr>
                </thead>
                <tbody>
                @forelse($states as $state)
                    <tr>
                        <td>{{ $state->name }}</td>
                        <td>{{ $state->country->name }}</td>
                        <td>{{ $state->cities->count() }}</td>
                        <td>{{ $state->status == 1 ? 'Active' : 'Inactive'}}</td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                @ability('superAdmin', 'manage_states,update_states')
                                   <a href="{{ route('admin.states.edit', $state->id) }}" class="btn btn-primary"><i class="fa fa-edit"></i></a>
                                @endability

                                @ability('superAdmin', 'manage_states,delete_states')
                                    <a href="javascript:void(0)"
                                        onclick="
                                                if (confirm('Are You Sure You Want To Delete This Record ?') )
                                                    { document.getElementById('state_delete_{{ $state->id }}').submit(); }
                                                else
                                                    { return false; }"
                                        class="btn btn-danger"><i class="fa fa-trash"></i>
                                    </a>
                                @endability
                            </div>
                            <form action="{{ route('admin.states.destroy', $state->id) }}" method="post" id="state_delete_{{ $state->id }}" class="d-none">
                                @csrf
                                @method('DELETE')
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">No States found</td>
                    </tr>
                @endforelse
                </tbody>
                <tfoot>
                <tr>
                    <th colspan="7">
                        <div class="float-right">
                            {!! $states->appends(request()->input())->links() !!}
                        </div>
                    </th>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>



@endsection

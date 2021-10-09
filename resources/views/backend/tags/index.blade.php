@extends('layouts.admin_auth_app')

@section('title', 'All Tags')

@section('content')


    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex">
            <h6 class="m-0 font-weight-bold text-primary">Tags</h6>
            <div class="ml-auto">
                @ability('superAdmin', 'manage_tags,create_tags')
                    <a href="{{ route('admin.tags.create') }}" class="btn btn-primary">
                        <span class="icon text-white-50">
                            <i class="fa fa-plus"></i>
                        </span>
                        <span class="text">Add New Tag</span>
                    </a>
                @endability
            </div>
        </div>

        @include('backend.tags.filter')

        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Product Count</th>
                    <th>Status</th>
                    <th>Created at</th>
                    <th class="text-center" style="width: 30px;">Actions</th>
                </tr>
                </thead>
                <tbody>
                @forelse($tags as $tag)
                    <tr>
                        <td>{{ $tag->name }}</td>
                        <td>{{ $tag->products->count() }}</td>
                        <td>{{ $tag->status == 1 ? 'Active' : 'Inactive'}}</td>
                        <td>{{ $tag->created_at->format('d-m-Y h:i a') }}</td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                @ability('superAdmin', 'manage_tags,update_tags')
                                   <a href="{{ route('admin.tags.edit', $tag->id) }}" class="btn btn-primary"><i class="fa fa-edit"></i></a>
                                @endability

                                @ability('superAdmin', 'manage_tags,delete_tags')
                                    <a href="javascript:void(0)"
                                        onclick="
                                                if (confirm('Are You Sure You Want To Delete This Record ?') )
                                                    { document.getElementById('tag_delete_{{ $tag->id }}').submit(); }
                                                else
                                                    { return false; }"
                                        class="btn btn-danger"><i class="fa fa-trash"></i>
                                    </a>
                                @endability
                            </div>
                            <form action="{{ route('admin.tags.destroy', $tag->id) }}" method="post" id="tag_delete_{{ $tag->id }}" class="d-none">
                                @csrf
                                @method('DELETE')
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">No Tags found</td>
                    </tr>
                @endforelse
                </tbody>
                <tfoot>
                <tr>
                    <th colspan="7">
                        <div class="float-right">
                            {!! $tags->appends(request()->input())->links() !!}
                        </div>
                    </th>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>



@endsection

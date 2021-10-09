@extends('layouts.admin_auth_app')

@section('title', 'All Categories')

@section('content')


    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex">
            <h6 class="m-0 font-weight-bold text-primary">Categories</h6>
            <div class="ml-auto">
                @ability('superAdmin', 'manage_categories,create_categories')
                    <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
                        <span class="icon text-white-50">
                            <i class="fa fa-plus"></i>
                        </span>
                        <span class="text">Add New Category</span>
                    </a>
                @endability
            </div>
        </div>

        @include('backend.categories.filter')

        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Product Count</th>
                    <th>Parent</th>
                    <th>Status</th>
                    <th>Created at</th>
                    <th class="text-center" style="width: 30px;">Actions</th>
                </tr>
                </thead>
                <tbody>
                @forelse($categories as $category)
                    <tr>
                        <td>{{ $category->name }}</td>
                        <td>{{ $category->products_count }}</td>
                        <td>{{ $category->parent != null ? $category->parent->name : '-' }}</td>
                        <td>{{ $category->status == 1 ? 'Active' : 'Inactive'}}</td>
                        <td>{{ $category->created_at->format('d-m-Y h:i a') }}</td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                @ability('superAdmin', 'manage_categories,update_categories')
                                   <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn btn-primary"><i class="fa fa-edit"></i></a>
                                @endability

                                @ability('superAdmin', 'manage_categories,delete_categories')
                                    <a href="javascript:void(0)"
                                        onclick="
                                                if (confirm('Are You Sure You Want To Delete This Record ?') )
                                                    { document.getElementById('category_delete_{{ $category->id }}').submit(); }
                                                else
                                                    { return false; }"
                                        class="btn btn-danger"><i class="fa fa-trash"></i>
                                    </a>
                                @endability
                            </div>
                            <form action="{{ route('admin.categories.destroy', $category->id) }}" method="post" id="category_delete_{{ $category->id }}" class="d-none">
                                @csrf
                                @method('DELETE')
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">No Categories found</td>
                    </tr>
                @endforelse
                </tbody>
                <tfoot>
                <tr>
                    <th colspan="7">
                        <div class="float-right">
                            {!! $categories->appends(request()->input())->links() !!}
                        </div>
                    </th>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>



@endsection

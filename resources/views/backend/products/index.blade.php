@extends('layouts.admin_auth_app')

@section('title', 'All Products')

@section('content')


    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex">
            <h6 class="m-0 font-weight-bold text-primary">Products</h6>
            <div class="ml-auto">
                @ability('superAdmin', 'manage_products,create_products')
                    <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
                        <span class="icon text-white-50">
                            <i class="fa fa-plus"></i>
                        </span>
                        <span class="text">Add New Product</span>
                    </a>
                @endability
            </div>
        </div>

        @include('backend.products.filter')

        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Features</th>
                    <th>Quentity</th>
                    <th>Price</th>
                    <th>Tags</th>
                    <th>Status</th>
                    <th>Created at</th>
                    <th class="text-center" style="width: 30px;">Actions</th>
                </tr>
                </thead>
                <tbody>
                @forelse($products as $product)
                    <tr>
                        @if ($product->firstMedia)
                            <th><img src="{{ asset('assets/products/'. $product->firstMedia->file_name) }}" width="60" height="60" alt="{{ $product->name }}"></th>
                        @else
                            <th><img src="{{ asset('assets/no_image.png')}}" width="60" height="60" alt="{{ $product->name }}"></th>
                        @endif

                        <td>{{ $product->name }}</td>
                        <td>{{ $product->featured == 1 ? 'YES' : 'NO'}}</td>
                        <td>{{ $product->quantity }}</td>
                        <td>{{ $product->price }}</td>
                        <td>{{ $product->tags->pluck('name')->join(', ') }}</td>
                        <td>{{ $product->status == 1 ? 'Active' : 'Inactive'}}</td>
                        <td>{{ $product->created_at->format('d-m-Y h:i a') }}</td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                @ability('superAdmin', 'manage_products,update_products')
                                   <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-primary"><i class="fa fa-edit"></i></a>
                                @endability

                                @ability('superAdmin', 'manage_products,delete_products')
                                    <a href="javascript:void(0)"
                                        onclick="
                                                if (confirm('Are You Sure You Want To Delete This Record ?') )
                                                    { document.getElementById('product_delete_{{ $product->id }}').submit(); }
                                                else
                                                    { return false; }"
                                        class="btn btn-danger"><i class="fa fa-trash"></i>
                                    </a>
                                @endability
                            </div>
                            <form action="{{ route('admin.products.destroy', $product->id) }}" method="post" id="product_delete_{{ $product->id }}" class="d-none">
                                @csrf
                                @method('DELETE')
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-center">No Products found</td>
                    </tr>
                @endforelse
                </tbody>
                <tfoot>
                <tr>
                    <th colspan="9">
                        <div class="float-right">
                            {!! $products->appends(request()->input())->links() !!}
                        </div>
                    </th>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>



@endsection

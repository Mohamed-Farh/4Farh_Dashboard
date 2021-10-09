@extends('layouts.admin_auth_app')

@section('title', 'All Product Reviews')

@section('content')


    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex">
            <h6 class="m-0 font-weight-bold text-primary">Product Reviews</h6>
            <div class="ml-auto">
                {{-- @ability('superAdmin', 'manage_productReviews,create_productReviews')
                    <a href="{{ route('admin.productReviews.create') }}" class="btn btn-primary">
                        <span class="icon text-white-50">
                            <i class="fa fa-plus"></i>
                        </span>
                        <span class="text">Add New Product Review</span>
                    </a>
                @endability --}}
            </div>
        </div>

        @include('backend.productReviews.filter')

        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Message</th>
                    <th>Rating</th>
                    <th>Product</th>
                    <th>Status</th>
                    <th>Created at</th>
                    <th class="text-center" style="width: 30px">Actions</th>
                </tr>
                </thead>
                <tbody>
                @forelse($productReviews as $productReview)
                    <tr>
                        <td>
                            <small>{!! $productReview->user_id != '' ? $productReview->user->full_name : '' !!}</small> <br>
                            {{ $productReview->name }} <br>
                            {{ $productReview->email }}
                        </td>
                        <td>
                            <b>{{ $productReview->title }}</b><br>
                        </td>
                        <td><span class="badge badge-success">{{ $productReview->rating }}</span></td>
                        <td>{{ $productReview->product->name }}</td>
                        <td>{{ $productReview->status == 1 ? 'Active' : 'Inactive'}}</td>
                        <td>{{ $productReview->created_at->format('d-m-Y h:i a') }}</td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                @ability('superAdmin', 'manage_productReviews,update_productReviews')
                                   <a href="{{ route('admin.productReviews.edit', $productReview->id) }}" class="btn btn-primary"><i class="fa fa-edit"></i></a>
                                @endability

                                @ability('superAdmin', 'manage_productReviews,display_productReviews')
                                   <a href="{{ route('admin.productReviews.show', $productReview->id) }}" class="btn btn-success"><i class="fa fa-eye"></i></a>
                                @endability

                                @ability('superAdmin', 'manage_productReviews,delete_productReviews')
                                    <a href="javascript:void(0)"
                                        onclick="
                                                if (confirm('Are You Sure You Want To Delete This Record ?') )
                                                    { document.getElementById('productReview_delete_{{ $productReview->id }}').submit(); }
                                                else
                                                    { return false; }"
                                        class="btn btn-danger"><i class="fa fa-trash"></i>
                                    </a>
                                @endability
                            </div>
                            <form action="{{ route('admin.productReviews.destroy', $productReview->id) }}" method="post" id="productReview_delete_{{ $productReview->id }}" class="d-none">
                                @csrf
                                @method('DELETE')
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">No Product Reviews found</td>
                    </tr>
                @endforelse
                </tbody>
                <tfoot>
                <tr>
                    <th colspan="7">
                        <div class="float-right">
                            {!! $productReviews->appends(request()->input())->links() !!}
                        </div>
                    </th>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>



@endsection

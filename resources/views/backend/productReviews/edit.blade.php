@extends('layouts.admin_auth_app')

@section('title', 'Edit Product Review')

@section('content')


    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex">
            <h6 class="m-0 font-weight-bold text-primary">Edit Product Review {{ $productReview->name }}</h6>
            <div class="ml-auto">
                <a href="{{ route('admin.productReviews.index') }}" class="btn btn-primary">
                    <span class="icon text-white-50">
                        <i class="fa fa-home"></i>
                    </span>
                    <span class="text">Product Review</span>
                </a>
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.productReviews.update', $productReview->id) }}" method="post">
                @csrf
                @method('PATCH')
                <div class="row">
                    <div class="col-4">
                        <div class="form-group">
                            <label for="name">Client Name</label>
                            <input type="text" name="name" value="{{ old('name', $productReview->name) }}" class="form-control">
                            @error('name')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>

                    <div class="col-4">
                        <div class="form-group">
                            <label for="email">Client Email</label>
                            <input type="email" name="email" value="{{ old('email', $productReview->email) }}" class="form-control">
                            @error('email')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>

                    <div class="col-4">
                        <div class="form-group">
                            <label for="rating">Client Rating</label>
                            <select name="rating" class="form-control">
                                <option value="1" {{ old('rating', $productReview->rating) == '1' ? 'selected' : null }}>1</option>
                                <option value="2" {{ old('rating', $productReview->rating) == '2' ? 'selected' : null }}>2</option>
                                <option value="3" {{ old('rating', $productReview->rating) == '3' ? 'selected' : null }}>3</option>
                                <option value="4" {{ old('rating', $productReview->rating) == '4' ? 'selected' : null }}>4</option>
                                <option value="5" {{ old('rating', $productReview->rating) == '5' ? 'selected' : null }}>5</option>
                            </select>
                            @error('rating')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-4">
                        <div class="form-group">
                            <label for="product_id">Product Name</label>
                            <input type="text" value="{{ $productReview->product->name  }}" class="form-control" readonly>
                            <input type="hidden" name="product_id" value="{{ $productReview->product_id  }}" class="form-control">
                            @error('product_id')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>

                    <div class="col-4">
                        <div class="form-group">
                            <label for="user_id">Customer</label>
                            <input type="text" value="{{ $productReview->user_id != '' ?  $productReview->user->first_name : '-'}}" class="form-control">
                            <input type="hidden" name="user_id" value="{{ $productReview->user_id ??  '' }}" class="form-control">
                            @error('user_id')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>

                    <div class="col-4">
                        <label for="status">Product_Review Status</label>
                        <select name="status" class="form-control">
                            <option value="1" {{ old('status', $productReview->status) == 1 ? 'selected' : null }}>Active</option>
                            <option value="0" {{ old('status', $productReview->status) == 0 ? 'selected' : null }}>Inactive</option>
                        </select>
                        @error('status')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-12">
                        <label for="title">Review Title</label>
                        <input type="text" name="title" value="{{ old('title', $productReview->title) }}" class="form-control">
                        @error('title')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-12">
                        <label for="message">Review Message</label>
                        <textarea name="message" id="message" rows="5"
                            class="form-control">{!! old('message', $productReview->message ) !!}</textarea>
                        @error('message')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>
                </div>

                <div class="form-group pt-4">
                    <button type="submit" name="submit" class="btn btn-primary">Update Product_Review</button>
                </div>
            </form>
        </div>
    </div>



@endsection

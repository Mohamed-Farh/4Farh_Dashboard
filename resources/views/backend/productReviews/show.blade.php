@extends('layouts.admin_auth_app')

@section('title', 'Show Product Review')

@section('content')


<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex">
        <h6 class="m-0 font-weight-bold text-primary">Show Product Review</h6>
        <div class="ml-auto">
            <a href="{{ route('admin.productReviews.index') }}" class="btn btn-primary">
                <span class="icon text-white-50">
                    <i class="fa fa-home"></i>
                </span>
                <span class="text">Product Reviews</span>
            </a>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table">
            <tbody>
                <tr>
                    <th>Name</th>
                    <th>{{ $productReview->name }}</th>
                </tr>

                <tr>
                    <th>E-Mail</th>
                    <th>{{ $productReview->email }}</th>
                </tr>

                <tr>
                    <th>Customer Name</th>
                    <th>{{ $productReview->user_id != '' ? $productReview->user_id : '-' }}</th>
                </tr>

                <tr>
                    <th>Rating</th>
                    <th>{{ $productReview->rating }}</th>
                </tr>

                <tr>
                    <th>Title</th>
                    <th colspan="3">{{ $productReview->title }}</th>
                </tr>

                <tr>
                    <th>Message</th>
                    <th colspan="3">{{ $productReview->message }}</th>
                </tr>

                <tr>
                    <th>Created At</th>
                    <th colspan="3">{{ $productReview->created_at->format('Y-m-d') }}</th>
                </tr>
            </tbody>
        </table>
    </div>
</div>



@endsection

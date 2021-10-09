@extends('layouts.admin_auth_app')

@section('title', 'Create ShippingCompany')

@section('style')
    <link rel="stylesheet" href="{{ asset('backend/vendor/select2/css/select2.min.css') }}">
@endsection

@section('content')


    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex">
            <h6 class="m-0 font-weight-bold text-primary">Create ShippingCompany</h6>
            <div class="ml-auto">
                <a href="{{ route('admin.shipping_companies.index') }}" class="btn btn-primary">
                    <span class="icon text-white-50">
                        <i class="fa fa-home"></i>
                    </span>
                    <span class="text">ShippingCompanies</span>
                </a>
            </div>
        </div>
        <div class="card-body">

            <form action="{{ route('admin.shipping_companies.store') }}" method="post">
                @csrf
                <div class="row">
                    <div class="col-4">
                        <div class="form-group">
                            <label for="name">ShippingCompany Name</label>
                            <input type="text" name="name" value="{{ old('name') }}" class="form-control">
                            @error('name')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>

                    <div class="col-4">
                        <div class="form-group">
                            <label for="code">Code</label>
                            <input type="text" name="code" value="{{ old('code') }}" class="form-control">
                            @error('code')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>

                    <div class="col-4">
                        <div class="form-group">
                            <label for="description">Description</label>
                            <input type="text" name="description" value="{{ old('description') }}" class="form-control">
                            @error('description')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>
                </div>

                <div class="row pt-4">
                    <div class="col-3">
                        <label for="fast">Fast</label>
                        <select name="fast" class="form-control">
                            <option value="1" {{ old('fast') == 1 ? 'selected' : null }}>Fast Delivery</option>
                            <option value="0" {{ old('fast') == 0 ? 'selected' : null }}>Normal Delivery</option>
                        </select>
                        @error('status')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>

                    <div class="col-4">
                        <div class="form-group">
                            <label for="cost">Cost</label>
                            <input type="text" name="cost" value="{{ old('cost') }}" class="form-control">
                            @error('cost')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>

                    <div class="col-4">
                        <label for="status">Status</label>
                        <select name="status" class="form-control">
                            <option value="1" {{ old('status') == 1 ? 'selected' : null }}>Active</option>
                            <option value="0" {{ old('status') == 0 ? 'selected' : null }}>Inactive</option>
                        </select>
                        @error('status')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>
                </div>


                <div class="row mt-4">
                    <div class="col-12">
                        <label for="countries">Countries</label>
                        <select name="countries[]" class="form-control select2" multiple="multiple">
                            @forelse ($countries as $country )
                                <option value="{{ $country->id }}" {{ in_array($country->id, old('country',[]) ) ? 'selected' : null }}>{{ $country->name }}</option>
                            @empty
                            @endforelse
                        </select>
                        @error('countries')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>
                </div>

                <div class="form-group pt-4">
                    <button type="submit" name="submit" class="btn btn-primary">Add ShippingCompany</button>
                </div>
            </form>
        </div>
    </div>



@endsection

@section('script')
    <script src="{{ asset('backend/vendor/select2/js/select2.full.min.js') }}"></script>
    <script>
        $(function() {
            function matchStart(params, data){
                //if there are no search terms, return all of data
                if($.trim(params.true) === ''){
                    return data;
                }

                //skip if there is no children properties
                if(typeof data.children === 'undefined'){
                    return null;
                }

                //data.children contains the actual options that are matching against
                var filteredChildren = [];
                $.each(data.children, function(idx, child){
                    if(child.text.toUpperCase().indexOf(params.term.toUpperCase()) == 0){
                        filteredChildren.push(children);
                    }
                });

                //if no matched any of the timezone group's children, then set the matched children on the group and return the object
                if(filteredChildren.length){
                    var modifiedData = $.extend({}, data, true);
                    modifiedData.children = filteredChildren;

                    //you can return modified objects from here
                    //this includes matching the children how you want in nested data sets
                    return modifiedData;
                }

                //return null if the terms should not be displayed
                return null;
            }



            $(".select2").select2({
                tags:true,
                closeOnSelect: false,
                minimumResultForsearch: Infinity,
                match: matchStart
            });

        });
    </script>
@endsection

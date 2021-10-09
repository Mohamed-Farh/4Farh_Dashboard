@extends('layouts.admin_auth_app')

@section('title', 'Create Customer Addresses')

@section('content')


    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex">
            <h6 class="m-0 font-weight-bold text-primary">Create Customer Address</h6>
            <div class="ml-auto">
                <a href="{{ route('admin.customer_addresses.index') }}" class="btn btn-primary">
                    <span class="icon text-white-50">
                        <i class="fa fa-home"></i>
                    </span>
                    <span class="text">Customer Addresses</span>
                </a>
            </div>
        </div>
        <div class="card-body">

            <form action="{{ route('admin.customer_addresses.store') }}" method="post">
                @csrf
                <div class="row mt-2">
                    <div class="col-4">
                        <div class="form-group">
                            <label for="user_id">Customer Name</label>
                            <input type="text" name="customer_name" id="customer_name" value="{{ old('customer_name', request()->input('customer_name')) }}"
                                placeholder="Start Customer Search" class="form-control typeahead" data-provide="typeahead" autocomplete="off">
                            <input type="hidden" name="user_id" id="user_id" class="form-control" value="{{ old('user_id', request()->input('user_id')) }}" readonly>
                            @error('user_id')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>

                    <div class="col-4">
                        <div class="form-group">
                            <label for="address_title">Address Title</label>
                            <input type="text" name="address_title" value="{{ old('address_title') }}"
                                class="form-control">
                            @error('address_title')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>

                    <div class="col-4">
                        <label for="default_address">Default Address</a></label>
                        <select name="default_address" class="form-control">
                            <option value="1" {{ old('default_address') == 1 ? 'selected' : null }}>YES</option>
                            <option value="0" {{ old('default_address') == 0 ? 'selected' : null }}>NO</option>
                        </select>
                        @error('default_address')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="col-3">
                        <div class="form-group">
                            <label for="first_name">First Name</label>
                            <input type="text" name="first_name" value="{{ old('first_name') }}"
                                class="form-control">
                            @error('first_name')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>

                    <div class="col-3">
                        <div class="form-group">
                            <label for="last_name">Last Name</label>
                            <input type="text" name="last_name" value="{{ old('last_name') }}"
                                class="form-control">
                            @error('last_name')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>

                    <div class="col-3">
                        <div class="form-group">
                            <label for="email">E-Mail</label>
                            <input type="email" name="email" value="{{ old('email') }}"
                                class="form-control">
                            @error('email')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>

                    <div class="col-3">
                        <div class="form-group">
                            <label for="mobile">Mobile</label>
                            <input type="text" name="mobile" value="{{ old('mobile') }}"
                                class="form-control">
                            @error('mobile')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="col-4">
                        <label for="country_id">Country Name</label>
                        <select name="country_id" class="form-control" id="country_id">
                            <option value="">---</option>
                            @forelse ($countries as $country)
                                <option value="{{ $country->id }}" {{ old('country_id') == $country->id ? 'selected' : null }}>{{ $country->name }}</option>
                            @empty
                            @endforelse
                        </select>
                        @error('country_id')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>

                    <div class="col-4">
                        <label for="state_id">State Name</label>
                        <select name="state_id" id="state_id" class="form-control">
                        </select>
                        @error('state_id')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>

                    <div class="col-4">
                        <label for="city_id">City Name</label>
                        <select name="city_id" id="city_id" class="form-control">
                        </select>
                        @error('city_id')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-3">
                        <div class="form-group">
                            <label for="address">Address</label>
                            <input type="text" name="address" value="{{ old('address') }}"
                                class="form-control">
                            @error('address')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>

                    <div class="col-3">
                        <div class="form-group">
                            <label for="address2">Address 2</label>
                            <input type="text" name="address2" value="{{ old('address2') }}"
                                class="form-control">
                            @error('address2')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>

                    <div class="col-3">
                        <div class="form-group">
                            <label for="zip_code">ZIP Code</label>
                            <input type="number" name="zip_code" value="{{ old('zip_code') }}"
                                class="form-control" max="99999" min="0">
                            @error('zip_code')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>

                    <div class="col-3">
                        <div class="form-group">
                            <label for="po_box">PO.Code</label>
                            <input type="number" name="po_box" value="{{ old('po_box') }}"
                                class="form-control" max="9999" min="0">
                            @error('po_box')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>
                </div>

                <div class="form-group pt-4">
                    <button type="submit" name="submit" class="btn btn-primary">Add Customer Address</button>
                </div>
            </form>
        </div>
    </div>


@endsection

@section('script')
    <script src="{{ asset('backend/vendor/typeahead/bootstrap3-typeahead.min.js') }}"></script>
    <script>
        $(function () {
            $(".typeahead").typeahead({
                autoSelect: true,
                minLength: 3,
                delay: 400,
                displayText:
                    function (item) {
                        return item.full_name + ' - ' + item.email;
                    },
                source:
                    function (query, process){
                        return $.get("{{ route('admin.customers.get_customer') }}",
                                    { 'query' : query },
                                    function (data) { return process(data);
                        });
                    },
                afterSelect:function(data){
                    $('#user_id').val(data.id);
                }
            });

            populateStates();
            populateCities();

            $("#country_id").change(function(){
                populateStates();
                populateCities();
                return false;
            });

            $("#state_id").change(function(){
                populateCities();
                return false;
            });

            function populateStates()
            {
                let countryIdVal = $('#country_id').val() != null ? $('#country_id').val() : '{{ old('country_id') }}'; //عملت متغير يحمل قيمة رقم الدوله و في حالة بعت البيانات في الفورم و في حاجه غلط يرجع القيم اللي كنت مختارها قبل ما الفورم تتبعت
                $.get("{{ route('admin.customers.get_state_customerSearch') }}", {country_id: countryIdVal}, function(data){    //هعمل فانكشن واديها قيمه الدوله كمتغير فيها
                    $('option', $('#state_id')).remove();   //هحذف كل الاوبشن اللي موجدود في السيلكت
                    $('#state_id').append($('<option></option>').val('').html('---'));
                    $.each(data, function(val, text){
                        let selectedVal = text.id == '{{ old('state_id') }}' ? "selected" : "";
                        $("#state_id").append($('<option ' + selectedVal + '></option>').val(text.id).html(text.name));
                    });
                }, "json")

            }

            function populateCities()
            {
                let stateIdVal = $('#state_id').val() != null ? $('#state_id').val() : '{{ old('state_id') }}'; //عملت متغير يحمل قيمة رقم الدوله و في حالة بعت البيانات في الفورم و في حاجه غلط يرجع القيم اللي كنت مختارها قبل ما الفورم تتبعت
                $.get("{{ route('admin.customers.get_city_customerSearch') }}", {state_id: stateIdVal}, function(data){    //هعمل فانكشن واديها قيمه الدوله كمتغير فيها
                    $('option', $('#city_id')).remove();   //هحذف كل الاوبشن اللي موجدود في السيلكت
                    $('#city_id').append($('<option></option>').val('').html('---'));
                    $.each(data, function(val, text){
                        let selectedVal = text.id == '{{ old('city_id') }}' ? "selected" : "";
                        $("#city_id").append($('<option ' + selectedVal + '></option>').val(text.id).html(text.name));
                    });
                }, "json")
            }

        });
    </script>

@endsection

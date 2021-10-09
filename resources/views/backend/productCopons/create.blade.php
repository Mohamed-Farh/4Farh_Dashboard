@extends('layouts.admin_auth_app')

@section('title', 'Create Product Copon')

@section('style')
    <link rel="stylesheet" href="{{ asset('backend/vendor/pickadate/themes/classic.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/vendor/pickadate/themes/classic.date.css') }}">

    <style>
        .picker__select--month, .picker__select--year{
            padding: 0 !important;
        }
    </style>

@endsection

@section('content')



    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex">
            <h6 class="m-0 font-weight-bold text-primary">Create Product Copon</h6>
            <div class="ml-auto">
                <a href="{{ route('admin.productCopons.index') }}" class="btn btn-primary">
                    <span class="icon text-white-50">
                        <i class="fa fa-home"></i>
                    </span>
                    <span class="text">Product Copons</span>
                </a>
            </div>
        </div>
        <div class="card-body">

            <form action="{{ route('admin.productCopons.store') }}" method="post">
                @csrf
                <div class="row">
                    <div class="col-4">
                        <div class="form-group">
                            <label for="code">Copon Code</label>
                            <input type="text" name="code" id="code" value="{{ old('code') }}" class="form-control">
                            @error('code')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>

                    <div class="col-4">
                        <div class="form-group">
                            <label for="value">Copon Value</label>
                            <input type="text" name="value" value="{{ old('value') }}" class="form-control">
                            @error('value')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>


                    <div class="col-4">
                        <label for="type">Copon Type</label>
                        <select name="type" class="form-control">
                            <option value="Fixed" {{ old('type') == 'Fixed' ? 'selected' : null }}>Fixed</option>
                            <option value="Percentage" {{ old('type') == 'Percentage' ? 'selected' : null }}>Percentage
                            </option>
                        </select>
                        @error('type')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-4">
                        <div class="form-group">
                            <label for="use_times">Copon Use_Times</label>
                            <input type="number" name="use_times" value="{{ old('use_times') }}" class="form-control"
                                min="0">
                            @error('use_times')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>

                    <div class="col-4">
                        <div class="form-group">
                            <label for="greater_than">Copon Greater Than</label>
                            <input type="number" name="greater_than" value="{{ old('greater_than') }}"
                                class="form-control" min="0">
                            @error('greater_than')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>

                    <div class="col-4">
                        <label for="status">Copon Status</label>
                        <select name="status" class="form-control">
                            <option value="1" {{ old('status') == 1 ? 'selected' : null }}>Active</option>
                            <option value="0" {{ old('status') == 0 ? 'selected' : null }}>Inactive</option>
                        </select>
                        @error('status')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-4">
                        <div class="form-group">
                            <label for="start_date">Copon Start date</label>
                            <input type="text" name="start_date" id="start_date" value="{{ old('start_date') }}"
                                class="form-control">
                            @error('start_date')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>

                    <div class="col-4">
                        <div class="form-group">
                            <label for="expire_date">Copon Expire date</label>
                            <input type="text" name="expire_date" id="expire_date" value="{{ old('expire_date') }}"
                                class="form-control">
                            @error('expire_date')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-12">
                        <label for="description">Copon Description</label>
                        <textarea name="description" id="description" rows="5"
                            class="form-control">{!! old('description') !!}</textarea>
                        @error('description')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>
                </div>

                <div class="form-group pt-4">
                    <button type="submit" name="submit" class="btn btn-primary">Add Copon</button>
                </div>
            </form>
        </div>
    </div>



@endsection

@section('script')
    <script src="{{ asset('backend/vendor/pickadate/picker.js') }}"></script>
    <script src="{{ asset('backend/vendor/pickadate/picker.date.js') }}"></script>

    <script>
        $(function() {
            $('.summernote').summernote({
                tabSize: 2,
                height: 200,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'underline', 'clear']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture', 'video']],
                    ['view', ['fullscreen', 'codeview', 'help']]
                ]
            });
        });
    </script>

    <script>
        $(function() {
            $('#code').keyup(function(){
                this.value = this.value.toUpperCase();
            });

            $('#start_date').pickadate({
                format:'yyyy-mm-dd',
                selectMonths: true, //create a dropdown to control month
                selectYears: true,  //create a dropdown to control year
                clear:'Clear',
                close:'OK',
                closeOnSelect: true
            });

            var startdate = $('#start_date').pickadate('picker');  //define start date
            var enddate   = $('#expire_date').pickadate('picker');  //define end date

            //make expiredata start after startdate
            $('#start_date').change(function() {
                selected_ci_date ="";
                selected_ci_date =$('#start_date').val();
                if(selected_ci_date != null ){
                    var cidate = new Date(selected_ci_date);
                    min_codate = "";
                    min_codate = new Date();
                    min_codate.setDate(cidate.getDate()+1);
                    enddate.set('min', min_codate);
                }
            });

            $('#expire_date').pickadate({
                format:'yyyy-mm-dd',
                min: new Date(),
                selectMonths: true, //create a dropdown to control month
                selectYears: true,  //create a dropdown to control year
                clear:'Clear',
                close:'OK',
                closeOnSelect: true
            });
        });
    </script>
@endsection

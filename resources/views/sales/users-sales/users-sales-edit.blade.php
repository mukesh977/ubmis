@extends('layouts.layouts')
@section('title', 'Sales | Edit')
@section('content')
    <section class="content-header">
        <small class="md-txt">Welcome @if(Auth::user()->hasRole('admin') == '1')Administrator @else {{ Auth::user()->first_name.' '.Auth::user()->last_name }} @endif, <a href="https://www.google.com/maps/place/3720+Emerald+St,+Torrance,+CA+90503/@33.8403836,-118.3543828,17z/data=!4m18!1m15!4m14!1m6!1m2!1s0x80c2b4d407f58b11:0xdedca55964c89054!2s3720+Emerald+St,+Torrance,+CA+90503!2m2!1d-118.3520761!2d33.8403792!1m6!1m2!1s0x80c2b4d407f58b11:0xdedca55964c89054!2s3720+Emerald+St,+Torrance,+CA+90503!2m2!1d-118.3520761!2d33.8403792!3m1!1s0x80c2b4d407f58b11:0xdedca55964c89054" target="_blank"><i class="fa fa-map-marker rad-txt-danger"></i> Nepal</a></small>
        <ol class="breadcrumb">
            <li><a href="{{route('home')}}"><i class="fa fa-dashboard"></i>Home</a></li>
            <li><a href="{{route('sales.index')}}"><i class="fa fa-dashboard"></i>List All Sales</a></li>
            <li class="active">Sales Edit</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        @include('message.flash-message')
        <div class="row">
            <div class="col-xs-12 col-md-12">
                <div class="box box-success">
                    <div class="box-header with-border">
                        <h3 class="box-title">{{ trans('Sales Edit') }}</h3>
                        <div class="box-tools pull-right">
                            @role('marketingOfficer')
                            <a href="{{route('sales.index')}}" class="label label-primary">List All Sales</a>
                            <a href="{{route('sales.create')}}" class="label label-primary">Create New Sales</a>
                            @endrole
                            {{--<a href="#" class="label label-primary" data-toggle="modal" data-target="#user-target">Set New Target</a>--}}
                        </div><!--box-tools pull-right-->
                    </div><!-- /.box-header -->
                    <form action="{{route('sales.update', $sale->id)}}" method="POST">
                        {{csrf_field()}}
                        {{ method_field('put') }}
                        <div class="box-body">
                            <div class="form-group {{ $errors->has('date') ? ' has-error' : '' }}">
                                <label>Date <a type="button" data-toggle="tooltip" data-placement="right" data-container="body" title="This Field is Required. " style="color: #f00">*</a></label>

                                <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="text" class="form-control pull-right" name="date" id="datepicker"  value="{{ $sale->date }}">
                                </div>
                                @if ($errors->has('date'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('date') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group {{ $errors->has('company_id') ? ' has-error' : '' }}" id="office">
                                <label for="Office Name">Office Name</label>
                                <div id="officeMsg"></div>
                                <a href="#" class="add-new-office pull-right">Add New Office</a>
                                <select name="company_id" id="company_id" class="form-control">
                                    <option value="">--</option>
                                    @forelse($companies as $data)
                                        @if($sale->company_id == $data->id)
                                            <?php $selected = 'selected'; ?>
                                        @else
			                                <?php $selected = ''; ?>
                                        @endif
                                        <option value="{{ $data->id }}" {{$selected}}>{{ $data->office_name }}</option>
                                    @empty
                                    @endforelse
                                </select>
                                @if ($errors->has('company_id'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('company_id') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group {{ $errors->has('sales_category_id') ? ' has-error' : '' }}">
                                <label for="Purpose">Purpose</label>
                                {{--<a href="#" class="add-new-sale-category pull-right">Add New Purpose</a>--}}
                                <select name="sales_category_id" id="sales_category_id" class="form-control">
                                    <option value="">--</option>
                                    @forelse($salesCategories as $data)
                                        @if($sale->sales_category_id == $data->id)
			                                <?php $selected = 'selected'; ?>
                                        @else
			                                <?php $selected = ''; ?>
                                        @endif
                                        <option value="{{ $data->id }}" {{ $selected }}>{{ $data->name }}</option>
                                    @empty
                                    @endforelse
                                </select>
                                @if ($errors->has('sales_category_id'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('sales_category_id') }}</strong>
                                    </span>
                                @endif
                            </div>

                            {{--<div class="form-group {{ $errors->has('target_id') ? ' has-error' : '' }}">--}}
                                {{--<label for="Target">Target</label>--}}
                                {{--<select name="target_id" id="target_id" class="form-control">--}}
                                    {{--<option value="">--</option>--}}
                                    {{--@forelse($targets as $data)--}}
                                        {{--@if($sale->target_id == $data->id)--}}
			                                {{--<?php $selected = 'selected'; ?>--}}
                                        {{--@else--}}
			                                {{--<?php $selected = ''; ?>--}}
                                        {{--@endif--}}
                                        {{--<option value="{{ $data->id }}" {{ $selected }}>{{ $data->name }}</option>--}}
                                    {{--@empty--}}
                                    {{--@endforelse--}}
                                {{--</select>--}}
                                {{--@if ($errors->has('target_id'))--}}
                                    {{--<span class="help-block">--}}
                                        {{--<strong>{{ $errors->first('target_id') }}</strong>--}}
                                    {{--</span>--}}
                                {{--@endif--}}
                            {{--</div>--}}

                            <div class="form-group {{ $errors->has('received_amount') ? ' has-error' : '' }}">
                                <label for="Received Amount">Received Amount</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-dollar"></i>
                                    </div>
                                    <input type="text" name="received_amount" id="received_amount" class="form-control" placeholder="e.g. 100000" value="{{ $sale->received_amount }}">
                                    @if ($errors->has('received_amount'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('received_amount') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>


                        </div>
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        {{-- Create new office modal --}}
        @include('company.partials.create-new-office-modal')
        <!-- /.modal-dialog -->
        <script src="{{asset('js/office-modal.js')}}"></script>
        <script>
            $('#datepicker').datepicker();

            $('.add-new-sale-category').click(function(e){
                e.preventDefault();
                $('#saleModel').modal('show');
            });

            $('#save-sale-category').click(function(){
                var name = $('input[name="name"]').val();
                var description = $('textarea[name="description"]').val();
                console.log(description);
            })
        </script>
    </section>
@endsection
@extends('layouts.layouts')
@section('title', 'Visit | lists')
@section('content')
    <section class="content-header">
        <small class="md-txt">Welcome @if(Auth::user()->hasRole('admin') == '1')Administrator @else {{ Auth::user()->first_name.' '.Auth::user()->last_name }} @endif, <a href="https://www.google.com/maps/place/3720+Emerald+St,+Torrance,+CA+90503/@33.8403836,-118.3543828,17z/data=!4m18!1m15!4m14!1m6!1m2!1s0x80c2b4d407f58b11:0xdedca55964c89054!2s3720+Emerald+St,+Torrance,+CA+90503!2m2!1d-118.3520761!2d33.8403792!1m6!1m2!1s0x80c2b4d407f58b11:0xdedca55964c89054!2s3720+Emerald+St,+Torrance,+CA+90503!2m2!1d-118.3520761!2d33.8403792!3m1!1s0x80c2b4d407f58b11:0xdedca55964c89054" target="_blank"><i class="fa fa-map-marker rad-txt-danger"></i> Nepal</a></small>
        <ol class="breadcrumb">
            <li><a href="{{route('home')}}"><i class="fa fa-dashboard"></i>Home</a></li>
            <li class="active">Daily Visit Lists</li>
        </ol>
        @role(['marketingBoy', 'marketingOfficer'])
        @if(Session::has('message'))
            <div class="alert alert-default alert-block">
                <strong>{{ Session::get('message')  }}</strong>
            </div>
        @endif
        @endauth
    </section>

    <!-- Main content -->
    <section class="content">
        @include('message.flash-message')
        <div class="row">
            <div class="col-xs-12 col-md-12">
                <div class="box box-success">
                    <div class="box-header with-border">
                        <h3 class="box-title">{{ trans('Create New Field Visit') }}</h3>
                        <div class="box-tools pull-right">
                            {{--@include('user.partials.user-header-buttons')--}}
                            <a href="{{route('daily-field-visits.create')}}" class="label label-primary">Create New Visit</a>
                            <a href="{{route('daily-field-visits.index')}}" class="label label-info">List All Field Visit</a>

                        </div><!--box-tools pull-right-->
                    </div><!-- /.box-header -->
                    <form role="form" class="visitors-form" method="POST" action="{{route('next-field-visits.store')}}">
                        {{csrf_field()}}
                        <div class="box-body">
                            <div class="form-group {{ $errors->has('date') ? ' has-error' : '' }}">
                                <label>Date <a type="button" data-toggle="tooltip" data-placement="right" data-container="body" title="This Field is Required. " style="color: #f00">*</a></label>

                                @role(['marketingOfficer', 'marketingBoy'])
                                    <div class="input-group date">
                                        <p>{{ date('Y-m-d') }}</p>
                                        <input type="hidden" class="form-control pull-right form_date" name="date" value="{{ date('Y-m-d') }}">
                                    </div>
                                @else
                                    <div class="input-group date">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <input type="date" class="form-control" name="date" id="name" value="{{ old('date') }}">
                                    </div>
                                    @if ($errors->has('date'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('date') }}</strong>
                                        </span>
                                    @endif
                                @endrole
                                
                            </div>

                            <div class="form-group {{ $errors->has('company_id') ? ' has-error' : '' }}">
                                <label for="Office Name">Office Name <a type="button" data-toggle="tooltip" data-placement="right" data-container="body" title="This Field is Required. " style="color: #f00">*</a></label>
                                <a href="{{route('daily-field-visits.create')}}" class="create-new-field-visits pull-right">Create New Field Visits</a>
                                <select class="form-control select2" name="company_id" id="company_id">
                                    <option value="">---</option>
                                    @forelse($companies as $data)
                                    <option value="{{ $data->id }}" {{ (old('company_id') == $data->id ? "selected" : '') }}>{{ ucfirst($data->name) }}</option>
                                    @empty
                                    @endforelse
                                </select>

                                @if ($errors->has('company_id'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('company_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                            
                            <div class="form-group {{ $errors->has('next_visit_comments') ? ' has-error' : '' }}">
                                <label for="next-visit-commets">Word <a type="button" data-toggle="tooltip" data-placement="right" data-container="body" title="This Field is Required. " style="color: #f00">*</a></label>
                                <textarea name="next_visit_comments" id="next_visit_comments" rows="5" class="form-control">
                                {{ old('next_visit_comments') }}
                                </textarea>
                                @if ($errors->has('next_visit_comments'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('next_visit_comments') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group {{ $errors->has('next_visit_date') ? ' has-error' : '' }}">
                                <label>Next Visit <a type="button" data-toggle="tooltip" data-placement="right" data-container="body" title="This Field is Required. " style="color: #f00">*</a></label>
                                <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="date" class="form-control" name="next_visit_date" id="next_visit_date" value="{{ old('next_visit_date') }}">
                                </div>
                                @if ($errors->has('next_visit_date'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('next_visit_date') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <script>
        $(document).ready(function(){
            $('.select2').select2()
        });
    </script>
    @endsection
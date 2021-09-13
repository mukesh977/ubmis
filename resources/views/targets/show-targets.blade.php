@extends('layouts.layouts')
@section('title', 'Target | Setting')
@section('content')
    <section class="content-header">
        <small class="md-txt">Welcome @if(Auth::user()->hasRole('admin') == '1')Administrator @else {{ Auth::user()->first_name.' '.Auth::user()->last_name }} @endif, <a href="https://www.google.com/maps/place/3720+Emerald+St,+Torrance,+CA+90503/@33.8403836,-118.3543828,17z/data=!4m18!1m15!4m14!1m6!1m2!1s0x80c2b4d407f58b11:0xdedca55964c89054!2s3720+Emerald+St,+Torrance,+CA+90503!2m2!1d-118.3520761!2d33.8403792!1m6!1m2!1s0x80c2b4d407f58b11:0xdedca55964c89054!2s3720+Emerald+St,+Torrance,+CA+90503!2m2!1d-118.3520761!2d33.8403792!3m1!1s0x80c2b4d407f58b11:0xdedca55964c89054" target="_blank"><i class="fa fa-map-marker rad-txt-danger"></i> Nepal</a></small>
        <ol class="breadcrumb">
            <li><a href="{{route('home')}}"><i class="fa fa-dashboard"></i>Home</a></li>
            <li><a href="{{route('users-targets.index')}}"><i class="fa fa-dashboard"></i>Targets</a></li>
            <li class="active">Target Show</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12 col-md-12">
                <div class="box box-success">
                    <div class="box-header with-border">
                        <h3 class="box-title">{{ trans('Target Show') }}</h3>
                        <div class="box-tools pull-right">
                            {{--@include('user.partials.user-header-buttons')--}}
                            @role('marketingManager')
                            <a href="{{route('users-targets.index')}}" class="label label-primary">List All Targets</a>
                            <a href="{{route('users-targets.create')}}" class="label label-primary">Set New Target</a>
                            @endrole
                            {{--<a href="#" class="label label-primary" data-toggle="modal" data-target="#user-target">Set New Target</a>--}}
                        </div><!--box-tools pull-right-->
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        @include('message.flash-message')
                        <div class="table-responsive">
                            <table id="targets-table" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>Targeted User</th>
                                    <th>Target Type</th>
                                    <th>Target Total</th>
                                    <th>Target Set By</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>@if(!empty($userTarget->users)) {{ $userTarget->users->first_name.' '.$userTarget->users->last_name }}@endif</td>
                                    <td><span class="label label-info">@if(!empty($userTarget->targets)) {{ $userTarget->targets->name }}@endif</span></td>
                                    <td>
                                        <div class="form-group">
                                            <input type="text" value="Rs. {{ $userTarget->total_target }}" class="form-control" readonly>
                                        </div>
                                    </td>
                                    <td>
                                        {{ $userTarget->created_by }}
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div><!--table-responsive-->
                    </div><!-- /.box-body -->
                </div><!--box-->
            </div>
        </div>
    </section>
@endsection
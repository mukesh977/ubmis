@extends('layouts.layouts')
@section('title', 'Visit | Show')
@section('content')
    <section class="content-header">
        <small class="md-txt">Welcome @if(Auth::user()->hasRole('admin') == '1')Administrator @else {{ Auth::user()->first_name.' '.Auth::user()->last_name }} @endif, <a href="https://www.google.com/maps/place/3720+Emerald+St,+Torrance,+CA+90503/@33.8403836,-118.3543828,17z/data=!4m18!1m15!4m14!1m6!1m2!1s0x80c2b4d407f58b11:0xdedca55964c89054!2s3720+Emerald+St,+Torrance,+CA+90503!2m2!1d-118.3520761!2d33.8403792!1m6!1m2!1s0x80c2b4d407f58b11:0xdedca55964c89054!2s3720+Emerald+St,+Torrance,+CA+90503!2m2!1d-118.3520761!2d33.8403792!3m1!1s0x80c2b4d407f58b11:0xdedca55964c89054" target="_blank"><i class="fa fa-map-marker rad-txt-danger"></i> Nepal</a></small>
        <ol class="breadcrumb">
            <li><a href="{{route('home')}}"><i class="fa fa-dashboard"></i>Home</a></li>
            <li><a href="{{route('daily-field-visits.index')}}"><i class="fa fa-dashboard"></i>Field Visits</a></li>
            <li class="active">Daily Visit Show</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        @include('message.flash-message')
        <div class="row">
            <div class="col-xs-12 col-md-12">
                <div class="box box-success">
                    <div class="box-header with-border">
                        <h3 class="box-title">{{ trans('Daily Visit Details') }}</h3>
                        <div class="box-tools pull-right">
                            {{--@include('user.partials.user-header-buttons')--}}
                            <a href="{{route('daily-field-visits.create')}}" class="label label-primary">Create New Visit</a>
                            <a href="{{route('next-field-visits.create')}}" class="label label-primary">Create Next Field Visit</a>
                            <a href="{{route('daily-field-visits.index')}}" class="label label-primary">List All Field Visit</a>

                        </div><!--box-tools pull-right-->
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <tbody>
                                <tr>
                                    <td>Date</td>
                                    <td>{{ \Carbon\Carbon::parse($visitDatas->date)->format('F j, Y') }}</td>
                                </tr>
                                <tr>
                                    <td>Office Name</td>
                                    <td>{{ $visitDatas->companies->name }}</td>
                                </tr>
                                <tr>
                                    <td>Email Address</td>
                                    <td>{{ $visitDatas->email_address }}</td>
                                </tr>
                                <tr>
                                    <td>Address</td>
                                    <td>{{ $visitDatas->address }}</td>
                                </tr>
                                <tr>
                                    <td>Visited By</td>
                                    <td>@if(!empty($visitDatas->users)) {{ $visitDatas->users->first_name.' '.$visitDatas->users->last_name }}@endif</td>
                                </tr>
                                <tr>
                                    <td>Visited To</td>
                                    <td>{{ $visitDatas->visited_to }}</td>
                                </tr>
                                <tr>
                                    <td>Visitors Contact Number</td>
                                    <td>
                                        @forelse($visitDatas->visitorDetails as $data)
                                            {{$data->visitors_contact}},&nbsp;
                                        @empty
                                        @endforelse
                                    </td>
                                </tr>
                                <tr>
                                    <td>Visitors Email Address</td>
                                    <td>
                                        @forelse($visitDatas->visitorDetails as $data)
                                            {{$data->visitors_email}},&nbsp;
                                        @empty
                                        @endforelse
                                    </td>
                                </tr>
                                <tr>
                                    <td>Targets</td>
                                    <td>@if(!empty($visitDatas->targets)) {{ $visitDatas->targets->name}}@endif</td>
                                </tr>
                                <tr>
                                    <td>Visit Category</td>
                                    <td>
                                        @if(!empty($visitDatas->visitCategories))
                                            <span class="label label-primary">{{$visitDatas->visitCategories->name}}</span>&nbsp;
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td>Contact Person</td>
                                    <td>{{ $visitDatas->contact_person }}</td>
                                </tr>
                                <tr>
                                    <td>Contact Number</td>
                                    <td>
                                        @forelse($visitDatas->contactDetails as $data)
                                            {{$data->contact_number}},&nbsp;
                                        @empty
                                        @endforelse
                                    </td>
                                </tr>
                                <tr>
                                    <td>Contact Email Address</td>
                                    <td>
                                        @forelse($visitDatas->contactDetails as $data)
                                            {{$data->contact_email}},&nbsp;
                                        @empty
                                        @endforelse
                                    </td>
                                </tr>
                                <tr>
                                    <td>Requirements</td>
                                    <td>{{ $visitDatas->requirements }}</td>
                                </tr>
                                <tr>
                                    <td>Next Visit Date</td>
                                    <td>{{ ($visitDatas->next_visit_date != NULL)? \Carbon\Carbon::parse($visitDatas->next_visit_date)->format('F j, Y') : '' }}</td>
                                </tr>
                                <tr>
                                    <td>Project Scope</td>
                                    <td>{{ $visitDatas->project_scope }}</td>
                                </tr>
                                <tr>
                                    <td>Project Status</td>
                                    <td>@if($visitDatas->project_status ==1) Positive @else Negative @endif</td>
                                </tr>
                                <tr>
                                    <td>Reasons</td>
                                    <td>{{ $visitDatas->reasons }}</td>
                                </tr>
                                <tr>
                                    <td>Weakness</td>
                                    <td>{{ $visitDatas->weakness }}</td>
                                </tr>
                                <tr>
                                    <td>Comments</td>
                                    <td>{{ $visitDatas->comments }}</td>
                                </tr>
                                <tr>
                                    <td>Field Visit Status</td>
                                    <td>Pending</td>
                                </tr>
                                @if(!empty($data->fieldVisitAssignedBy))
                                <tr>
                                    <td>Assigned By</td>
                                    <td>
                                        {{ $data->fieldVisitAssignedBy->first_name.' '.$data->fieldVisitAssignedBy->last_name  }}
                                    </td>
                                </tr>
                                @endif
                                @if(!empty($data->fieldVisitAssignedTo))
                                <tr>
                                    <td>Assigned To</td>
                                    <td>
                                         {{ $data->fieldVisitAssignedTo->first_name.' '.$data->fieldVisitAssignedTo->last_name  }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>Assigned Date</td>
                                    <td>
                                        {{ \Carbon\Carbon::parse($visitDatas->assigned_date)->format('F j, Y') }}
                                    </td>
                                </tr>
                                @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @endsection
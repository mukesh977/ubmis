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
                        <h3 class="box-title">{{ trans('Daily Visit Lists') }}</h3>
                        <div class="box-tools pull-right">
                            {{--@include('user.partials.user-header-buttons')--}}
                            <a href="{{route('daily-field-visits.create')}}" class="label label-primary">Create New Visit</a>
                            <a href="{{route('next-field-visits.create')}}" class="label label-primary">Create Next Field Visit</a>

                        </div><!--box-tools pull-right-->
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <div class="table-responsive">
                            <table id="visit-table" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>SN</th>
                                    <th>Date</th>
                                    <th>Office Name</th>
                                    <th>Email Address</th>
                                    <th>Visited To</th>
                                    <th>Visited By</th>
                                    <th>Target</th>
                                    <th>Visit Category</th>
                                    @role(['admin','marketingManager'])
                                    <th>Assigned To</th>
                                    @endauth
                                    @role(['marketingOfficer','marketingManager','marketingBoy'])
                                    <th>Assigned By</th>
                                    @endauth
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $sn = 1; ?>

                                @forelse($visitDatas as $data)
                                <tr>
                                    <td>{{ $sn++ }}</td>
                                    <td><a href="{{ route('daily-field-visits.show', $data->id) }}">{{ \Carbon\Carbon::parse($data->date)->format('F j, Y') }}</a></td>
                                    <td>{{ $data->companies->name }}</td>
                                    <td>{{ $data->email_address }}</td>
                                    <td>{{ $data->visited_to }}</td>
                                    <td>@if(!empty($data->users)){{ $data->users->first_name.' '.$data->users->last_name }} @endif</td>
                                    <td>{{ $data->targets->name }}</td>
                                    <td>@if(!empty($data->visitCategories)) <span class="label label-default"> {{ $data->visitCategories->name }} </span>@endif</td>
                                    @role(['admin','marketingManager'])
                                    <td>
                                        @if(!$data->assigned_to)
                                        <div class="form-group">
                                            <select name="assigned_to" id="assigned_to" class="form-control" data-id="{{$data->id}}" data-token="{{csrf_token()}}">
                                                <option value="">-- Assign visit --</option>
                                                @forelse($users as $user)
                                                    <option value="{{$user->id}}">{{$user->first_name.' '.$user->last_name}}</option>
                                                @empty
                                                @endforelse
                                            </select>
                                        </div>
                                        @else
                                            <div class="form-group">
                                                <select name="assigned_to" id="assigned_to" class="form-control" data-id="{{$data->id}}" data-token="{{csrf_token()}}">
                                                    @forelse($users as $user)
                                                        @if(!empty($data->fieldVisitAssignedTo))
                                                            @if($data->fieldVisitAssignedTo->id == $user->id)
                                                                <?php $selected = 'selected'; ?>
                                                            @else
                                                                <?php $selected = ''; ?>
                                                            @endif
                                                        @else
                                                            <?php $selected = ''; ?>
                                                        @endif
                                                        <option value="{{$user->id}}" {{ $selected }}>{{$user->first_name.' '.$user->last_name}}</option>
                                                    @empty
                                                    @endforelse
                                                </select>
                                            </div>
                                        @endif
                                    </td>
                                    @endauth
                                    @role(['marketingOfficer','marketingManager','marketingBoy'])
                                    @if(!empty($data->fieldVisitAssignedBy))
                                    <td>
                                        <span class="label label-warning">
                                            {{ $data->fieldVisitAssignedBy->first_name.' '.$data->fieldVisitAssignedBy->last_name }}
                                        </span>
                                    </td>
                                    @else
                                        <td> --- </td>
                                    @endif
                                    @endauth
                                    <td>
                                        <a href="{{route('daily-field-visits.edit',['id' => $data->id])}}" title="Edit Field Visit"><i class="fa fa-pencil"></i></a> |
                                        <a href="#" class="confirm-visit-delete" data-token="{{csrf_token()}}" data-id ="{{$data->id}}" title="Delete Field Visit"><i class="fa fa-trash-o"></i></a>
                                    </td>
                                </tr>
                                @empty
                                @endforelse
                                </tbody>
                            </table>
                        </div><!--table-responsive-->
                    </div><!-- /.box-body -->
                </div><!--box-->
            </div>
        </div>
    </section>
    <script>
        $(function () {
            $('#visit-table').DataTable();
        })

        $(document).ready(function(){
            $('.confirm-visit-delete').on('click', function(){
                var visitId = $(this).data('id');
                var token = $(this).data('token');
                swal({
                    title: "Are you sure want to Delete?",
                    text: "Once deleted, you will not be able to recover this imaginary file!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                    .then((willDelete) => {
                        if (willDelete) {
                            $.ajax({
                                url: baseUrl + "daily-field-visits/" + visitId,
                                type: "post",
                                data: {id: visitId, _method: 'delete', _token:token},
                                success: function (data) {
                                    swal("Poof! Your Field Visit file has been deleted!", {
                                        icon: "success",
                                        buttons:false,
                                    });

                                    setTimeout(function () {
                                        location.reload();
                                    }, 1000);
                                },
                            });
                        } else {
                            swal("Your imaginary file is safe!");
                        }
                    });
            });
        });

        $('select[name="assigned_to"]').on('change', function(){
            var visit_id= $(this).data('id');
            var user_id = $( "#assigned_to option:selected" ).val();
            var token = $(this).data('token');
            console.log(visit_id);
            console.log(user_id);
            $.ajax({
                url:baseUrl + "assigned-user-field-visits/" + visit_id,
                type: 'POST',
                data:{
                    _token:token,
                    visit_id:visit_id,
                    user_id:user_id,
                    method:'POST'
                },
                success: function(data){
                    console.log(data);
                    swal("Your Field Visit file has been assigned successfully!", {
                        icon: "success",
                        buttons:false,
                    });

                    setTimeout(function () {
                        location.reload();
                    }, 1000);
                },
            });
        });
    </script>
@endsection
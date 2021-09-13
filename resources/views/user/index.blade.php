@extends('layouts.layouts')
@section('title', 'User | Role Management')
@section('content')
    <section class="content-header">
        <small class="md-txt">Welcome @if(Auth::user()->hasRole('admin') == '1')Administrator @else {{ Auth::user()->first_name.' '.Auth::user()->last_name }} @endif, <a href="https://www.google.com/maps/place/3720+Emerald+St,+Torrance,+CA+90503/@33.8403836,-118.3543828,17z/data=!4m18!1m15!4m14!1m6!1m2!1s0x80c2b4d407f58b11:0xdedca55964c89054!2s3720+Emerald+St,+Torrance,+CA+90503!2m2!1d-118.3520761!2d33.8403792!1m6!1m2!1s0x80c2b4d407f58b11:0xdedca55964c89054!2s3720+Emerald+St,+Torrance,+CA+90503!2m2!1d-118.3520761!2d33.8403792!3m1!1s0x80c2b4d407f58b11:0xdedca55964c89054" target="_blank"><i class="fa fa-map-marker rad-txt-danger"></i> Nepal</a></small>
        <ol class="breadcrumb">
            <li><a href="{{route('home')}}"><i class="fa fa-dashboard"></i>Home</a></li>
            <li class="active">Users</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12 col-md-12">
                <div class="box box-success">
                    <div class="box-header with-border">
                        <h3 class="box-title">{{ trans('User Lists') }}</h3>
                        <div class="box-tools pull-right">
                            {{--@include('user.partials.user-header-buttons')--}}
                            <a href="{{route('user.create')}}" class="label label-primary">Create New User</a>

                        </div><!--box-tools pull-right-->
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        @include('message.flash-message')
                        <div class="table-responsive">
                            <table id="users-table" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>SN</th>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $sn = 1; ?>
                                @forelse($users as $user)
                                <tr>
                                    <td>{{ $sn++ }}</td>
                                    <td>{{ $user->first_name.' '.$user->last_name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td><span class="label label-default">@foreach($user->roles as $role){{ $role->display_name }} @endforeach</span></td>
                                    <td>
                                        <a href="{{route('user.edit',['id' => $user->id])}}" title="Edit User"><i class="fa fa-pencil"></i></a> |
                                        <a href="#" class="confirm-delete-user" data-token="{{ csrf_token() }}" data-id="{{ $user->id }}" title="Delete"><i class="fa fa-trash-o"></i></a>
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
            $('#users-table').DataTable();
        })

        $(document).ready(function(){
            $('.confirm-delete-user').on('click', function(){
                var userId = $(this).data('id');
                var token = $(this).data('token');
                swal({
                    title: "Are you sure want to Delete?",
                    text: "Once deleted, you will not be able to recover this user!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                    .then((willDelete) => {
                        if (willDelete) {
                            $.ajax({
                                url: baseUrl + "user/" + userId,
                                type: "post",
                                data: {id: userId, _method: 'delete', _token:token},
                                success: function (data) {
                                    swal("Poof! User Profile has been deleted!", {
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
    </script>
@endsection
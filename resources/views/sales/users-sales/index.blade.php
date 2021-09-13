@extends('layouts.layouts')
@section('title', 'Sales | Lists')
@section('content')
    <section class="content-header">
        <small class="md-txt">Welcome @if(Auth::user()->hasRole('admin') == '1')Administrator @else {{ Auth::user()->first_name.' '.Auth::user()->last_name }} @endif, <a href="https://www.google.com/maps/place/3720+Emerald+St,+Torrance,+CA+90503/@33.8403836,-118.3543828,17z/data=!4m18!1m15!4m14!1m6!1m2!1s0x80c2b4d407f58b11:0xdedca55964c89054!2s3720+Emerald+St,+Torrance,+CA+90503!2m2!1d-118.3520761!2d33.8403792!1m6!1m2!1s0x80c2b4d407f58b11:0xdedca55964c89054!2s3720+Emerald+St,+Torrance,+CA+90503!2m2!1d-118.3520761!2d33.8403792!3m1!1s0x80c2b4d407f58b11:0xdedca55964c89054" target="_blank"><i class="fa fa-map-marker rad-txt-danger"></i> Nepal</a></small>
        <ol class="breadcrumb">
            <li><a href="{{route('home')}}"><i class="fa fa-dashboard"></i>Home</a></li>
            <li class="active">Sales Lists</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        @include('message.flash-message')
        <div class="row">
            <div class="col-xs-12 col-md-12">
                <div class="box box-success">
                    <div class="box-header with-border">
                        <h3 class="box-title">{{ trans('Sales Lists') }}</h3>
                        <div class="box-tools pull-right">
                            @role('marketingOfficer')
                            <a href="{{route('sales.create')}}" class="label label-primary">Create New Sales</a>
                            @endrole
                        </div><!--box-tools pull-right-->
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <div class="table-responsive">
                            <table id="sales-table" class="table table-bordered table-striped">
                                <thead>
                                    <th>SN</th>
                                    <th>Date</th>
                                    <th>Office Name</th>
                                    <th>Purpose</th>
                                    <th>Sales Amount</th>
                                    @role(['marketingManager', 'admin'])
                                    <th>Action</th>
                                    @endauth
                                </thead>
                                <tbody>
                                <?php $sn=1; ?>
                                @forelse($userSales as $sale)
                                    <tr>
                                        <td>{{ $sn++ }}</td>
                                        <td>{{ \Carbon\Carbon::parse($sale->date)->format('F j, Y') }}</td>
                                        <td>{{ $sale->companies->name }}</td>
                                        <td>{{ $sale->salesCategories->name }}</td>
                                        <td>{{ $sale->received_amount }}</td>
                                        @role(['marketingManager', 'admin'])
                                        <td>
                                            <a href="{{route('sales.edit',$sale->id)}}" title="Edit Sale"><i class="fa fa-pencil"></i></a>
                                            |
                                            <a href="#" class="delete-user-sales" data-id="{{ $sale->id }}" data-token="{{ csrf_token() }}" title="Delete Sale"><i class="fa fa-trash-o"></i></a>
                                        </td>
                                        @endauth
                                    </tr>
                                @empty
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script>
        $(function () {
            $('#sales-table').DataTable();
        })

        $(document).ready(function(){
            $('.delete-user-sales').on('click', function(e){
                e.preventDefault();
                var saleId = $(this).data('id');
                var token = $(this).data('token');
                swal({
                    title: "Are you sure want to Delete?",
                    text: "Once deleted, you will not be able to recover this sale!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                    .then((willDelete) => {
                        if (willDelete) {
                            $.ajax({
                                url: baseUrl + "sales/" + saleId,
                                type: "post",
                                data: {id: saleId, _method: 'delete', _token:token},
                                success: function (data) {
                                    swal("Poof! User Sales has been deleted!", {
                                        icon: "success",
                                        buttons:false,
                                    });

                                    setTimeout(function () {
                                        location.reload();
                                    }, 1000);
                                },
                            });
                        } else {
                            swal("Your Sale file is safe!");
                        }
                    });
            });
        });
    </script>
    @endsection
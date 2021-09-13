@extends('layouts.layouts')
@section('title', 'Ultrabyte | Tickets')

@section('content')
<section class="content-header">
	<small class="md-txt">Welcome @if(Auth::user()->hasRole('admin') == '1')Administrator @else {{ Auth::user()->first_name.' '.Auth::user()->last_name }} @endif, <a href="https://www.google.com/maps/place/3720+Emerald+St,+Torrance,+CA+90503/@33.8403836,-118.3543828,17z/data=!4m18!1m15!4m14!1m6!1m2!1s0x80c2b4d407f58b11:0xdedca55964c89054!2s3720+Emerald+St,+Torrance,+CA+90503!2m2!1d-118.3520761!2d33.8403792!1m6!1m2!1s0x80c2b4d407f58b11:0xdedca55964c89054!2s3720+Emerald+St,+Torrance,+CA+90503!2m2!1d-118.3520761!2d33.8403792!3m1!1s0x80c2b4d407f58b11:0xdedca55964c89054" target="_blank"><i class="fa fa-map-marker rad-txt-danger"></i> Nepal</a></small>
	<ol class="breadcrumb">
		<li><a href="{{route('home')}}"><i class="fa fa-dashboard"></i>Home</a></li>
		<li class="{{route('users-sales.index')}}">Account Information</li>
	</ol>
</section>

<section class="content">
	<div class="row">
		<div class="col-md-12">
			<div class="box box-primary">
				<div class="box-header with-border">

					<h3 class="box-title">Tickets</h3>
					<div class="dropdown pull-right">
						<a href="{{ url('/admin/ticket-dashboard') }}">Ticket Dashboard</a>
					</div>

				</div>
				<div class="box-body">

				</div>

			</div>
			<!-- /.box-body -->
		</div>
		<!-- /.box -->
	</div>
	<!-- /.col (right) -->
</section>

@endsection


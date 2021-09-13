@extends('layouts.layouts')
@section('title', 'Ultrabyte | Add Sales')

@section('content')
	<section class="content-header">
		<small class="md-txt">Welcome @if(Auth::user()->hasRole('admin') == '1')Administrator @else {{ Auth::user()->first_name.' '.Auth::user()->last_name }} @endif, <a href="https://www.google.com/maps/place/3720+Emerald+St,+Torrance,+CA+90503/@33.8403836,-118.3543828,17z/data=!4m18!1m15!4m14!1m6!1m2!1s0x80c2b4d407f58b11:0xdedca55964c89054!2s3720+Emerald+St,+Torrance,+CA+90503!2m2!1d-118.3520761!2d33.8403792!1m6!1m2!1s0x80c2b4d407f58b11:0xdedca55964c89054!2s3720+Emerald+St,+Torrance,+CA+90503!2m2!1d-118.3520761!2d33.8403792!3m1!1s0x80c2b4d407f58b11:0xdedca55964c89054" target="_blank"><i class="fa fa-map-marker rad-txt-danger"></i> Nepal</a></small>
		<ol class="breadcrumb">
			<li><a href="{{route('home')}}"><i class="fa fa-dashboard"></i>Home</a></li>
			<li class="{{route('users-sales.index')}}">Change Password</li>
		</ol>
	</section>

	<section class="content">

		@if(session('successMessage'))
			<div class="alert alert-success success-notification">
		        <a href="#" class="close" data-dismiss="alert">&times;</a>
		        {{ session('successMessage') }}
		    </div>
	    @endif

		@if(session('unsuccessMessage'))
			<div class="alert alert-danger unsuccess-notification">
		        <a href="#" class="close" data-dismiss="alert">&times;</a>
		        {{ session('unsuccessMessage') }}
		    </div>
		@endif

		<div class="row">
			<div class="col-md-12">
				<div class="box box-primary">
					<div class="box-header with-border">
						
						<h3 class="box-title">Change Password</h3>

					</div>
					<div class="box-body">
							
							<form method="post" action="{{ url('/client/change-password') }}">
								{{ csrf_field() }}
								<div class="row">
									<div class="col-md-4">
										<div class="form-group">
											<label for="oldPassword">Old Password:</label>
											<input type="password" class="form-control" name="oldPassword" id="inputAddress" value="{{ old('oldPassword') }}" placeholder="Enter Old Password">
										</div>

										@if ($errors->has('oldPassword'))
			                                <span class="help-block" style="color: #f86c6b;">
			                                    {{ $errors->first('oldPassword') }}
			                                </span>
			                            @endif
									</div>

									<div class="col-md-4">
										<div class="form-group">
											<label for="newPassword">New Password:</label>
											<input type="password" class="form-control" name="newPassword" id="inputAddress" placeholder="Enter New Password">
										</div>

										@if ($errors->has('newPassword'))
			                                <span class="help-block" style="color: #f86c6b;">
			                                    {{ $errors->first('newPassword') }}
			                                </span>
			                            @endif
									</div>

									<div class="col-md-4">
										<div class="form-group">
											<label for="Confirm Password">Confirm Password:</label>
											<input type="password" class="form-control" name="newPassword_confirmation" id="inputAddress" placeholder="Enter Confirm Password">
										</div>
										@if ($errors->has('newPassword_confirmation'))
			                                <span class="help-block" style="color: #f86c6b;">
			                                    {{ $errors->first('newPassword_confirmation') }}
			                                </span>
			                            @endif
									</div>
								</div>
								
								<div class="pull-right">
									<button type="submit" class="btn btn-success">Change Password</button>
								</div>
							</form>
							

							
					</div>

				</div>
				<!-- /.box-body -->
			</div> 
			<!-- /.box -->
		</div>
		<!-- /.col (right) -->
	</section>

@endsection


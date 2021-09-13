@extends('layouts.layouts')
@section('title', 'Ultrabyte | Edit Payment Method')

@section('content')
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
						<h3 class="box-title">Add Payment Method</h3>
					</div>

					<div class="box-body">
						<form method="post" action="{{ url('/admin/payment-method/'.$editPaymentMethod->id) }}">
							{{ csrf_field() }}
							{{ method_field('PUT') }}

							<div class="row">
								<div class="col-md-4">
									<div class="form-group" id="form-group-name">
					          <label for="name">Name:</label>
					          <input type="text" name="name" id="name" placeholder="Enter Name" class="form-control" value="{{ $editPaymentMethod->name }}">

					          @if ($errors->has('name'))
                      <span class="help-block" style="color: #f86c6b;">
                          {{ $errors->first('name') }}
                      </span>
                    @endif

					        </div>
						    </div>

						    <div class="col-md-8">
					        <div class="form-group">
					          <label for="Description">Description:</label>
					          <input type="text" name="description" id="description" placeholder="Enter Description" class="form-control" value="{{ $editPaymentMethod->description }}">

					          @if ($errors->has('description'))
                      <span class="help-block" style="color: #f86c6b;">
                          {{ $errors->first('description') }}
                      </span>
                    @endif

					        </div>
						    </div>
					    </div>

					    <div class="row">
								<div class="col-md-12">
									<input class="btn btn-primary pull-right" type="submit" value="Edit Payment Method"> 
								</div>
							</div>

						</form>

					</div>
					<!-- /.box-body -->
				</div>
				<!-- /.box -->
			</div>
		</div>
		<!-- /.col (right) -->
	</section>
@endsection

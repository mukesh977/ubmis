@extends('layouts.layouts')
@section('title', 'Ultrabyte | Edit AMC Attribute')

@section('content')
	<section class="content">
		<div class="row">
			<div class="col-md-6">

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

				<div class="box box-primary">
					<div class="box-header with-border" style="display: flex;">
						<h3 class="box-title">Edit AMC Attribute</h3>
						
						<div class="box-tools pull-right">
				            <a href="{{ url('/admin/amc-package') }}" class="btn btn-primary btn-xs">List AMC Attribute</a>
				            <a href="{{ url('/admin/amc-package/create') }}" class="btn btn-primary btn-xs">Add AMC Attribute</a>
				        </div>
						
					</div>
					<div class="box-body">
						<form method="post" action="{{ url('/admin/amc-package/'.$editAmcPackage->id) }}">
							{{ csrf_field() }}
							@method('PUT')

							<div class="row">
								<div class="col-md-12">
									<div class="form-group" id="form-group-name">
							          <label for="AMC Attribute Name">AMC Attribute Name:</label>
							          <input type="text" name="amcAttributeName" id="amcAttributeName" placeholder="Enter AMC Attribute Name" class="form-control" value="{{ $editAmcPackage->name }}">

							          @if ($errors->has('amcAttributeName'))
		                                <span class="help-block" style="color: #f86c6b;">
		                                    {{ $errors->first('amcAttributeName') }}
		                                </span>
		                              @endif

							        </div>
							    </div>
						    </div>

						    <div class="row">
								<div class="col-md-12">
									<input class="btn btn-primary pull-right" type="submit" value="Update AMC Attribute"> 
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


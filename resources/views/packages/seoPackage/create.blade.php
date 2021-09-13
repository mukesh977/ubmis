@extends('layouts.layouts')
@section('title', 'Ultrabyte | Add Seo Package')

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
						<h3 class="box-title">Add Seo Package</h3>
						
						<div class="box-tools pull-right">
				            <a href="{{ url('/admin/seo-package') }}" class="btn btn-primary btn-xs">List Seo Packages</a>
				        </div>
						
					</div>
					<div class="box-body">
						<form method="post" action="{{ url('/admin/seo-package') }}">
							{{ csrf_field() }}

							<div class="row">
								<div class="col-md-7">
									<div class="form-group" id="form-group-name">
							          <label for="Visit Category Name">Seo Package Name:</label>
							          <input type="text" name="seoPackageName" id="seoPackageName" placeholder="Enter Seo Package Name" class="form-control" value="{{ old('seoPackageName') }}">

							          @if ($errors->has('seoPackageName'))
		                                <span class="help-block" style="color: #f86c6b;">
		                                    {{ $errors->first('seoPackageName') }}
		                                </span>
		                              @endif

							        </div>
							    </div>

							    <div class="col-md-5">
							        <div class="form-group">
							          <label for="Description">Price:</label>
							          <input type="text" name="price" id="price" placeholder="Enter Price" class="form-control" value="{{ old('price') }}">

							          @if ($errors->has('price'))
		                                <span class="help-block" style="color: #f86c6b;">
		                                    {{ $errors->first('price') }}
		                                </span>
		                              @endif

							        </div>
							    </div>
						    </div>

						    <div class="row">
								<div class="col-md-12">
									<input class="btn btn-primary pull-right" type="submit" value="Add Seo Package"> 
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


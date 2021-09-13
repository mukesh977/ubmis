@extends('layouts.layouts')
@section('title', 'Ultrabyte | Add Visit Category')

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

						@if( empty($editCompany->id) )
							<h3 class="box-title">Add Visit Category</h3>
						@else
							<h3 class="box-title">Edit Visit Category</h3>
						@endif

					</div>
					<div class="box-body">
						<form method="post" action="{{ url('/admin/store-visit-category') }}">
							{{ csrf_field() }}

							<input type="hidden" name="visitCategoryId" value="{{ !empty($editCategory)? $editCategory->id : '' }}">

							<div class="row">
								<div class="col-md-4">
									<div class="form-group" id="form-group-name">
							          <label for="Visit Category Name">Visit Category Name:</label>
							          <input type="text" name="visitCategoryName" id="visitCategoryName" placeholder="Enter Visit Category Name" class="form-control" value="{{ !empty($editCategory->id)? $editCategory->name : old('visitCategoryName') }}">

							          @if ($errors->has('visitCategoryName'))
		                                <span class="help-block" style="color: #f86c6b;">
		                                    {{ $errors->first('visitCategoryName') }}
		                                </span>
		                              @endif

							        </div>
							    </div>

							    <div class="col-md-8">
							        <div class="form-group">
							          <label for="Description">Description:</label>
							          <input type="text" name="description" id="description" placeholder="Enter Description" class="form-control" value="{{ !empty($editCategory->id)? $editCategory->description :old('description') }}">

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
									@if(empty($editCategory->id))
										<input class="btn btn-primary pull-right" type="submit" value="Add Visit Category"> 
									@else
										<input class="btn btn-primary pull-right" type="submit" value="Edit Visit Category">
									@endif
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


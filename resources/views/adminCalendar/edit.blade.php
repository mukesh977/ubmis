@extends('layouts.layouts')
@section('title', 'Ultrabyte | Edit Client Follow Up')

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
					<div class="box-header with-border" style="display: flex;">
						<h3 class="box-title">Edit Client Follow Up</h3>

						<div class="box-tools pull-right">
							<a href="{{ url('/admin/client-follow-up') }}" class="btn btn-primary btn-sm">List Client Follow Up</a>

							<a href="{{ url('/admin/client-follow-up/create') }}" class="btn btn-primary btn-sm">Add Client Follow Up</a>

						</div>

					</div>
					<div class="box-body">
						<form method="post" action="{{ url('/admin/client-follow-up/'. $editFollowUp->id) }}">
							{{ csrf_field() }}
							{{ method_field('patch') }}

							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
							          <label for="Office Name">Office Name:</label>
							          
							          <select class="form-control select2" name="officeName">
						          		<option value="">Select Office Name</option>

							          	@foreach( $companies as $company )
							          		<option value="{{ $company->id }}" {{ ($editFollowUp->company_id==($company->id))? 'selected' : '' }}>
							          			{{ $company->name }}
							          		</option>
							          	@endforeach
							      	</select>

							          @if ($errors->has('officeName'))
		                                <span class="help-block" style="color: #f86c6b;">
		                                    {{ $errors->first('officeName') }}
		                                </span>
		                              @endif

							        </div>
							    </div>

							    <div class="col-md-6">
							        <div class="form-group" id="form-group-address">
							          <label for="date">Follow Up Date:</label>
							          <input type="text" name="date" id="date" placeholder="Enter Follow Up Date" class="form-control" value="{{ !empty($editFollowUp->follow_up_date)? $editFollowUp->follow_up_date : '' }}">

							          @if ($errors->has('date'))
		                                <span class="help-block" style="color: #f86c6b;">
		                                    {{ $errors->first('date') }}
		                                </span>
		                              @endif

							        </div>
							    </div>
						    </div>

							<div class="row">
								<div class="col-md-12">
									<input class="btn btn-primary pull-right" type="submit" value="Update"> 
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

@section('script')
	<script>
		$('.select2').select2();

		$(document).on('focus',"#date", function(){
		    $(this).datepicker({
			dateFormat: "yy/mm/dd",
			changeMonth: true,
			changeYear: true,
			});
		});
	</script>
@endsection
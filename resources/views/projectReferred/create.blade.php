@extends('layouts.layouts')
@section('title', 'Ultrabyte | Add Project Referred Relationship')

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
						<h3 class="box-title">Add Project Referred Relationship</h3>

						<div class="box-tools pull-right">
				            <a href="{{ url('/admin/referred') }}" class="btn btn-primary btn-xs">List Project Referred Relationship</a>
				        </div>

					</div>

					<div class="box-body">
						<form method="post" action="{{ url('/admin/referred') }}">
							{{ csrf_field() }}

							<div class="row">
								<div class="col-md-5">
									<div class="form-group" id="form-group-name">
							          	<label for="salesCode">Sales Code:</label>
							          
							          	<select class="form-control select2" name="salesCode">
							          		<option value="">Select Sales Code</option>
								          	@foreach( $salesTransactions as $salesTransaction )
								          		<option value="{{ $salesTransaction->id }}" {{ (old('salesCode')==($salesTransaction->id))? 'selected' : '' }}>
								          			{{ $salesTransaction->sales_code }}
								          		</option>
								          	@endforeach
								      	</select>

							          @if ($errors->has('salesCode'))
		                                <span class="help-block" style="color: #f86c6b;">
		                                    {{ $errors->first('salesCode') }}
		                                </span>
		                              @endif

							        </div>
							    </div>

							    <div class="col-md-5">
							        <div class="form-group" id="form-group-address">
							          <label for="personName">Person Name:</label>
							          
							          <select class="form-control select2" name="personName">
							          		<option value="">Select Person Name</option>
								          	@foreach( $personNames as $personName )
								          		<option value="{{ $personName->id }}" {{ (old('personName')==($personName->id))? 'selected' : '' }}>
								          			{{ $personName->first_name .' '. $personName->last_name }}
								          		</option>
								          	@endforeach
								      	</select>

							          @if ($errors->has('personName'))
		                                <span class="help-block" style="color: #f86c6b;">
		                                    {{ $errors->first('personName') }}
		                                </span>
		                              @endif

							        </div>
							    </div>

							    <div class="col-md-2" style="margin-top: 22px;">
							    	<button class="btn btn-primary form-control">Add Person Name</button>
							    </div>
						    </div>

						    <div class="row">
						    	<div class="col-md-6">
								    <div class="form-group" id="form-group-email">  
							          <label for="Email">Parent Name:</label>

							          <div id="parentTable">
							            <table class="table table-responsive-sm table-bordered" style="margin-bottom: 0px;">
							              <tbody>
							                  <tr>
							                    <td width="95%">
							                      	<select class="form-control select2" name="parentName[]">
										          		<option value="">Select Parent Name</option>
											          	@foreach( $personNames as $personName )
											          		<option value="{{ $personName->id }}" {{ (old('parentName.0')==$personName->id)? 'selected' : '' }}>
											          			{{ $personName->first_name .' '. $personName->last_name }}
											          		</option>
											          	@endforeach
											      	</select>
							                    </td>
							                    <td width="5%">
							                      <a href="" class="link parent_name_add">
							                        <i class="fa fa-plus" style="margin-top: 10px;"></i>
							                      </a>
							                    </td>
							                  </tr>

							                  <?php $count1 = (!empty(old('parentName'))? count(old('parentName')) : 0 ); ?>

						                    @for( $i = 1; $i < $count1; $i++ )
							                    <tr>
								                    <td width="95%">
								                      	<select class="form-control select2" name="parentName[]">
											          		<option value="">Select Parent Name</option>
												          	@foreach( $personNames as $personName )
												          		<option value="{{ $personName->id }}" {{ (old('parentName.'.$i)==$personName->id)? 'selected' : '' }}>
												          			{{ $personName->first_name .' '. $personName->last_name }}
												          		</option>
												          	@endforeach
												      	</select>
								                    </td>
								                    <td width="5%">
								                      <a href="#" class="link deleteParentRow" title="Delete" onclick="deleteid()">
								                      	<i class="fa fa-trash-o" style="margin-top: 10px;">
								                      		
								                      	</i>
								                      </a>
								                    </td>
								                  </tr>
							                 @endfor

							              </tbody>
							            </table>
							          </div>

							          @if ($errors->has('parentName.*'))
		                                <span class="help-block" style="color: #f86c6b;">
		                                    {{ $errors->first('parentName.*') }}
		                                </span>
		                              @endif

							        </div>
							    </div>

							    <div class="col-md-6">
							    	<div class="form-group" id="form-group-contactno">  
							    		<label for="Contact No">Child Name:</label>

							    		<div id="childNameTable">
							    			<table class="table table-responsive-sm table-bordered" style="margin-bottom: 0px;">
							    				<tbody>
							    					<tr>
							    						<td width="95%">
							    							<select class="form-control select2" name="childName[]">
												          		<option value="">Select Child Name</option>
													          	@foreach( $personNames as $personName )
													          		<option value="{{ $personName->id }}" {{ (old('childName.0')==$personName->id)? 'selected' : '' }}>
													          			{{ $personName->first_name .' '. $personName->last_name }}
													          		</option>
													          	@endforeach
													      	</select>
							    						</td>
							    						<td width="5%">
							    							<a href="" class="link child_name_add">
							    								<i class="fa fa-plus" style="margin-top: 10px;"></i>
							    							</a>
							    						</td>
							    					</tr>

							    					<?php $count2 = (!empty(old('childName'))? count(old('childName')) : 0 ); ?>

								                    @for( $i = 1; $i < $count2; $i++ )
									                    <tr>
										                    <td width="95%">
										                      	<select class="form-control select2" name="childName[]">
													          		<option value="">Select Child Name</option>
														          	@foreach( $personNames as $personName )
														          		<option value="{{ $personName->id }}" {{ (old('childName.'.$i)==$personName->id)? 'selected' : '' }}>
														          			{{ $personName->first_name .' '. $personName->last_name }}
														          		</option>
														          	@endforeach
														      	</select>
										                    </td>
										                    <td width="5%">
										                      <a href="#" class="link deleteChildRow" title="Delete">
										                      	<i class="fa fa-trash-o" style="margin-top: 10px;">
										                      		
										                      	</i>
										                      </a>
										                    </td>
										                  </tr>
									                 @endfor

							    				</tbody>
							    			</table>
							    		</div>

							    		@if ($errors->has('childName.*'))
			                                <span class="help-block" style="color: #f86c6b;">
			                                    {{ $errors->first('childName.*') }}
			                                </span>
			                              @endif

							    	</div>
							    </div>
							</div>

							<div class="row">
								<div class="col-md-12">
									<input class="btn btn-primary pull-right" type="submit" value="Add"> 
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

		$('.parent_name_add').on('click', function(e){
			e.preventDefault();

			$('#parentTable').find('.table > tbody').append('<tr><td width="95%"><select class="form-control select2" name="parentName[]"><option value="">Select Parent Name</option>@foreach( $personNames as $personName )<option value="{{ $personName->id }}">{{ $personName->first_name .' '. $personName->last_name }}</option>@endforeach</select></td><td width="5%"><a href="#" class="link deleteParentRow" title="Delete" onclick="deleteid()"><i class="fa fa-trash-o" style="margin-top: 10px;"></i></a></td></tr>');
		});

		$('.child_name_add').on('click', function(e){
		    e.preventDefault();

		    $('#childNameTable').find('.table > tbody').append('<tr><td width="95%"><select class="form-control select2" name="childName[]"><option value="">Select Child Name</option>@foreach( $personNames as $personName )<option value="{{ $personName->id }}">{{ $personName->first_name .' '. $personName->last_name }}</option>@endforeach</select></td><td width="5%"><a href="#" class="link deleteChildRow" title="Delete"><i class="fa fa-trash-o" style="margin-top: 10px;"></i></a></td></tr>');
		  });

		$('#parentTable').find('.table > tbody').on('click', '.deleteParentRow', function(e){
		    e.preventDefault();
		    $(this).parent().closest('tr').remove();

		  });

		  $('#childNameTable').find('.table > tbody').on('click', '.deleteChildRow', function(e){
		    e.preventDefault();
		    $(this).parent().closest('tr').remove();

		  });
	</script>
@endsection
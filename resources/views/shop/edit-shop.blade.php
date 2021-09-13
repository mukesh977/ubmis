@extends('layouts.layouts')
@section('title', 'Ultrabyte | Edit Shop')

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
						<h3 class="box-title">Edit Shop</h3>
					</div>
					<div class="box-body">
						<form method="post" action="{{ url('/admin/store-edit-shop') }}">
							{{ csrf_field() }}

							<input type="hidden" name="shopId" value="{{ !empty($editShop)? $editShop->id : '' }}">

							<div class="row">
								<div class="col-md-6">
									<div class="form-group" id="form-group-name">
							          <label for="Shop Name">Shop Name:</label>
							          <input type="text" name="name" id="name" placeholder="Enter Shop Name" class="form-control" value="{{ !empty($editShop->id)? $editShop->name : old('name') }}">

							          @if ($errors->has('name'))
		                                <span class="help-block" style="color: #f86c6b;">
		                                    {{ $errors->first('name') }}
		                                </span>
		                              @endif

							        </div>
							    </div>

							    <div class="col-md-6">
							        <div class="form-group" id="form-group-address">
							          <label for="Address">Address:</label>
							          <input type="text" name="address" id="address" placeholder="Enter Address" class="form-control" value="{{ !empty($editShop->id)? $editShop->address :old('address') }}">

							          @if ($errors->has('address'))
		                                <span class="help-block" style="color: #f86c6b;">
		                                    {{ $errors->first('address') }}
		                                </span>
		                              @endif

							        </div>
							    </div>
						    </div>

						    <div class="row">
							    <div class="col-md-6">
							    	<div class="form-group" id="form-group-contactno">  
							    		<label for="Contact No">Contact Number:</label>

							    		<div id="contactTable">
							    			<table class="table table-responsive-sm table-bordered" style="margin-bottom: 0px;">
							    				<tbody>
							    					<tr>
							    						<td width="95%">
							    							<input type="text" name="contactNumber[]" id="contactNumber" placeholder="Enter Contact Number" class="form-control" value="<?php try{ echo (!empty($editShop->id)? (!empty($editShop->contactNumbers[0]->contact_number))? $editShop->contactNumbers[0]->contact_number : '' : old('contactNumber.0')); } catch(\Exception $e ){ echo ''; } ?>">
							    						</td>
							    						<td width="5%">
							    							<a href="" class="link phone_add">
							    								<i class="fa fa-plus" style="margin-top: 10px;"></i>
							    							</a>
							    						</td>
							    					</tr>

							    					<?php $count2 = !empty($editShop->id)? $editShop->contactNumbers->count() : (!empty(old('contactNumber'))? count(old('contactNumber')) : 0 ); ?>

							    					@for( $i = 1; $i < $count2; $i++ )
							    						<tr>
								    						<td width="95%">
								    							<input type="text" name="contactNumber[]" id="contactNumber" placeholder="Enter Contact Number" class="form-control" value="{{ !empty($editShop->id)? $editShop->contactNumbers[$i]->contact_number : old('contactNumber.'.$i) }}">
								    						</td>
								    						<td width="5%">
								    							<a href="#" class="link deleteContact" title="Delete" onclick="deleteid()">
								    								<i class="fa fa-trash-o" style="margin-top: 10px;"></i>
								    							</a>
								    						</td>
								    					</tr>
							    					@endfor
							    				</tbody>
							    			</table>
							    		</div>

							    		@if ($errors->has('contactNumber.*'))
			                                <span class="help-block" style="color: #f86c6b;">
			                                    {{ $errors->first('contactNumber.*') }}
			                                </span>
			                              @endif

							    	</div>
							    </div>
							</div>

							<div class="row">
								<div class="col-md-12">
									<input class="btn btn-primary pull-right" type="submit" value="Edit Shop">
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
		$('.phone_add').on('click', function(e){
			e.preventDefault();

			$('#contactTable').find('.table > tbody').append('<tr><td width="95%"><input type="text" name="contactNumber[]" placeholder="Enter Contact Number" class="form-control"></td><td width="5%"><a href="#" class="link deleteContact" title="Delete" onclick="deleteid()"><i class="fa fa-trash-o" style="margin-top: 10px;"></i></a></td></tr>');
		});

		
		$('#contactTable').find('.table > tbody').on('click', '.deleteContact', function(e){
		    e.preventDefault();
		    $(this).parent().closest('tr').remove();

		  });

	</script>
@endsection
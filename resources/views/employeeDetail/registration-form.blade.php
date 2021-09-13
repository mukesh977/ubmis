@extends('layouts.layouts')
@section('title', 'Ultrabyte | Add Sales')

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

						@if(empty($editEmployee->id))
							<h3 class="box-title">Add Employee Detail</h3>
						@else
							<h3 class="box-title">Edit Employee Detail</h3>
						@endif

					</div>

					<div class="box-body">
						<form class="form-horizontal" method="post" action="{{ url('/admin/employee-detail/store') }}">
							{{ csrf_field() }}

							<input type="hidden" name="employeeId" value="{{ !empty($editEmployee->id)? $editEmployee->id : old('employeeId') }}">

							<div class="row sales_table">
								<div class="col-md-6">
									<div class="row">
										<div class="form-group col-md-3 right_align">
											<label class="control-label">Name:</label>
										</div>

										<div class="col-md-9">
											<input type="text" class="form-control" name="name" value="{{ !empty($editEmployee->id)? $editEmployee->name : old('name') }}" placeholder="Enter Name">

											@if ($errors->has('name'))
				                                <span class="help-block" style="color: #f86c6b;">
				                                    {{ $errors->first('name') }}
				                                </span>
				                            @endif

										</div>
										<!-- /.input group -->
									</div>
								</div>

								<div class="col-md-6">
									<div class="row">
										<div class="form-group col-md-3 right_align">
											<label class="control-label">Date of Birth:</label>
										</div>

										<div class="col-md-9">
											<input type="text" class="form-control" name="dateOfBirth" value="{{ !empty($editEmployee->id)? $editEmployee->date_of_birth : old('dateOfBirth') }}" placeholder="Enter Date of Birth">

											@if ($errors->has('dateOfBirth'))
				                                <span class="help-block" style="color: #f86c6b;">
				                                    {{ $errors->first('dateOfBirth') }}
				                                </span>
				                            @endif

										</div>
										<!-- /.input group -->
									</div>
								</div>
								
							</div>


							<div class="row sales_table">
								<div class="col-md-6">
									<div class="row">
										<div class="form-group col-md-3 right_align">
											<label class="control-label">E-mail:</label>
										</div>

										<div class="col-md-9">
											<input type="text" class="form-control" name="email" value="{{ !empty($editEmployee->id)? $editEmployee->email : old('email') }}" placeholder="Enter E-mail">

											@if ($errors->has('email'))
				                                <span class="help-block" style="color: #f86c6b;">
				                                    {{ $errors->first('email') }}
				                                </span>
				                            @endif

										</div>
										<!-- /.input group -->
									</div>
								</div>
							</div>

							<div class="row sales_table">
								<div class="col-md-6">
									<div class="row">
										<div class="form-group col-md-3 right_align">
											<label class="control-label">Mobile Number:</label>
										</div>

										<div class="col-md-9">
											<input type="text" class="form-control" name="mobileNumber" value="{{ !empty($editEmployee->id)? $editEmployee->mobile_number : old('mobileNumber') }}" placeholder="Enter Mobile Number">

											@if ($errors->has('mobileNumber'))
				                                <span class="help-block" style="color: #f86c6b;">
				                                    {{ $errors->first('mobileNumber') }}
				                                </span>
				                            @endif

										</div>
										<!-- /.input group -->
									</div>
								</div>

								<div class="col-md-6">
									<div class="row">
										<div class="form-group col-md-3 right_align">
											<label class="control-label">Phone Number:</label>
										</div>

										<div class="col-md-9">
											<input type="text" class="form-control" name="phoneNumber" value="{{ !empty($editEmployee->id)? $editEmployee->phone_number : old('phoneNumber') }}" placeholder="Enter Phone Number">

											@if ($errors->has('phoneNumber'))
				                                <span class="help-block" style="color: #f86c6b;">
				                                    {{ $errors->first('phoneNumber') }}
				                                </span>
				                            @endif

										</div>
										<!-- /.input group -->
									</div>
								</div>
								
							</div>
							<!-- end of row div -->
							<hr>
							<h5><u><b>Temporary Address</b></u></h5>

							<div class="row sales_table">
								<div class="col-md-6">
									<div class="row">
										<div class="form-group col-md-3 right_align">
											<label class="control-label">Address:</label>
										</div>

										<div class="col-md-9">
											<input type="text" class="form-control" name="tAddress" value="{{ !empty($editEmployee->id)? $editEmployee->temporary_address : old('tAddress') }}" placeholder="Enter Temporary Address">

											@if ($errors->has('tAddress'))
				                                <span class="help-block" style="color: #f86c6b;">
				                                    {{ $errors->first('tAddress') }}
				                                </span>
				                            @endif

										</div>
										<!-- /.input group -->
									</div>
								</div>

							</div>
							<!-- end of row div -->

							<div class="row sales_table">
								<div class="col-md-6">
									<div class="row">
										<div class="form-group col-md-3 right_align">
											<label class="control-label">Tole:</label>
										</div>

										<div class="col-md-9">
											<input type="text" class="form-control" name="tTole" value="{{ !empty($editEmployee->id)? $editEmployee->temporary_tole : old('tTole') }}" placeholder="Enter Tole">

											@if ($errors->has('tTole'))
				                                <span class="help-block" style="color: #f86c6b;">
				                                    {{ $errors->first('tTole') }}
				                                </span>
				                            @endif

										</div>
										<!-- /.input group -->
									</div>
								</div>

								<div class="col-md-6">
									<div class="row">
										<div class="form-group col-md-3 right_align">
											<label class="control-label">Ward:</label>
										</div>

										<div class="col-md-9">
											<input type="text" class="form-control" name="tWard" value="{{ !empty($editEmployee->id)? $editEmployee->temporary_ward : old('tWard') }}" placeholder="Enter Ward">

											@if ($errors->has('tWard'))
				                                <span class="help-block" style="color: #f86c6b;">
				                                    {{ $errors->first('tWard') }}
				                                </span>
				                            @endif

										</div>
										<!-- /.input group -->
									</div>
								</div>
								
							</div>
							<!-- end of row div -->

							<hr>

							<h5><u><b>Permanent Address</b></u></h5>

							<div class="row sales_table">
								<div class="col-md-6">
									<div class="row">
										<div class="form-group col-md-3 right_align">
											<label class="control-label">Address:</label>
										</div>

										<div class="col-md-9">
											<input type="text" class="form-control" name="pAddress" value="{{ !empty($editEmployee->id)? $editEmployee->permanent_address : old('pAddress') }}" placeholder="Enter Permanent Address">

											@if ($errors->has('pAddress'))
				                                <span class="help-block" style="color: #f86c6b;">
				                                    {{ $errors->first('pAddress') }}
				                                </span>
				                            @endif

										</div>
										<!-- /.input group -->
									</div>
								</div>

							</div>
							<!-- end of row div -->

							<div class="row sales_table">
								<div class="col-md-6">
									<div class="row">
										<div class="form-group col-md-3 right_align">
											<label class="control-label">Tole:</label>
										</div>

										<div class="col-md-9">
											<input type="text" class="form-control" name="pTole" value="{{ !empty($editEmployee->id)? $editEmployee->permanent_tole : old('pTole') }}" placeholder="Enter Tole">

											@if ($errors->has('pTole'))
				                                <span class="help-block" style="color: #f86c6b;">
				                                    {{ $errors->first('pTole') }}
				                                </span>
				                            @endif

										</div>
										<!-- /.input group -->
									</div>
								</div>

								<div class="col-md-6">
									<div class="row">
										<div class="form-group col-md-3 right_align">
											<label class="control-label">Ward:</label>
										</div>

										<div class="col-md-9">
											<input type="text" class="form-control" name="pWard" value="{{ !empty($editEmployee->id)? $editEmployee->permanent_ward : old('pWard') }}" placeholder="Enter Ward">

											@if ($errors->has('pWard'))
				                                <span class="help-block" style="color: #f86c6b;">
				                                    {{ $errors->first('pWard') }}
				                                </span>
				                            @endif

										</div>
										<!-- /.input group -->
									</div>
								</div>
								
							</div>
							<!-- end of row div -->

							<hr>

							<h5><u><b>Social Links</b></u></h5>

							<div class="row sales_table">
								<div class="col-md-4">
									<div class="row">
										<div class="form-group col-md-3 right_align">
											<label class="control-label">Fb:</label>
										</div>

										<div class="col-md-9">
											<input type="text" class="form-control" name="fb" value="{{ !empty($editEmployee->id)? $editEmployee->fb_link : old('fb') }}" placeholder="Enter Facebook Links">

											@if ($errors->has('fb'))
				                                <span class="help-block" style="color: #f86c6b;">
				                                    {{ $errors->first('fb') }}
				                                </span>
				                            @endif

										</div>
										<!-- /.input group -->
									</div>
								</div>

								<div class="col-md-4">
									<div class="row">
										<div class="form-group col-md-3 right_align">
											<label class="control-label">Twitter:</label>
										</div>

										<div class="col-md-9">
											<input type="text" class="form-control" name="twitter" value="{{ !empty($editEmployee->id)? $editEmployee->twitter_link : old('twitter') }}" placeholder="Enter Twitter Links">

											@if ($errors->has('twitter'))
				                                <span class="help-block" style="color: #f86c6b;">
				                                    {{ $errors->first('twitter') }}
				                                </span>
				                            @endif

										</div>
										<!-- /.input group -->
									</div>
								</div>

								<div class="col-md-4">
									<div class="row">
										<div class="form-group col-md-4 right_align">
											<label class="control-label">If Personal Websites:</label>
										</div>

										<div class="col-md-8">
											<input type="text" class="form-control" name="personalWebsite" value="{{ !empty($editEmployee->id)? $editEmployee->personal_website_link : old('personalWebsite') }}" placeholder="Enter Your Personal Websites">

											@if ($errors->has('personalWebsite'))
				                                <span class="help-block" style="color: #f86c6b;">
				                                    {{ $errors->first('personalWebsite') }}
				                                </span>
				                            @endif

										</div>
										<!-- /.input group -->
									</div>
								</div>
								
							</div>
							<!-- end of row div -->

							<hr>

							<h5><u><b>Bank Details</b></u></h5>

							<div class="row sales_table">
								<div class="col-md-6">
									<div class="row">
										<div class="form-group col-md-3 right_align">
											<label class="control-label">1. Bank Name:</label>
										</div>

										<div class="col-md-9">
											<input type="text" class="form-control" name="bankName1" value="{{ !empty($editEmployee->id)? $editEmployee->bank_name_1 : old('bankName1') }}" placeholder="Enter Bank Name">

											@if ($errors->has('bankName1'))
				                                <span class="help-block" style="color: #f86c6b;">
				                                    {{ $errors->first('bankName1') }}
				                                </span>
				                            @endif

										</div>
										<!-- /.input group -->
									</div>
								</div>

								<div class="col-md-6">
									<div class="row">
										<div class="form-group col-md-3 right_align">
											<label class="control-label">Swift Code:</label>
										</div>

										<div class="col-md-9">
											<input type="text" class="form-control" name="swiftCode1" value="{{ !empty($editEmployee->id)? $editEmployee->swift_code_1 : old('swiftCode1') }}" placeholder="Enter Swift Code">

											@if ($errors->has('swiftCode1'))
				                                <span class="help-block" style="color: #f86c6b;">
				                                    {{ $errors->first('swiftCode1') }}
				                                </span>
				                            @endif

										</div>
										<!-- /.input group -->
									</div>
								</div>
								
							</div>
							<!-- end of row div -->

							<div class="row sales_table">
								<div class="col-md-6">
									<div class="row">
										<div class="form-group col-md-3 right_align">
											<label class="control-label">Bank Number:</label>
										</div>

										<div class="col-md-9">
											<input type="text" class="form-control" name="bankNumber1" value="{{ !empty($editEmployee->id)? $editEmployee->bank_number_1 : old('bankNumber1') }}" placeholder="Enter Bank Number">

											@if ($errors->has('bankNumber1'))
				                                <span class="help-block" style="color: #f86c6b;">
				                                    {{ $errors->first('bankNumber1') }}
				                                </span>
				                            @endif

										</div>
										<!-- /.input group -->
									</div>
								</div>

								<div class="col-md-6">
									<div class="row">
										<div class="form-group col-md-3 right_align">
											<label class="control-label">Branch:</label>
										</div>

										<div class="col-md-9">
											<input type="text" class="form-control" name="branch1" value="{{ !empty($editEmployee->id)? $editEmployee->branch_1 : old('branch1') }}" placeholder="Enter Branch">

											@if ($errors->has('branch1'))
				                                <span class="help-block" style="color: #f86c6b;">
				                                    {{ $errors->first('branch1') }}
				                                </span>
				                            @endif

										</div>
										<!-- /.input group -->
									</div>
								</div>
								
							</div>
							<!-- end of row div -->

							<br>

							<div class="row sales_table">
								<div class="col-md-6">
									<div class="row">
										<div class="form-group col-md-3 right_align">
											<label class="control-label">2. Bank Name:</label>
										</div>

										<div class="col-md-9">
											<input type="text" class="form-control" name="bankName2" value="{{ !empty($editEmployee->id)? $editEmployee->bank_name_2 : old('bankName2') }}" placeholder="Enter Bank Name">

											@if ($errors->has('bankName2'))
				                                <span class="help-block" style="color: #f86c6b;">
				                                    {{ $errors->first('bankName2') }}
				                                </span>
				                            @endif

										</div>
										<!-- /.input group -->
									</div>
								</div>

								<div class="col-md-6">
									<div class="row">
										<div class="form-group col-md-3 right_align">
											<label class="control-label">Swift Code:</label>
										</div>

										<div class="col-md-9">
											<input type="text" class="form-control" name="swiftCode2" value="{{ !empty($editEmployee->id)? $editEmployee->swift_code_2 : old('swiftCode2') }}" placeholder="Enter Swift Code">

											@if ($errors->has('swiftCode2'))
				                                <span class="help-block" style="color: #f86c6b;">
				                                    {{ $errors->first('swiftCode2') }}
				                                </span>
				                            @endif

										</div>
										<!-- /.input group -->
									</div>
								</div>
								
							</div>
							<!-- end of row div -->

							<div class="row sales_table">
								<div class="col-md-6">
									<div class="row">
										<div class="form-group col-md-3 right_align">
											<label class="control-label">Bank Number:</label>
										</div>

										<div class="col-md-9">
											<input type="text" class="form-control" name="bankNumber2" value="{{ !empty($editEmployee->id)? $editEmployee->bank_number_2 : old('bankNumber2') }}" placeholder="Enter Bank Number">

											@if ($errors->has('bankNumber2'))
				                                <span class="help-block" style="color: #f86c6b;">
				                                    {{ $errors->first('bankNumber2') }}
				                                </span>
				                            @endif

										</div>
										<!-- /.input group -->
									</div>
								</div>

								<div class="col-md-6">
									<div class="row">
										<div class="form-group col-md-3 right_align">
											<label class="control-label">Branch:</label>
										</div>

										<div class="col-md-9">
											<input type="text" class="form-control" name="branch2" value="{{ !empty($editEmployee->id)? $editEmployee->branch_2 : old('branch2') }}" placeholder="Enter Branch">

											@if ($errors->has('branch2'))
				                                <span class="help-block" style="color: #f86c6b;">
				                                    {{ $errors->first('branch2') }}
				                                </span>
				                            @endif

										</div>
										<!-- /.input group -->
									</div>
								</div>
								
							</div>
							<!-- end of row div -->

							<hr>

							<h5><u><b>Parents Details</b></u></h5>

							<div class="row sales_table">
								<div class="col-md-6">
									<div class="row">
										<div class="form-group col-md-3 right_align">
											<label class="control-label">Father's Name:</label>
										</div>

										<div class="col-md-9">
											<input type="text" class="form-control" name="fatherName" value="{{ !empty($editEmployee->id)? $editEmployee->father_name : old('fatherName') }}" placeholder="Enter Father's Name">

											@if ($errors->has('fatherName'))
				                                <span class="help-block" style="color: #f86c6b;">
				                                    {{ $errors->first('fatherName') }}
				                                </span>
				                            @endif

										</div>
										<!-- /.input group -->
									</div>
								</div>

								<div class="col-md-6">
									<div class="row">
										<div class="form-group col-md-3 right_align">
											<label class="control-label">Mother's Name:</label>
										</div>

										<div class="col-md-9">
											<input type="text" class="form-control" name="motherName" value="{{ !empty($editEmployee->id)? $editEmployee->mother_name : old('motherName') }}" placeholder="Enter Mother's Name">

											@if ($errors->has('motherName'))
				                                <span class="help-block" style="color: #f86c6b;">
				                                    {{ $errors->first('motherName') }}
				                                </span>
				                            @endif

										</div>
										<!-- /.input group -->
									</div>
								</div>
								
							</div>
							<!-- end of row div -->


							<div class="row sales_table">
								<div class="col-md-6">
									<div class="row">
										<div class="form-group col-md-3 right_align">
											<label class="control-label">Grandfather's Name:</label>
										</div>

										<div class="col-md-9">
											<input type="text" class="form-control" name="grandFatherName" value="{{ !empty($editEmployee->id)? $editEmployee->grandfather_name : old('grandFatherName') }}" placeholder="Enter Grandfather's Name">

											@if ($errors->has('grandFatherName'))
				                                <span class="help-block" style="color: #f86c6b;">
				                                    {{ $errors->first('grandFatherName') }}
				                                </span>
				                            @endif

										</div>
										<!-- /.input group -->
									</div>
								</div>

								<div class="col-md-6">
									<div class="row">
										<div class="form-group col-md-3 right_align">
											<label class="control-label">Grandmother's Name:</label>
										</div>

										<div class="col-md-9">
											<input type="text" class="form-control" name="grandMotherName" value="{{ !empty($editEmployee->id)? $editEmployee->grandmother_name : old('grandMotherName') }}" placeholder="Enter Grandmother's Name">

											@if ($errors->has('grandMotherName'))
				                                <span class="help-block" style="color: #f86c6b;">
				                                    {{ $errors->first('grandMotherName') }}
				                                </span>
				                            @endif

										</div>
										<!-- /.input group -->
									</div>
								</div>
								
							</div>
							<!-- end of row div -->

							<div class="row sales_table">
								<div class="col-md-6">
									<div class="row">
										<div class="form-group col-md-3 right_align">
											<label class="control-label">Brother's Name:</label>
										</div>

										<div class="col-md-9">
											<input type="text" class="form-control" name="brotherName" value="{{ !empty($editEmployee->id)? $editEmployee->brother_name : old('brotherName') }}" placeholder="Enter Brother's Name">

											@if ($errors->has('brotherName'))
				                                <span class="help-block" style="color: #f86c6b;">
				                                    {{ $errors->first('brotherName') }}
				                                </span>
				                            @endif

										</div>
										<!-- /.input group -->
									</div>
								</div>
							</div>

							<hr>

							<div class="row sales_table">
								<div class="col-md-6">
									<div class="row">
										<div class="form-group col-md-3 right_align">
											<label class="control-label">Blood Group:</label>
										</div>

										<div class="col-md-9">
											<input type="text" class="form-control" name="bloodGroup" value="{{ !empty($editEmployee->id)? $editEmployee->blood_group : old('bloodGroup') }}" placeholder="Enter Blood Group">

											@if ($errors->has('bloodGroup'))
				                                <span class="help-block" style="color: #f86c6b;">
				                                    {{ $errors->first('bloodGroup') }}
				                                </span>
				                            @endif

										</div>
										<!-- /.input group -->
									</div>
								</div>

								<div class="col-md-6">
									<div class="row">
										<div class="form-group col-md-3 right_align">
											<label class="control-label">E-sewa Id:</label>
										</div>

										<div class="col-md-9">
											<input type="text" class="form-control" name="esewaId" value="{{ !empty($editEmployee->id)? $editEmployee->esewa_id : old('esewaId') }}" placeholder="Enter Esewa Id">

											@if ($errors->has('esewaId'))
				                                <span class="help-block" style="color: #f86c6b;">
				                                    {{ $errors->first('esewaId') }}
				                                </span>
				                            @endif

										</div>
										<!-- /.input group -->
									</div>
								</div>
								
							</div>
							<!-- end of row div -->

							<div class="row sales_table">
								<div class="col-md-6">
									<div class="row">
										<div class="form-group col-md-3 right_align">
											<label class="control-label">Education:</label>
										</div>

										<div class="col-md-9">
											<input type="text" class="form-control" name="education" value="{{ !empty($editEmployee->id)? $editEmployee->education : old('education') }}" placeholder="Enter Education">

											@if ($errors->has('education'))
				                                <span class="help-block" style="color: #f86c6b;">
				                                    {{ $errors->first('education') }}
				                                </span>
				                            @endif

										</div>
										<!-- /.input group -->
									</div>
								</div>

								<div class="col-md-6">
									<div class="row">
										<div class="form-group col-md-3 right_align">
											<label class="control-label">College Name:</label>
										</div>

										<div class="col-md-9">
											<input type="text" class="form-control" name="collegeName" value="{{ !empty($editEmployee->id)? $editEmployee->college_name : old('collegeName') }}" placeholder="Enter College Name">

											@if ($errors->has('collegeName'))
				                                <span class="help-block" style="color: #f86c6b;">
				                                    {{ $errors->first('collegeName') }}
				                                </span>
				                            @endif

										</div>
										<!-- /.input group -->
									</div>
								</div>
								
							</div>
							<!-- end of row div -->

							<div class="row sales_table">
								<div class="col-md-6">
									<div class="row">
										<div class="form-group col-md-3 right_align">
											<label class="control-label">Password:</label>
										</div>

										<div class="col-md-9">
											<input type="password" class="form-control" name="password" value="" placeholder="Enter Password">

											@if ($errors->has('password'))
				                                <span class="help-block" style="color: #f86c6b;">
				                                    {{ $errors->first('password') }}
				                                </span>
				                            @endif

										</div>
										<!-- /.input group -->
									</div>
								</div>

								<div class="col-md-6">
									<div class="row">
										<div class="form-group col-md-3 right_align">
											<label class="control-label">Roles:</label>
										</div>

										<div class="col-md-9">
											@foreach( $roles as $role)
												<div class="radio">
											      <label><input type="radio" name="role" value="{{ $role->id }}" {{ !empty($editEmployee->id)? ($editEmployee->role_id == $role->id)? 'checked' : '' : (old('role') == $role->id)? 'checked' : '' }}>{{ $role->display_name }}</label>
											    </div>
											@endforeach

										    

											@if ($errors->has('role'))
	                                <span class="help-block" style="color: #f86c6b;">
	                                    {{ $errors->first('role') }}
	                                </span>
	                            @endif

										</div>
										<!-- /.input group -->
									</div>
								</div>
							</div>

							<hr>

							<div class="row">
								<div class="col-md-12">
									@if( empty($editEmployee->id) )
										<button type="submit" class="btn btn-primary sales_submit pull-right">Add Employee</button> 
									@else
										<button type="submit" class="btn btn-primary sales_submit pull-right">Edit Employee</button> 
									@endif
								</div>
							</div>

						</form>
					</div>
					
				</div>
				<!-- /.box -->
			</div>
		</div>
	</section>
@endsection
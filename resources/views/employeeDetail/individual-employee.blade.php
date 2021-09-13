@extends('layouts.layouts')
@section('title', 'Ultrabyte | Add Sales')

@section('content')
	<section class="content">
		<div class="row">
			<div class="col-md-12">
				<div class="box box-primary">
					<div class="box-header with-border">
						<h3 class="box-title">Employee Detail</h3>
					</div>

					<div class="box-body">
						<form class="form-horizontal" method="post" action="{{ url('/admin/employee-detail/store') }}">
							{{ csrf_field() }}

							<div class="row sales_table">
								<div class="col-md-6">
									<div class="row">
										<div class="form-group col-md-3 right_align">
											<label class="control-label">Name:</label>
										</div>

										<div class="col-md-9">
											<h5>{{ $individualEmployee->name }}</h5>
										</div>
										<!-- /.input group -->
									</div>
								</div>

								<div class="col-md-6">
									<div class="row">
										<div class="form-group col-md-3 right_align">
											<label class="control-label">Date Of Birth:</label>
										</div>

										<div class="col-md-9">
											<h5>{{ $individualEmployee->date_of_birth }}</h5>

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
											<h5>{{ $individualEmployee->email }}</h5>

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
											<h5>{{ $individualEmployee->mobile_number }}</h5>

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
											<h5>{{ $individualEmployee->phone_number }}</h5>

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
											<h5>{{ $individualEmployee->temporary_address }}</h5>
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
											<h5>{{ $individualEmployee->temporary_tole }}</h5>

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
											<h5>{{ $individualEmployee->temporary_ward }}</h5>

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
											<h5>{{ $individualEmployee->permanent_address }}</h5>
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
											<h5>{{ $individualEmployee->permanent_tole }}</h5>

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
											<h5>{{ $individualEmployee->permanent_ward }}</h5>

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
											<h5>{{ $individualEmployee->fb_link }}</h5>

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
											<h5>{{ $individualEmployee->twitter_link }}</h5>

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
											<h5>{{ $individualEmployee->personal_website_link }}</h5>

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
											<h5>{{ $individualEmployee->bank_name_1 }}</h5>

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
											<h5>{{ $individualEmployee->swift_code_1 }}</h5>

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
											<h5>{{ $individualEmployee->bank_number_1 }}</h5>

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
											<h5>{{ $individualEmployee->branch_1 }}</h5>

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
											<h5>{{ !empty($individualEmployee->bank_name_2)? $individualEmployee->bank_name_2 : '' }}</h5>
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
											<h5>{{ !empty($individualEmployee->swift_code_2)? $individualEmployee->swift_code_2 : '' }}</h5>

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
											<h5>{{ !empty($individualEmployee->bank_number_2)? $individualEmployee->bank_number_2 : '' }}</h5>

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
											<h5>{{ !empty($individualEmployee->branch_2)? $individualEmployee->branch_2 : '' }}</h5>

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
											<h5>{{ $individualEmployee->father_name }}</h5>

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
											<h5>{{ $individualEmployee->mother_name }}</h5>

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
											<h5>{{ $individualEmployee->grandfather_name }}</h5>

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
											<h5>{{ $individualEmployee->grandmother_name }}</h5>

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
											<h5>{{ $individualEmployee->brother_name }}</h5>

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
											<h5>{{ $individualEmployee->blood_group }}</h5>

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
											<h5>{{ $individualEmployee->esewa_id }}</h5>

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
											<h5>{{ $individualEmployee->education }}</h5>

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
											<h5>{{ $individualEmployee->college_name }}</h5>

										</div>
										<!-- /.input group -->
									</div>
								</div>
								
							</div>
							<!-- end of row div -->
							<div class="row">
								<div class="col-md-6">
									<div class="row">
										<div class="form-group col-md-3 right_align">
											<label class="control-label">Role:</label>
										</div>

										<div class="col-md-9">
											<h5>{{ $individualEmployee->role->display_name }}</h5>

										</div>
										<!-- /.input group -->
									</div>
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
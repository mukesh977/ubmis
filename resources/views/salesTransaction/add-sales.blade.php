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

						@if(empty($editSale->id))
							<h3 class="box-title">Add Sales Transaction</h3>
						@else
							<h3 class="box-title">Edit Sales Transaction</h3>
						@endif

					</div>
					<div class="box-body">
						@if(empty($editSale->id))
						<form class="form-horizontal" method="post" action="{{ url('/store-sales') }}">
						@else
						<form class="form-horizontal" method="post" action="{{ url('/update-sales') }}">
						@endif

							{{ csrf_field() }}

							<input type="hidden" name="saleId" value="{{ !empty($editSale->id)? $editSale->id : old('saleId') }}">
							<input type="hidden" name="count" id="count" value="{{ !empty(old('count'))? old('count') : '' }}">

							<div class="row sales_table">
								<div class="col-md-6">
									<div class="row">
										<div class="form-group col-md-3 right_align">
											<label class="control-label">Sales Code:</label>
										</div>

										<div class="col-md-9">
											<input type="text" class="form-control" name="salesCode" id="salesCode" value="{{ !empty($editSale->id)? $editSale->sales_code : old('salesCode') }}" readonly>

											@if ($errors->has('salesCode'))
				                                <span class="help-block" style="color: #f86c6b;">
				                                    {{ $errors->first('salesCode') }}
				                                </span>
				                            @endif

										</div>
										<!-- /.input group -->
									</div>
								</div>

								<!-- Date -->
								<div class="form-group col-md-6">
									<div class="row">
										<div class="col-md-3 right_align">
											<label class="control-label">Date:</label>
										</div>

										<div class="col-md-auto">
											<div class="input-group date">
												<div class="input-group-addon">
													<i class="fa fa-calendar"></i>
												</div>

												<input type="text" class="form-control pull-right datepicker pl-12 form_date" name="date" value="<?php 
													if(!empty($editSale->id))
														echo $editSale->date;
													else
													{
														if(!empty(old('date')))
															echo old('date');
														else
															echo date("Y-m-d");
													}
												?> ">
											</div>
											<!-- /.input group -->
										</div>
									</div>

									@if ($errors->has('date'))
		                                <span class="help-block" style="color: #f86c6b; padding-left: 123px;">
		                                    {{ $errors->first('date') }}
		                                </span>
		                            @endif

								</div>
								<!-- /.form group -->
							</div>

							<!-- Date range -->
							<div class="row mb-10">
								<div class="col-md-6" id="office">

									<div class="row">
										<div class="form-group col-md-3 right_align">
											<label class="control-label">Office Name:</label>
										</div>

										<div class="col-md-9">
											<select class="form-control office_name" name="officeName" id="company_id">
												<option value="">Select Office Name</option>

												@foreach( $companies as $company)

													<option value="{{ $company->id }}" 
													<?php	
														if(!empty($editSale->id))
															{
																if( ($editSale->company_id)==($company->id) )
																	echo 'selected';
															}
															else
															{
																
																if( old('officeName')==($company->id) )
																	echo 'selected';
															}
													?>
														>{{ $company->name }}</option>
												@endforeach
											</select>

											<div id="officeMessage">
											</div>

											@if ($errors->has('officeName'))
					                        <span class="help-block" style="color: #f86c6b;">
					                            {{ $errors->first('officeName') }}
					                        </span>
						                    @endif

										</div>
									</div>
								</div>

								<div class="form-group col-md-6">
									<div class="row">
										<div class="col-md-3 right_align">
											<label class="control-label">Referred By:</label>
										</div>

										<div class="col-md-auto">
											<div class="input-group">
												<div class="input-group-addon">
													<i class="fa fa-user"></i>
												</div>

												<select class="form-control referred_by" name="referredBy">
													<option value="">Select Marketing Staff</option>

													@foreach( $marketingStaffs as $marketingStaff )
														<option value="{{ $marketingStaff->id }}" 
															<?php	
																if(!empty($editSale->id))
																	{
																		if( ($editSale->referred_by)==($marketingStaff->id) )
																			echo 'selected';
																	}
																	else
																	{
																		
																		if( old('referredBy')==($marketingStaff->id) )
																			echo 'selected';
																	}
															?>

															>{{ $marketingStaff->first_name}} {{ $marketingStaff->last_name }}</option>
													@endforeach

												</select>
											</div>
											<!-- /.input group -->
										</div>
									</div>

									@if ($errors->has('referredBy'))
		                                <span class="help-block" style="color: #f86c6b; padding-left: 123px;">
		                                    {{ $errors->first('referredBy') }}
		                                </span>
		                            @endif

								</div>
								<!-- /.form group -->

							</div>

							
							<!-- /.form group -->
							
								<!-- <a href="#" class="add-new-office pull-right">Add New Office</a> -->
							<button class="btn btn-success pull-right add_fields" title="Add Fields">Add Fields</button>
							<button class="btn btn-primary pull-right sales-add-new-office" title="Add New Office">Add New Office</button>

							<table class="table table-responsive-sm table-bordered" id="salesItems" style="margin-bottom: 35px;">
								<thead>
									<tr>
										<th width="27%">Services</th>
										<th width="17%">Price</th>
										<th width="17%">Information</th>
										<th width="18%">Start Date</th>
										<th width="18%">End Date</th>
										<th width="3%">&nbsp;</th>
									</tr>
								</thead>
								<tbody class="tableService">
									<tr>
										<td>
											<select class="form-control service" id="service_0" name="service[]">
												<option value="">Select Services</option>
												@foreach( $services as $service )
													
													<option value="{{ $service->id }}" <?php	
															if(!empty($editSale->id))
															{
																if($editSale->salesTransactionsItem[0]->service_id==$service->id )
																	echo 'selected';
															}
															else
															{
																
																if( old('service.0')==($service->id) )
																	echo 'selected';
															}
															?>>{{ $service->name }}</option>
												@endforeach
											</select>
											<!-- /.input group -->
										</td>

										<?php $content = !empty($editSale->id)? ($editSale->salesTransactionsItem[0]->service_id == 3)? 'service_0' : '' : ''; ?>

										<td>
											<input type="text" class="form-control" id="price_0" name="price[]" value="{{ !empty($editSale->id)? $editSale->salesTransactionsItem[0]->total_price : old('price.0') }}" placeholder="Price" onkeyup="price('0')">
										</td>

										<td class="information_0">
											@if( empty($editSale->id) )
												@if( old('service.0') != NULL)
													@if( old('service.0') == 2 )
														<select class="form-control seoSection" name="information[]" id="information_0">
															<option value="">Select Information</option>

															@foreach( $seoPackages as $seoPackage )
																<option value="{{ $seoPackage->slug }}" {{ (old('information.0') == $seoPackage->slug )? 'selected' : '' }}>
																	{{ $seoPackage->name }}
																</option>
															@endforeach

														</select>
													@elseif( old('service.0') == 10 )
														<select class="form-control" name="information[]" id="information_0">
															<option value="">Select Information</option>
															@foreach( $amcPackages as $amcPackage )
																<option value="{{ $amcPackage->slug }}" {{ ((old('information.0') == $amcPackage->slug)? 'selected' : '') }}>
																{{ $amcPackage->name }}
															</option>
															@endforeach
														</select>
													@else
														<input type="text" class="form-control" id="information_0" name="information[]" value="{{ old('information.0') }}" placeholder="Enter Information">
													@endif
												@else
													<input type="text" class="form-control" id="information_0" name="information[]" value="" placeholder="Information">
												@endif
											@else
												@if( $editSale->salesTransactionsItem[0]->service_id == 2 )
													<select class="form-control seoSection" name="information[]" id="information_0">
														<option value="">Select Information</option>

														@foreach( $seoPackages as $seoPackage )
															<option value="{{ $seoPackage->slug }}" {{ (($editSale->salesTransactionsItem[0]->information == $seoPackage->slug)? 'selected' : '') }}>
																{{ $seoPackage->name }}
															</option>
														@endforeach

													</select>
												@elseif( $editSale->salesTransactionsItem[0]->service_id == 10 )
													<select class="form-control" name="information[]" id="information_0">
														<option value="">Select Information</option>
														@foreach( $amcPackages as $amcPackage )
															<option value="{{ $amcPackage->slug }}" {{ (($editSale->salesTransactionsItem[0]->information == $amcPackage->slug)? 'selected' : '' ) }}>
															{{ $amcPackage->name }}
														</option>
														@endforeach
													</select>
												@else
													<input type="text" class="form-control" id="information_0" name="information[]" value="{{ $editSale->salesTransactionsItem[0]->information }}" placeholder="Information">
												@endif
											@endif

										</td>

										<?php
											$attribute = '';

											if(!empty($editSale->id))
											{
												$serviceId = $editSale->salesTransactionsItem[0]->service_id;

												if( $serviceId != 1 && $serviceId != 2 && $serviceId != 3 && $serviceId != 4 && $serviceId != 8 && $serviceId != 9 && $serviceId != 10 && $serviceId != 12 && $serviceId != 13 && $serviceId != 14 )
													$attribute = 'readonly';
											}
											else
											{
												if( old('service.0') != 1 && old('service.0') != 2 && old('service.0') != 3 && old('service.0') != 4 && old('service.0') != 8 && old('service.0') != 9 && old('service.0') != 10 && old('service.0') != 12 && old('service.0') != 13 && old('service.0') != 14 )
													$attribute = 'readonly'; 
											}
										?>
										<td>
											<input type="text" class="form-control form_date" id="startDate_0" name="startDate[]" value="{{ !empty($editSale->id)? $editSale->salesTransactionsItem[0]->start_date : old('startDate.0') }}" placeholder="Start Date" {{ $attribute }}> 
										</td>

										<td>
											<input type="text" class="form-control form_date" id="endDate_0" name="endDate[]" value="{{ !empty($editSale->id)? $editSale->salesTransactionsItem[0]->end_date : old('endDate.0') }}" placeholder="End Date" {{ $attribute }}>
										</td>

										<td>
										</td>
									</tr>

									<?php $count = !empty($editSale->id)? $editSale->salesTransactionsItem->count()-1 : old('count'); ?>

									@if(!empty($count))
										@for( $i = 1; $i <= $count; $i++ )
											<tr>
												<td>
													<select class="form-control service" id="service_{{ $i }}" name="service[]">
														<option value="">Select Services</option>
														@foreach( $services as $service )
															
															<option value="{{ $service->id }}" <?php	
																if(!empty($editSale->id))
																{
																	if($editSale->salesTransactionsItem[$i]->service_id==$service->id )
																		echo 'selected';
																}
																else
																{
																	
																	if( old('service.'.$i)==($service->id) )
																		echo 'selected';
																}
															?>
																>{{ $service->name }}</option>

														@endforeach
													</select>
													<!-- /.input group -->
												</td>

												<?php 
													if( !empty($editSale->id) )
													{
														if($editSale->salesTransactionsItem[$i]->service_id == 3)
														{
															$content = 'service_'.$i;
														}
													}
												 ?>

												<td>
													<input type="text" class="form-control" id="price_{{ $i }}" name="price[]" value="{{ !empty($editSale->id)? $editSale->salesTransactionsItem[$i]->total_price : old('price.'.$i) }}" placeholder="Price" onkeyup="price('{{ $i }}')">
												</td>

												<td class="information_{{ $i }}">
													@if( empty($editSale->id) )
														@if( old('service.'.$i) != NULL)
															@if( old('service.'.$i) == 2 )
																<select class="form-control seoSection" name="information[]" id="information_{{ $i }}">
																	<option value="">Select Information</option>

																	@foreach( $seoPackages as $seoPackage )
																		<option value="{{ $seoPackage->slug }}" {{ (old('information.'.$i) == $seoPackage->slug )? 'selected' : '' }}>
																			{{ $seoPackage->name }}
																		</option>
																	@endforeach

																</select>
															@elseif( old('service.'.$i) == 10 )
																<select class="form-control" name="information[]" id="information_{{ $i }}">
																	<option value="">Select Information</option>
																	@foreach( $amcPackages as $amcPackage )
																		<option value="{{ $amcPackage->slug }}" {{ ((old('information.'.$i) == $amcPackage->slug)? 'selected' : '') }}>
																		{{ $amcPackage->name }}
																	</option>
																	@endforeach
																</select>
															@else
																<input type="text" class="form-control" id="information_{{ $i }}" name="information[]" value="{{ old('information.'.$i) }}" placeholder="Enter Information">
															@endif
														@else
															<input type="text" class="form-control" id="information_{{ $i }}" name="information[]" value="" placeholder="Information">
														@endif
													@else
														@if( $editSale->salesTransactionsItem[$i]->service_id == 2 )
															<select class="form-control seoSection" name="information[]" id="information_{{ $i }}">
																<option value="">Select Information</option>

																@foreach( $seoPackages as $seoPackage )
																	<option value="{{ $seoPackage->slug }}" {{ (($editSale->salesTransactionsItem[$i]->information == $seoPackage->slug)? 'selected' : '') }}>
																		{{ $seoPackage->name }}
																	</option>
																@endforeach

															</select>
														@elseif( $editSale->salesTransactionsItem[$i]->service_id == 10 )
															<select class="form-control" name="information[]" id="information_{{ $i }}">
																<option value="">Select Information</option>
																@foreach( $amcPackages as $amcPackage )
																	<option value="{{ $amcPackage->slug }}" {{ (($editSale->salesTransactionsItem[$i]->information == $amcPackage->slug)? 'selected' : '' ) }}>
																	{{ $amcPackage->name }}
																</option>
																@endforeach
															</select>
														@else
															<input type="text" class="form-control" id="information_{{ $i }}" name="information[]" value="{{ $editSale->salesTransactionsItem[$i]->information }}" placeholder="Information">
														@endif
													@endif

												</td>

												<?php
													$attribute = '';
													if(!empty($editSale->id))
													{
														$serviceId = $editSale->salesTransactionsItem[$i]->service_id;
														
														if( $serviceId != 1 && $serviceId != 2 && $serviceId != 3 && $serviceId != 4 && $serviceId != 8 && $serviceId != 9 && $serviceId != 10 && $serviceId != 12 && $serviceId != 13 && $serviceId != 14 )
															$attribute = 'readonly';
													}
													else
													{
														if( old('service.'.$i) != 1 && old('service.'.$i) != 2 && old('service.'.$i) != 3 && old('service.'.$i) != 4 && old('service.'.$i) != 8 && old('service.'.$i) != 9 && old('service.'.$i) != 10 && old('service.'.$i) != 12 && old('service.'.$i) != 13 && old('service.'.$i) != 14 )
														
															$attribute = 'readonly'; 
													}
												?>



												<td>
													<input type="text" class="form-control form_date" id="startDate_{{ $i }}" name="startDate[]" value="{{ !empty($editSale->id)? $editSale->salesTransactionsItem[$i]->start_date : old('startDate.'.$i) }}" placeholder="Start Date" {{ $attribute }}>
												</td>
 
												<td>
													<input type="text" class="form-control form_date" id="endDate_{{ $i }}" name="endDate[]" value="{{ !empty($editSale->id)? $editSale->salesTransactionsItem[$i]->end_date : old('endDate.'.$i) }}" placeholder="End Date" {{ $attribute }}>
												</td>

												<td>
													<a href="#" class="link delete" title="Delete" onclick="deleteid('{{ $i }}')"><i class="fa fa-trash-o"></i></a>
												</td>
											</tr>
											
										@endfor
									@endif


								</tbody>
							</table>

							<div id="facebookDetails">
								<input type="hidden" name="countFbDetail" id="countFbDetails" value="{{ old('countFbDetail') }}">	
								
								<input type="hidden" name="fbIncludeId" id="fbIncludeId" value="{{ old('fbIncludeId') }}">	

								@if( !empty($editSale->salesTransactionsItemFb[0]) || old('countFbDetail') > 0 )  
									<h5><b>Facebook Details</b></h5>
									<table class="table table-responsive-sm table-bordered" style="margin-bottom: 35px;">
										<thead>
											<tr>
												<th width="37%">Particulars</th>
												<th width="20%">Dollar</th>
												<th width="20%">Graphics</th><th width="20%">Total</th>
												<th width="3%">&nbsp;</th>
											</tr>
										</thead>
										<tbody>
											<td>
												<input type="text" class="form-control" name="particulars[]" value="{{ !empty($editSale->id)? $editSale->salesTransactionsItemFb[0]->particulars : old('particulars.0') }}"placeholder="Particulars">
											</td>

											<td>
												<input type="text" class="form-control" name="dollar[]" value="{{ !empty($editSale->id)? $editSale->salesTransactionsItemFb[0]->dollar : old('dollar.0') }}" placeholder="Dollar">
											</td>

											<td>
												<input type="text" class="form-control" name="graphics[]" value="{{ !empty($editSale->id)? $editSale->salesTransactionsItemFb[0]->graphics : old('graphics.0') }}" placeholder="Graphics">
											</td>

											<td>
												<input type="text" class="form-control" name="total[]" id="total_1" value="{{ !empty($editSale->id)? $editSale->salesTransactionsItemFb[0]->total : old('total.0') }}" placeholder="Total" onkeyup="totalFbAmount(1)">
											</td>
											<td>
												<a href="" class="link add_fb_detail"><i class="fa fa-plus" style="margin-top: 10px;"></i></a>
											</td>

										@endif

										<?php $countFbDetail = !empty($editSale->id)? $editSale->salesTransactionsItemFb->count() : old('countFbDetail'); ?>

										@for( $i = 1; $i < $countFbDetail; $i++ )
											<tr>
												<td>
													<input type="text" class="form-control" name="particulars[]" value="{{ !empty($editSale->id)? $editSale->salesTransactionsItemFb[$i]->particulars : old('particulars.'.$i) }}" placeholder="Particulars">
												</td>

												<td>
													<input type="text" class="form-control" name="dollar[]" value="{{ !empty($editSale->id)? $editSale->salesTransactionsItemFb[$i]->dollar : old('dollar.'.$i) }}" placeholder="Dollar">
												</td>

												<td>
													<input type="text" class="form-control" name="graphics[]" value="{{ !empty($editSale->id)? $editSale->salesTransactionsItemFb[$i]->graphics : old('graphics.'.$i) }}" placeholder="Graphics">
												</td>

												<td>
													<input type="text" class="form-control" name="total[]" id="total_{{ $i+1 }}" value="{{ !empty($editSale->id)? $editSale->salesTransactionsItemFb[$i]->total : old('total.'.$i) }}"  placeholder="Total" onkeyup="totalFbAmount('{{ $i+1 }}')">
												</td>

												<td>
													<a href="#" class="link deleteFbDetail" title="Delete" onclick="deleteFbId('{{ $i+1 }}')"><i class="fa fa-trash-o" style="margin-top: 10px;"></i></a>
												</td>
											</tr>
										@endfor	
									</tbody>
								</table>						
							</div>
							

							<div class="row" <?php if(!$errors->has('officeName')) echo 'style="margin-bottom: 18px;"' ?>>
								<div class="col-md-3 lr_padding_0">
									<div class="col-md-6 control-label lr_padding_0" style="width: 41%">
										<label class="pull-right">Total Amount:</label>
									</div>
									<div class="col-md-6 control-label">
										<label class="pull-left" id="total_amount_label">{{ !empty($editSale->total_amount)? $editSale->total_amount : old('totalAmount') }}</label>

										<input type="hidden" id="total_amount_input" name="totalAmount" value="{{ !empty($editSale->total_amount)? $editSale->total_amount : old('totalAmount') }}">
									</div>
								</div>

								<div class="col-md-3 lr_padding_0">
									<div class="col-md-6 control-label lr_padding_0" style="width: 34%;">
										<label>Paid Amount:</label>
									</div>
									<div class="col-md-6">
										<input type="text" class="form-control" id="paid_amount" name="paidAmount" placeholder="Paid Amount" value="{{ !empty($editSale->total_paid_amount)? $editSale->total_paid_amount : old('paidAmount') }}" {{ !empty($editSale->id)? 'readonly' : '' }} onkeyup="paidamount()"> 
									</div>
								</div>

								<div class="col-md-3 lr_padding_0">
									<div class="col-md-6 control-label lr_padding_0" style="width: 49%;">
										<label>Remaining Amount:</label>
									</div>
									<div class="col-md-6">
										<input type="text" class="form-control" id="remaining_amount" name="unpaidAmount" value="{{ !empty($editSale->total_unpaid_amount)? $editSale->total_unpaid_amount : old('unpaidAmount') }}" placeholder="Remaining" {{ !empty($editSale->id)? 'readonly' : '' }}> 
									</div>
								</div>

								<div class="col-md-3 lr_padding_0">
									<div class="col-md-6 control-label lr_padding_0" style="width: 43%;">
										<label>Payment Method:</label>
									</div>
									<div class="col-md-6" style="padding-right: 0px;">
										<select class="form-control" name="paymentMethod" {{ !empty($editSale->id)? 'disabled' : '' }}>
											<option value="">Method</option>
											
											@foreach( $paymentMethods as $paymentMethod )
												<option value="{{ $paymentMethod->id }}" <?php 
													
													if(!empty(old('paymentMethod')))
													{
														if(old('paymentMethod')==$paymentMethod->id)
															echo "selected";
													}
													
												?>>{{ $paymentMethod->description }}</option>
											@endforeach
										</select>
									</div>
								</div>
							</div>


							@if ($errors->has('paidAmount') || $errors->has('unpaidAmount') || $errors->has('paymentMethod'))
								<div class="row" style="margin-bottom: 18px;">
									<div class="col-md-3 lr_padding_0">
										
									</div>

									<div class="col-md-3 lr_padding_0">
										<div class="col-md-6 control-label lr_padding_0" style="width: 34%;">
										</div>
										<div class="col-md-6">
											@if ($errors->has('paidAmount'))
				                                <span class="help-block" style="color: #f86c6b;">
				                                    {{ $errors->first('paidAmount') }}
				                                </span>
				                            @endif
										</div>
									</div>

									<div class="col-md-3 lr_padding_0">
										<div class="col-md-6 control-label lr_padding_0" style="width: 49%;">
										</div>
										<div class="col-md-6">
											@if ($errors->has('unpaidAmount'))
				                                <span class="help-block" style="color: #f86c6b;">
				                                    {{ $errors->first('unpaidAmount') }}
				                                </span>
				                            @endif
										</div>
									</div>

									<div class="col-md-3 lr_padding_0">
										<div class="col-md-6 control-label lr_padding_0" style="width: 43%;">
										</div>
										<div class="col-md-6">
											@if ($errors->has('paymentMethod'))
				                                <span class="help-block" style="color: #f86c6b;">
				                                    {{ $errors->first('paymentMethod') }}
				                                </span>
				                            @endif
										</div>
									</div>
								</div>
							@endif

							<div class="row" style="margin-bottom: 18px;">
								<div class="col-md-6">
								</div>
								<div class="col-md-6 lr_padding_0">
									<div class="col-md-4 control-label lr_padding_0" style="width: 25%;">
										<label>Cheque Number:</label>
									</div>
									<div class="col-md-9">
										<input type="text" class="form-control" name="chequeNumber" value="{{ old('chequeNumber') }}" placeholder="Cheque Number" {{ !empty($editSale->id)? 'readonly' : '' }}> 
									</div>
								</div>
							</div>

							@if ($errors->has('chequeNumber'))
								<div class="row" style="margin-bottom: 18px;">
									<div class="col-md-6">
									</div>
									<div class="col-md-6 lr_padding_0">
										<div class="col-md-4 control-label lr_padding_0" style="width: 25%;">
										</div>
										<div class="col-md-7">
											@if ($errors->has('chequeNumber'))
				                                <span class="help-block" style="color: #f86c6b;">
				                                    {{ $errors->first('chequeNumber') }}
				                                </span>
				                            @endif 
										</div>
									</div>
								</div>
							@endif



							<div class="row">
								<div class="col-md-10">
									<div class="col-md-12">
										@if ($errors->has('service.*'))
				                            <span class="help-block" style="color: #f86c6b;">
				                                {{ $errors->first('service.*') }}
				                            </span>
				                        @endif
				                    </div>

				                    <div class="col-md-12">
										@if ($errors->has('totalPrice.*'))
				                            <span class="help-block" style="color: #f86c6b;">
				                                {{ $errors->first('totalPrice.*') }}
				                            </span>
				                        @endif
				                    </div>

				                    <div class="col-md-12">
										@if ($errors->has('startDate.*'))
				                            <span class="help-block" style="color: #f86c6b;">
				                                {{ $errors->first('startDate.*') }}
				                            </span>
				                        @endif
				                    </div>

				                    <div class="col-md-12">
										@if ($errors->has('endDate.*'))
				                            <span class="help-block" style="color: #f86c6b;">
				                                {{ $errors->first('endDate.*') }}
				                            </span>
				                        @endif
				                    </div>

								</div>

								<div class="col-md-2">
									<button type="submit" class="btn btn-primary sales_submit pull-right">

										@if(empty($editSale->id))	
											Add Sales
										@else
											Edit Sales
										@endif

									</button> 
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
		<!-- Create a new office model -->
		@include('company.partials.create-new-office-modal-sales')
	</section>
@endsection

@section('script')
	<script>
		var stored_id = [];
		var countField = 0;
		var stored_fb_id = [];
		var fbIncludeId;
		var countFbDetails;
		var countFbId;
		var i;

		@if( !empty($editSale->id) )
			countField = '{{ $count }}';
			countFbDetails = '{{ $editSale->salesTransactionsItemFb->count() }}';
			countFbId = '{{ $editSale->salesTransactionsItemFb->count() }}';
			fbIncludeId = '{{ $content }}';

			for( i = 0; i <= countField; i++ )
				stored_id.push(i);

			for( i = 0; i < countFbDetails; i++ )
				stored_fb_id.push(i+1);

			$('#count').val(Number(countField) + 1);

		@else
			countField = '{{ !empty(old('count'))? old('count') : '0' }}';
			countFbDetails = '{{ !empty(old('countFbDetail')) ? old('countFbDetail') : '1' }}';
			countFbId = '{{ !empty(old('countFbDetail')) ? old('countFbDetail') : '1' }}';
			fbIncludeId = '{{ !empty(old('fbIncludeId'))? old('fbIncludeId') : '' }}';

			for( i = 0; i <= countField; i++ )
				stored_id.push(i);

			for( i = 0; i < countFbDetails; i++ )
				stored_fb_id.push(i+1);

			$('#count').val(Number(countField));

		@endif

		function price(id)
		{
			var sum = 0;
			var i;
			var flag = 0;
			var remaining_amount;

			for( i = 0; i < stored_id.length; i++ )
			{
				if( stored_id[i] == id )
					flag = 1;
			}
			if( flag == 0 )
				stored_id.push(id);
			
			for( i = 0; i < stored_id.length; i++ )
				sum = sum + Number($('#price_' + stored_id[i]).val());

			$('#total_amount_label').html(sum);
			$('#total_amount_input').val(sum);

			if( $('#paid_amount').val() == '' )
				$('#remaining_amount').val(sum);
			else
			{
				remaining_amount = sum - Number($('#paid_amount').val());
				$('#remaining_amount').val(remaining_amount);
			}
		}

		function paidamount()
		{
			var sum = 0;
			var i;
			var remaining_amount;

			for( i = 0; i < stored_id.length; i++ )
				sum = sum + Number($('#price_' + stored_id[i]).val());

			$('#total_amount_label').html(sum);
			$('#total_amount_input').val(sum);

			if( $('#paid_amount').val() == '' )
				$('#remaining_amount').val(sum);
			else
			{
				remaining_amount = sum - Number($('#paid_amount').val());
				$('#remaining_amount').val(remaining_amount);
			}
		}

		function deleteid(id)
		{
			var sum = 0;
			var i;
			var remaining_amount;

			for( i = 0; i < stored_id.length; i++ )
			{
				if( stored_id[i] == id )
				{
					stored_id.splice(i, 1);
				}

			}

			for( i = 0; i < stored_id.length; i++ )
				sum = sum + Number($('#price_' + stored_id[i]).val());

			$('#total_amount_label').html(sum);
			$('#total_amount_input').val(sum);

			if( $('#paid_amount').val() == '' )
				$('#remaining_amount').val(sum);
			else
			{
				remaining_amount = sum - Number($('#paid_amount').val());
				$('#remaining_amount').val(remaining_amount);
			}
		}


		$(document).ready(function() {
			
			var count = '<?php 
							if(!empty($editSale->id))
								echo ($count +1);
							else
							{
								if(!empty(old('count')))
									echo old('count');
								else
									echo '0';
							}
			 ?>';
			 
			var field = $('#salesItems').find('tbody');
			var lstSalesId = "{{ $lastSalesId }}";
			var lastSalesId = String("00000" + lstSalesId).slice(-5);
			var oldSalesCode = '{{ old('salesCode') }}';

			
			@if( !empty(old('salesCode')) )
				$('#salesCode').val(oldSalesCode);
			@else
				@if(empty($editSale->id))
					$('#salesCode').val('S-000-' + lastSalesId);
				@else
					$('#salesCode').val('{{ $editSale->sales_code }}');
				@endif
			@endif


			$('#total_amount_label').val($('#total_amount_input').val());

			$(document).on('focus',".form_date", function(){
			    $(this).datepicker({
				dateFormat: "yy-mm-dd",
				changeMonth: true,
				changeYear: true,
				});
			});

			$('.office_name').select2();
			$('.referred_by').select2();

			$('.add_fields').on('click', function(e){
				e.preventDefault();
				count++;
				countField++;

				$(field).append('<tr><td><select class="form-control service"  id="service_'+ countField +'" name="service[]"><option value="">Select Services</option>@foreach( $services as $service )<option value="{{ $service->id }}">{{ $service->name }}</option>@endforeach</select></td><td><input type="text" class="form-control" name="price[]" id="price_' + countField + '" placeholder="Price" onkeyup="price(' + countField + ')"></td><td class="information_'+countField+'"><input type="text" class="form-control" name="information[]" id="information_'+ countField +'" placeholder="Information"></td><td><input type="text" class="form-control form_date" name="startDate[]" id="startDate_'+ countField +'" value="" placeholder="Start Date"></td><td><input type="text" class="form-control form_date" name="endDate[]" id="endDate_'+ countField +'" value="" placeholder="End Date"></td><td><a href="#" class="link delete" title="Delete" onclick="deleteid('+ countField +')"><i class="fa fa-trash-o"></i></a></td></tr>');

				$('#count').val(count);

			});

			$(field).on('click', '.delete', function(e){
				e.preventDefault();
				$(this).parent().closest('tr').remove();

				count--;
				$('#count').val(count);
			});
			
			$('#company_id').on('select2:select', function(){
				var company = $('#company_id option:selected').val();
				var companyId = String("000" + company).slice(-3);

				$('#salesCode').val('S-' + companyId + '-' + lastSalesId);
			});



			//Office modal script starts


			$('.phone_add').on('click', function(e){
		    e.preventDefault();

		    $('#contactTable').find('.table > tbody').append('<tr><td width="95%"><input type="text" name="contactNumber[]" placeholder="Enter Contact Number" class="form-control"></td><td width="5%"><a href="#" class="link deleteContact" title="Delete" onclick="deleteid()"><i class="fa fa-trash-o" style="margin-top: 10px;"></i></a></td></tr>');
		  });


		  $('.email_add').on('click', function(e){
		    e.preventDefault();

		    $('#emailTable').find('.table > tbody').append('<tr><td width="95%"><input type="text" name="email[]" placeholder="Enter E-mail" class="form-control"></td><td width="5%"><a href="#" class="link deleteEmail" title="Delete"><i class="fa fa-trash-o" style="margin-top: 10px;"></i></a></td></tr>');
		  });
    
		  $('#contactTable').find('.table > tbody').on('click', '.deleteContact', function(e){
		    e.preventDefault();
		    $(this).parent().closest('tr').remove();

		  });

		  $('#emailTable').find('.table > tbody').on('click', '.deleteEmail', function(e){
		    e.preventDefault();
		    $(this).parent().closest('tr').remove();

		  });

			$('#salesOfficeModal').on('hidden.bs.modal', function () {
		        clearform();
		      });

      $('.sales-add-new-office').click(function(e){
		    e.preventDefault();
		    $('#salesOfficeModal').modal('show');
			});



			$('#salesOfficeModal').on('hidden.bs.modal', function () {
			    clearform();
			})


			function clearform(){
			    $('#salesOfficeModal').find('.form-group').each(function( index, element ){
			        $('.form-group').removeClass('has-error');
			        $('.help-block').empty();

			    });

	        $('#emailTable').find('.table > tbody').find('tr').not(':first').empty();
	        $('#contactTable').find('.table > tbody').find('tr').not(':first').empty();

	        $('#salesOfficeModal').find('input').val("");
	        $('.salesOfficeModal').find('label').find('.error').remove();
			}

			$('#save-new-office-sales').click(function(e){
				var contactNumberArray = [];
				var emailArray = [];
			  var token = $('input[name="_token"]').val();
			  var name = $('input[name="name"]').val();
			  var address = $('input[name="address"]').val();
			  var contactNumber = $('input[name="contactNumber[]"]').each( function(){
			  		contactNumberArray.push($(this).val());
			  });

			  var email = $('input[name="email[]"]').each( function(){
			  		emailArray.push($(this).val());
			  });


			  $.ajax({
			      url: baseUrl + "officesales",
			      type: "POST",
			      data:{ _token:token, name:name, address:address, contactNumbers: contactNumberArray, emails: emailArray, method:'post'},
			      success: function(result){
			          $('#shopModal').find('.form-group').each(function(){
			              //reset field
			              $(this).find('input').val();
			              //clear erorrs class
			              $('.form-group').removeClass('has-error');
			              $('.help-block').empty();
			          });
			          
			          $('#salesOfficeModal').modal('hide');
			          clearform();
			          $('#office').find('select[name="officeName"]').append('<option value="'+ result.data.id +'" selected>'+ result.data.name +'</option>');
		            
		            $('#office').find('#officeMessage').append(result.message).css('color','#449d44');
			          
			          setTimeout(function() { $('#officeMessage').text(''); }, 5000);

			      },

			      error: function(errors){
			      	console.log($.parseJSON(errors.responseText));
			      		$('.help-block').text("Empty fields !!!");

			      },
			  	});

			});


			//facebook Detail options
			
			
			$(document).on('change', '.service', function() {

				if( fbIncludeId != '' )
				{
					if( $(this)[0].id == fbIncludeId )
					{
						if( $(this).val() != 3 )
						{
							$('#facebookDetails').empty();
							fbIncludeId = '';
							$('#fbIncludeId').val(fbIncludeId);
						}
					}
					
				}
				else
				{
					if( $(this).val() == 3 )
					{
						$('#facebookDetails').append('<h5><b>Facebook Details</b></h5><table class="table table-responsive-sm table-bordered" style="margin-bottom: 35px;"><thead><tr><th width="37%">Particulars</th><th width="20%">Dollar</th><th width="20%">Graphics</th><th width="20%">Total</th><th width="3%">&nbsp;</th></tr></thead><tbody><td><input type="text" class="form-control" name="particulars[]" placeholder="Particulars"></td><td><input type="text" class="form-control" name="dollar[]" placeholder="Dollar"></td><td><input type="text" class="form-control" name="graphics[]" placeholder="Graphics"></td><td><input type="text" class="form-control" name="total[]" id="total_1" value="" placeholder="Total" onkeyup="totalFbAmount(1)"></td><td><a href="" class="link add_fb_detail"><i class="fa fa-plus" style="margin-top: 10px;"></i></a></td></tbody></table>');

						fbIncludeId = $(this)[0].id;
						$('#fbIncludeId').val(fbIncludeId);

						// countFbDetails++;
						$('#countFbDetails').val(countFbDetails);

					}
				}

			});

			//add and deletion of facebook details table

			$(document).on('click', '.add_fb_detail', function(e) {
				e.preventDefault();

				countFbDetails++;
				countFbId++;
				$('#countFbDetails').val(countFbDetails);

				$('#facebookDetails').find('table > tbody').append('<tr><td><input type="text" class="form-control" name="particulars[]" placeholder="Particulars"></td><td><input type="text" class="form-control" name="dollar[]" placeholder="Dollar"></td><td><input type="text" class="form-control" name="graphics[]" placeholder="Graphics"></td><td><input type="text" class="form-control" name="total[]" id="total_'+ countFbId +'" value=""  placeholder="Total" onkeyup="totalFbAmount('+ countFbId +')"></td><td><a href="#" class="link deleteFbDetail" title="Delete" onclick="deleteFbId('+ countFbId +')"><i class="fa fa-trash-o" style="margin-top: 10px;"></i></a></td></tr>');
			});

			$('#facebookDetails').on('click', '.deleteFbDetail', function(e){
				e.preventDefault();
				$(this).parent().closest('tr').remove();

				countFbDetails--;
				$('#countFbDetails').val(countFbDetails);
			});

			

			//updates price as according to change in seo package
			var seoPackage;
			var amcPackage;
			var seoPackageLength;
			var amcPackageLength;

			$.ajax({
               type:'GET',
               url:'/seo-amc-information',
               data:'',
               success:function(data) {
                  seoPackage = data[0];
                  amcPackage = data[1];
                  seoPackageLength = seoPackage.length;
                  amcPackageLength = amcPackage.length;
               }
            });

			$(document).on('change', '.seoSection', function() {
				var id = $(this)[0].id;
				var idValue = id.split('_');
				var seoInformation = $('#'+id+' option:selected').val();

				for(var i = 0; i < seoPackageLength; i++)
				{
					if( seoInformation == seoPackage[i].slug)
					{
						if(seoInformation == 'customize')
						{
							$('#price_'+idValue[1]).val('');
							price(idValue[1]);
						}
						else
						{
							$('#price_'+idValue[1]).val(seoPackage[i].price);
							price(idValue[1]);
						}
					}
					if( seoInformation == '')
					{
						$('#price_'+idValue[1]).val('');
						price(idValue[1]);
					}
				}

			});


			$(document).on('change', '.service', function() {
				var id = $(this)[0].id;
				var idValue = id.split('_');

				if( $(this).val() != 1 && $(this).val() != 2 && $(this).val() != 3 && $(this).val() != 4 && $(this).val() != 8 && $(this).val() != 9 && $(this).val() != 10 && $(this).val() != 12 && $(this).val() != 13 && $(this).val() != 14 )
				{
					$('#startDate_'+idValue[1]).prop('readonly', true);
					$('#endDate_'+idValue[1]).prop('readonly', true);
				}
				else
				{
					$('#startDate_'+idValue[1]).prop('readonly', false);
					$('#endDate_'+idValue[1]).prop('readonly', false);
				}

				$('#diskSpace_'+idValue[1]).prop('readonly', false);

				//removes and add the corresponding box in table column "information"
				switch( $(this).val() )
				{
					case '2':
						$('#information_'+idValue[1]).remove();
						$('.information_'+idValue[1]).append('<select class="form-control seoSection" name="information[]" id="information_'+ idValue[1] +'"><option value="">Select Information</option> @foreach( $seoPackages as $seoPackage ) <option value="{{ $seoPackage->slug }}">{{ $seoPackage->name }}</option> @endforeach</select>');
						break;

					case '10':
						$('#information_'+idValue[1]).remove();
						$('.information_'+idValue[1]).append('<select class="form-control" name="information[]" id="information_'+ idValue[1] +'"><option value="">Select Information</option> @foreach( $amcPackages as $amcPackage )<option value="{{ $amcPackage->slug }}">{{ $amcPackage->name }}</option> @endforeach</select>');
						break;

					default:
						$('#information_'+idValue[1]).remove();
						$('.information_'+idValue[1]).append('<input type="text" class="form-control" id="information_'+ idValue[1] +'" name="information[]" id="information_'+ idValue[1] +'" value="" placeholder="Information">');
						break;
				}


			});

		});

		function totalFbAmount(id)
		{
			var sum = 0;
			var flag = 0;
			var i;

			for( i = 0; i < stored_fb_id.length; i++ )
			{
				if( stored_fb_id[i] == id )
					flag = 1;
			}
			if( flag == 0 )
				stored_fb_id.push(id);
			
			for( i = 0; i < stored_fb_id.length; i++ )
				sum = sum + Number($('#total_' + stored_fb_id[i]).val());

			var content = fbIncludeId.split('_');

			$('#price_'+ content[1]).val(sum);
			price(content[1]);
		}

		function deleteFbId(id)
		{
			var sum = 0;
			var i;

			for( i = 0; i < stored_fb_id.length; i++ )
			{
				if( stored_fb_id[i] == id )
				{
					stored_fb_id.splice(i, 1);
				}

			}

			for( i = 0; i < stored_fb_id.length; i++ )
				sum = sum + Number($('#total_' + stored_fb_id[i]).val());

			var content = fbIncludeId.split('_');

			$('#price_'+ content[1]).val(sum);
			price(content[1]);
		}

	</script>

@endsection
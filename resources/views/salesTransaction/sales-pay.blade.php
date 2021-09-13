@extends('layouts.layouts')
@section('title', 'Ultrabyte | Sales Pay')

@section('content')
<section class="content">

	@if(session('successMessage'))
	<div class="alert alert-success success-notification">
		<a href="#" class="close" data-dismiss="alert">&times;
		</a>
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
					@if( !empty($editSale) )
					<h3 class="box-title">Edit Sales Payment</h3>
					@else
					<h3 class="box-title">Sales Payment</h3>
					<a href="{{ url('/pay-sales/edit/'.$sale->id) }}">
						<button class="btn btn-success pull-right" title="Edit Payment">Edit Payment</button>
					</a>
					@endif

				</div>
				<div class="box-body">
					<div class="form-horizontal">
						<div class="row sales_pay_table">
							<div class="col-md-6">
								<div class="row">
									<div class="form-group col-md-3 right_align">
										<label class="control-label">Sales Code:</label>
									</div>

									<div class="col-md-9">
										<h5>{{ $sale->sales_code }}</h5>
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
											<h5>{{ $sale->date }}</h5>
										</div>
										<!-- /.input group -->
									</div>
								</div>
							</div>
							<!-- /.form group -->
						</div>

						<!-- Date range -->
						<div class="row mb-30">
							<div class="col-md-6" id="office">

								<div class="row">
									<div class="form-group col-md-3 right_align">
										<label class="control-label">Office Name:</label>
									</div>

									<div class="col-md-9">

										@foreach( $companies as $company)

										<?php	
										if(!empty($sale->id))
										{
											if( ($sale->company_id)==($company->id) )
												echo '<h5>'. $company->name .'</h5>';
										}
										?>

										@endforeach

									</div>
								</div>
							</div>
						</div>

						<table class="table table-responsive-sm table-bordered" style="margin-bottom: 35px;">
							<thead>
								<tr>
									<th width="30%" class="pl-20">Services</th>
									<th width="17%" class="pl-20">Price</th>
									<th width="17%" class="pl-20">Information</th>
									<th width="18%" class="pl-20">Start Date</th>
									<th width="18%" class="pl-20">End Date</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td class="pl-20">
										@foreach( $services as $service )

										<?php	
										if(!empty($sale->id))
										{
											if($sale->salesTransactionsItem[0]->service_id==$service->id )
												echo '<h5>'. $service->name .'</h5>';
										}
										?>

										@endforeach

										<!-- /.input group -->
									</td>

									<td class="pl-20">
										<h5>{{ !empty($sale->id)? nepali_number_format($sale->salesTransactionsItem[0]->total_price) : old('price.0') }}</h5>
									</td>

									<td class="pl-20">
										
										<h5>
											<?php 
												if( !empty($sale->id) )
												{
													if($sale->salesTransactionsItem[0]->service_id== 2)
													{
														foreach( $seoPackages as $seoPackage )
														{
															if( $seoPackage->slug == $sale->salesTransactionsItem[0]->information )
															{
																echo $seoPackage->name;
															}
														}

													}
													else if($sale->salesTransactionsItem[0]->service_id== 10)
													{
														foreach( $amcPackages as $amcPackage )
														{
															if( $amcPackage->slug == $sale->salesTransactionsItem[0]->information )
															{
																echo $amcPackage->name;
															}
														}
													}
													else
													{
														echo $sale->salesTransactionsItem[0]->information;
													}


												} 
											?>
										</h5>
									</td>

									<td class="pl-20">
										<h5>{{ !empty($sale->id)? $sale->salesTransactionsItem[0]->start_date : old('startDate.0') }}</h5>
									</td>

									<td class="pl-20">
										<h5>{{ !empty($sale->id)? $sale->salesTransactionsItem[0]->end_date : old('endDate.0') }}</h5>
									</td>
								</tr>

								<?php $count = !empty($sale->id)? $sale->salesTransactionsItem->count()-1 : old('count'); ?>

								@if(!empty($count))
								@for( $i = 1; $i <= $count; $i++ )
								<tr>
									<td class="pl-20">
										@foreach( $services as $service )

										<?php	
										if(!empty($sale->id))
										{
											if(($sale->salesTransactionsItem[$i]->service_id)==($service->id) )
												echo '<h5>'. $service->name .'</h5>';
										}

										?>

										@endforeach


									</td>

									<td class="pl-20">

										<h5>{{ !empty($sale->id)? nepali_number_format($sale->salesTransactionsItem[$i]->total_price) : old('price.'.$i) }}</h5>

									</td>

									<td class="pl-20">
										<h5>
											<?php 
												if( !empty($sale->id) )
												{
													if($sale->salesTransactionsItem[$i]->service_id== 2)
													{
														foreach( $seoPackages as $seoPackage )
														{
															if( $seoPackage->slug == $sale->salesTransactionsItem[$i]->information )
															{
																echo $seoPackage->name;
															}
														}

													}
													else if($sale->salesTransactionsItem[$i]->service_id== 10)
													{
														foreach( $amcPackages as $amcPackage )
														{
															if( $amcPackage->slug == $sale->salesTransactionsItem[$i]->information )
															{
																echo $amcPackage->name;
															}
														}
													}
													else
													{
														echo $sale->salesTransactionsItem[$i]->information;
													}


												} 
											?>
										</h5>
									</td>

									<td class="pl-20">
										<h5>{{ !empty($sale->id)? $sale->salesTransactionsItem[$i]->start_date : old('startDate.'.$i) }}</h5>
									</td>

									<td class="pl-20">
										<h5>{{ !empty($sale->id)? $sale->salesTransactionsItem[$i]->end_date : old('endDate.'.$i) }}</h5>
									</td>

								</tr>
								@endfor
								@endif


							</tbody>
						</table>


						<div id="facebookDetails">
							<input type="hidden" name="countFbDetail" id="countFbDetails" value="{{ old('countFbDetail') }}">	
							
							<input type="hidden" name="fbIncludeId" id="fbIncludeId" value="{{ old('fbIncludeId') }}">	

							@if( !empty($sale->salesTransactionsItemFb[0]) > 0 )  
								<h5><b>Facebook Details</b></h5>
								<table class="table table-responsive-sm table-bordered" style="margin-bottom: 35px;">
									<thead>
										<tr>
											<th width="40%">Particulars</th>
											<th width="20%">Dollar</th>
											<th width="20%">Graphics</th>
											<th width="20%">Total</th>
										</tr>
									</thead>
									<tbody>
										<td class="pl-20">
											<h5>{{ !empty($sale->id)? $sale->salesTransactionsItemFb[0]->particulars : '' }}</h5>
										</td>

										<td class="pl-20">
											<h5>{{ !empty($sale->id)? $sale->salesTransactionsItemFb[0]->dollar : '' }}</h5>
										</td>

										<td class="pl-20">
											<h5>{{ !empty($sale->id)? nepali_number_format($sale->salesTransactionsItemFb[0]->graphics) : '' }}</h5>
										</td>

										<td class="pl-20">
											<h5>{{ !empty($sale->id)? nepali_number_format($sale->salesTransactionsItemFb[0]->total) : '' }}</h5>
										</td>

									@endif

									<?php $countFbDetail = !empty($sale->id)? $sale->salesTransactionsItemFb->count() : 0; ?>

									@for( $i = 1; $i < $countFbDetail; $i++ )
										<tr>
											<td class="pl-20">
												<h5>{{ !empty($sale->id)? $sale->salesTransactionsItemFb[$i]->particulars : '' }}</h5>
											</td>
											
											<td class="pl-20">
												<h5>{{ !empty($sale->id)? $sale->salesTransactionsItemFb[$i]->dollar : '' }}</h5>
											</td>
											
											<td class="pl-20">
												<h5>{{ !empty($sale->id)? nepali_number_format($sale->salesTransactionsItemFb[$i]->graphics) : '' }}</h5>
											</td>
											
											<td class="pl-20">
												<h5>{{ !empty($sale->id)? nepali_number_format($sale->salesTransactionsItemFb[$i]->total) : '' }}</h5>
											</td>
										</tr>
									@endfor	
								</tbody>
							</table>						
						</div>


						<form method="post" action="{{ url('/pay-sales/edit') }}">
							{{ csrf_field() }}
							<div class="row" <?php if(!$errors->has('officeName')) echo 'style="margin-bottom: 18px;"' ?>>
								<div class="col-md-3 lr_padding_0">
									<div class="col-md-6 control-label lr_padding_0" style="width: 52%">
										<label class="pull-right">Total Amount:</label>
									</div>
									<div class="col-md-5">
										<h5 class="pull-left" id="total_amount_label">{{ !empty($sale->total_amount)? nepali_number_format($sale->total_amount) : old('totalAmount') }}</h5>

										<input type="hidden" id="total_amount_input" name="totalAmount" value="{{ !empty($sale->total_amount)? $sale->total_amount : old('totalAmount') }}">
									</div>

									<div class="col-md-6 control-label lr_padding_0" style="width: 52%">
										<label class="pull-right">Total Paid Amount:</label>
									</div>
									<div class="col-md-5">
										<h5 class="pull-left" id="total_amount_label">{{ !empty($sale->total_paid_amount)? nepali_number_format($sale->total_paid_amount) : old('totalAmount') }}</h5>

										<input type="hidden" id="total_amount_input" name="totalAmount" value="{{ !empty($sale->total_amount)? $sale->total_amount : old('totalAmount') }}">
									</div>

									<div class="col-md-6 control-label lr_padding_0" style="width: 52%">
										<label class="pull-right">Remaining Amount:</label>
									</div>
									<div class="col-md-5">
										<h5 class="pull-left" id="total_amount_label">{{ !empty($sale->total_unpaid_amount)? nepali_number_format($sale->total_unpaid_amount) : old('totalAmount') }}</h5>

										<input type="hidden" id="total_amount_input" name="totalAmount" value="{{ !empty($sale->total_amount)? $sale->total_amount : old('totalAmount') }}">
									</div>


								</div>

								<div class="col-md-9">
									@if( !empty($editSale) )
									<button class="btn btn-success pull-right add_fields" title="Add Fields">Add Fields</button>
									@endif		

									<input type="hidden" name="count" id="count" value="{{ !empty(old('count'))? old('count') : '' }}">	

									<input type="hidden" name="saleId" value="{{ !empty($sale->id)? $sale->id : old('saleId') }}">							

									<table class="table table-responsive-sm table-bordered" id="payTable" style="margin-bottom: 35px;">
										<thead>
											<tr>
												<th width="17%" class="pl-20">Installment</th>
												<th width="22%" class="pl-20">Paid Amount</th>
												<th width="20%" class="pl-20">Payment Method</th>
												<th width="23%" class="pl-20">Cheque Number</th>
												<th width="15%" class="pl-20">Date</th>
												<th width="3%"></th>
											</tr>
										</thead>
										<tbody>

											<?php 
													// dd(old('iPaymentMethod.8'));
											if(!empty(old('count')))
												$count = old('count');
											else 
												$count = $sale->SalesInstallmentPayment->count();
											?>

											@for( $i = 0; $i < $count; $i++ )
											<tr>
												<td class="pl-20">
													@if( $i == 0 )
													<h5>{{ $i+1 }}<sup>st</sup> Installment</h5>
													@elseif( $i == 1 )
													<h5>{{ $i+1 }}<sup>nd</sup> Installment</h5>
													@elseif( $i == 2 )
													<h5>{{ $i+1 }}<sup>rd</sup> Installment</h5>
													@elseif( $i == 3 )
													<h5>{{ $i+1 }}<sup>rth</sup> Installment</h5>
													@else
													<h5>{{ $i+1 }}<sup>th</sup> Installment</h5>
													@endif

												</td>

												<td>

													<input type="text" class="form-control" name="iPaidAmount[]" placeholder="Paid Amount" value="<?php 
																// dd($i);
													if(!empty(old('count')))
													{
														if(!empty(old('iPaidAmount.'.$i)))
														{
															echo old('iPaidAmount.'.$i);
														}
														else
														echo '';
													}
													else
													{
														if(!empty($sale->SalesInstallmentPayment[$i]->paid_amount))
														{
															echo $sale->SalesInstallmentPayment[$i]->paid_amount;
														}
														else
														echo '';

													}
													?>" {{ empty($editSale)? 'disabled' : '' }} >
												</td>

												<td>
													<select class="form-control" name="iPaymentMethod[]" {{ empty($editSale)? 'disabled' : '' }}>
														<option value="">Select Payment Method</option>

														@foreach( $paymentMethods as $paymentMethod)
															<option value="{{ $paymentMethod->id }}" <?php 
														if(!empty(old('count')))
														{
															if(old('iPaymentMethod.'.$i)==$paymentMethod->id)
																echo "selected";
															else
																echo "";

														}
														else
														{
															if(!empty($sale->SalesInstallmentPayment[$i]->payment_method))
															{
																if($sale->SalesInstallmentPayment[$i]->payment_method==$paymentMethod->id)
																	echo "selected";
															}
															else
																echo '';
														}

														?>>{{ $paymentMethod->description }}</option>
														@endforeach
													</select>
												</td>

												<td>

													<input type="text" class="form-control" name="iChequeNumber[]" placeholder="{{ (!empty($editSale))? 'Cheque Number' : '' }}" value="<?php 
																// dd($i);
													if(!empty(old('count')))
													{
														if(!empty(old('iChequeNumber.'.$i)))
														{
															echo old('iChequeNumber.'.$i);
														}
														else
														echo '';
													}
													else
													{
														if(!empty($sale->SalesInstallmentPayment[$i]->cheque_number))
														{
															echo $sale->SalesInstallmentPayment[$i]->cheque_number;
														}
														else
														echo '';

													}
													?>" {{ empty($editSale)? 'disabled' : '' }} >
												</td>

												<td>
													<input type="text" class="form-control date" name="date[]" placeholder="Date" value="<?php
														if(!empty(old('date')))
														{
															if(!empty(old('date.'.$i)))
															{
																echo old('date.'.$i);
															}
															else
															echo '';
														}
														else
														{
															if(!empty($sale->SalesInstallmentPayment[$i]->date))
															{
																echo $sale->SalesInstallmentPayment[$i]->date;
															}
															else
																echo '';
														}
													?>"  {{ empty($editSale)? 'disabled' : '' }}>
												</td>

												@if( !empty($editSale) )
												<td>
													<a href="#" class="link delete" title="Delete"><i class="fa fa-trash-o"></i>
													</a>
												</td>

												@else
												<td>
												</td>
												@endif

											</tr>
											@endfor

										</tbody>
									</table>

									@if ($errors->has('iPaidAmount.*'))
										<span class="help-block" style="color: #f86c6b;">
											{{ $errors->first('iPaidAmount.*') }}
										</span>
									@endif

									@if ($errors->has('iPaymentMethod.*'))
										<span class="help-block" style="color: #f86c6b;">
											{{ $errors->first('iPaymentMethod.*') }}
										</span>
									@endif

									@if ($errors->has('date.*'))
										<span class="help-block" style="color: #f86c6b;">
											{{ $errors->first('date.*') }}
										</span>
									@endif


									@if( !empty($editSale) )
									<input class="btn btn-primary sales_submit pull-right" type="submit" value="Edit Pay">
									@endif
								</div>
							</div>
						</form>

						<div class="row">
							<div class="col-md-10">
								<div class="col-md-12">
									
								</div>

								<div class="col-md-12">
									
								</div>
							</div>

							@if( empty($editSale) )
							<div class="col-md-2">
								<button class="btn btn-primary sales_submit pull-right" id="pay">
									Pay
								</button> 
							</div>
							@endif

						</div>
					</div>

				</div>
				<!-- /.box-body -->
			</div>
			<!-- /.box -->
		</div>
		<!-- /.col (right) -->

		<div class="modal fade" id="payModal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<form method="post" id="payForm" action="{{ url('/pay-processing') }}">
					{{ csrf_field() }}
					<div class="modal-content">
						<div class="modal-header">
							<label class="supplierModalLabel">Make Payment</label>
							<button class="close" type="button" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">×</span>
							</button>
						</div>
						
						<div class="modal-body">
							<div class="row">
								<div class="col-md-6">
									<div class="row">
										<div class="col-sm-7">
											<h5 class="supplierResult">Total Amount:</h5>
										</div>
										<div class="col-sm-5">
											<h5 id="totalAmount" class="supplierResult"></h5>
											<input type="hidden" name="saleId" value="{{ $sale->id }}">

										</div>
									</div>

									<div class="row">
										<div class="col-sm-7">
											<h5 class="supplierResult">Total Paid Amount:</h5>
										</div>
										<div class="col-sm-5">
											<h5 id="paidAmount" class="supplierResult"></h5>
										</div>
									</div>
									<div class="row">
										<div class="col-sm-7">
											<h5 class="supplierResult">Remaining Amount:</h5>
										</div>
										<div class="col-sm-5">
											<h5 id="remainingAmount" class="supplierResult"></h5>
										</div>
									</div>
								</div>

								<div class="col-md-6" style="padding-left: 0px;">
									<div class="row">
										<div class="col-sm-5 plr-0">
											<h5 class="supplierResult pull-right">Pay:</h5>
										</div>
										<div class="col-sm-7">
											<input type="text" class="form-control" id="payAmount" name="payAmount" placeholder="Enter paid amount" onkeyup="calculate()">
										</div>
									</div>

									<div class="row" style="margin-top: 10px;">
										<div class="col-sm-5 plr-0">
											<h5 class="supplierResult pull-right">Payment Method:</h5>
										</div>
										<div class="col-sm-7">
											<select class="form-control" name="pMethod" id="pMethod">
												<option value="">Select Method</option>

												@foreach( $paymentMethods as $paymentMethod )
													<option value="{{ $paymentMethod->id }}">{{ $paymentMethod->description }}</option>
												@endforeach
												
											</select>
										</div>
									</div>

									<div class="row" style="margin-top: 10px;">
										<div class="col-sm-5 plr-0">
											<h5 class="supplierResult pull-right">Cheque Number:</h5>
										</div>
										<div class="col-sm-7">
											<input type="text" class="form-control" id="chequeNumber" name="chequeNumber" placeholder="Enter Cheque Number">
										</div>
									</div>

								</div>
							</div>
						</div>
						<div class="modal-footer">
							<input type="submit" class="btn btn-success" value="Pay">
							<button class="btn btn-default" type="button" data-dismiss="modal">Close</button>
						</div>
					</div>
					<!-- /.modal-content-->
				</form>
			</div>
			<!-- /.modal-dialog-->
		</div>
		<!--.modal-->
		<!-- Create a new office model -->
		@include('company.partials.create-new-office-modal')

	</section>
@endsection

	@section('script')
	<script src="{{asset('js/office-modal.js')}}"></script>

	<script type="text/javascript">
		function calculate()
		{
			var totalPaidAmount = Number('{{ $sale->total_paid_amount }}') + Number($('#payAmount').val());
			var remainingAmount = Number('{{ $sale->total_amount }}') - totalPaidAmount;
			$('#remainingAmount').html(remainingAmount); 
		}

		


	</script>

	<script type="text/javascript">
		$(document).ready(function() {

			// var field = $('.table > tbody');
			var field = $('#payTable');
			var countField = '{{ $i }}';
			var count = '{{ $i }}';

			$(document).on('focus',".date", function(){
			    $(this).datepicker({
				dateFormat: "yy-mm-dd",
				changeMonth: true,
				changeYear: true,
				});
			});

			$('#pay').on('click', function() {

				var totalAmount = Number('{{ $sale->total_amount }}');
				var totalPaidAmount = Number('{{ $sale->total_paid_amount }}');

				if( totalAmount > totalPaidAmount )
					$('#payModal').modal('show');
			});

			$('#totalAmount').html('{{ nepali_number_format($sale->total_amount) }}');
			$('#paidAmount').html('{{ nepali_number_format($sale->total_paid_amount) }}');

			var remainingAmount = '{{ $sale->total_unpaid_amount }}';

			if(remainingAmount != 0)
				$('#remainingAmount').html('{{ nepali_number_format($sale->total_unpaid_amount) }}');
			else
				$('#remainingAmount').html(0);


			
			$('#payForm').validate({
				rules: {
					payAmount: {
						required: true,
						maxlength: 10
					},

					pMethod: {
						required: true,
						maxlength: 10
					} 
				},

				messages: {
					payAmount: {
						required:"Please enter some data",
						maxlength:"Max"
					},

					pMethod: {
						required:"Please select one option",
						maxlength:"Max"
					}
				}
			});

			$('.add_fields').on('click', function(e){
				e.preventDefault();

				count++;
				countField++;

				$(field).append('<tr><td class="pl-20"><h5>' + countField +'<sup>th</sup> Installment</h5></td><td><input type="text" class="form-control" name="iPaidAmount[]" placeholder="Paid Amount" value=""></td><td><select class="form-control" name="iPaymentMethod[]"><option value="">Select Payment Method</option>@foreach($paymentMethods as $paymentMethod)<option value="{{ $paymentMethod->id}}">{{ $paymentMethod->description }}</option>@endforeach</select></td><td><input type="text" class="form-control" name="iChequeNumber[]" placeholder="Cheque Number" value=""></td><td><input type="text" class="form-control date" name="date[]" placeholder="Date" value="{{ date("Y-m-d") }}"></td><td><a href="#" class="link delete" title="Delete"><i class="fa fa-trash-o"></i></a></td></tr>');

				$('#count').val(count);

			});

			$(field).on('click', '.delete', function(e){
				e.preventDefault();
				$(this).parent().closest('tr').remove();

				count--;
				$('#count').val(count);
			});

			@if(empty(old('count')))
			$('#count').val(count);
			@else 
			$('#count').val('{{ old('count') }}');
			@endif

		});
	</script>

	@endsection
@extends('layouts.layouts')
@section('title', 'Ultrabyte | Purchase Pay')

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
					@if( !empty($editPurchase) )
					<h3 class="box-title">Edit Purchase Payment</h3>
					@else
					<h3 class="box-title">Purchase Payment</h3>
					<a href="{{ url('/pay-purchase/edit/'.$purchase->id) }}">
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
										<label class="control-label">Purchase Code:</label>
									</div>

									<div class="col-md-9">
										<h5>{{ $purchase->purchase_code }}</h5>
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
											<h5>{{ $purchase->date }}</h5>
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
										<label class="control-label">Shop Name:</label>
									</div>

									<div class="col-md-9">

										<?php	
										if(!empty($purchase->id))
										{
												echo '<h5>'. $purchase->shop->name .'</h5>';
										}
										?>

									</div>
								</div>
							</div>
						</div>

						<table class="table table-responsive-sm table-bordered" style="margin-bottom: 35px;">
							<thead>
								<tr>
									<th width="30%">Items</th>
									<th width="17%">Quantity</th>
									<th width="17%">Unit</th>
									<th width="17%">Rate</th>
									<th width="19%">Price</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td class="pl-20">
										<?php	
										if(!empty($purchase->id))
										{
												echo '<h5>'. $purchase->purchaseTransactionItem[0]->items .'</h5>';
										}
										?>

										<!-- /.input group -->
									</td>

									<td>
										<?php
											if(!empty($purchase->id))
											{
												echo '<h5>'. $purchase->purchaseTransactionItem[0]->quantity .'</h5>';
											}
										?>
									</td>

									<td>
										<?php
											if(!empty($purchase->id))
											{
												echo '<h5>'. $purchase->purchaseTransactionItem[0]->unit .'</h5>';
											}
										?>
									</td>

									<td>
										<?php
											if(!empty($purchase->id))
											{
												echo '<h5>'. $purchase->purchaseTransactionItem[0]->rate .'</h5>';
											}
										?>
									</td>

									<td class="pl-20">
										<h5>{{ !empty($purchase->id)? $purchase->purchaseTransactionItem[0]->total_price : old('price.0') }}</h5>
									</td>
								</tr>

								<?php $count = !empty($purchase->id)? $purchase->purchaseTransactionItem->count()-1 : old('count'); ?>

								@if(!empty($count))
								@for( $i = 1; $i <= $count; $i++ )
								<tr>
									<td class="pl-20">
										<?php	
										if(!empty($purchase->id))
										{
												echo '<h5>'. $purchase->purchaseTransactionItem[$i]->items .'</h5>';
										}
										?>

										<!-- /.input group -->
									</td>

									<td>
										<?php
											if(!empty($purchase->id))
											{
												echo '<h5>'. $purchase->purchaseTransactionItem[$i]->quantity .'</h5>';
											}
										?>
									</td>

									<td>
										<?php
											if(!empty($purchase->id))
											{
												echo '<h5>'. $purchase->purchaseTransactionItem[$i]->unit .'</h5>';
											}
										?>
									</td>

									<td>
										<?php
											if(!empty($purchase->id))
											{
												echo '<h5>'. $purchase->purchaseTransactionItem[$i]->rate .'</h5>';
											}
										?>
									</td>

									<td class="pl-20">
										<h5>{{ !empty($purchase->id)? $purchase->purchaseTransactionItem[$i]->total_price : old('price.0') }}</h5>
									</td>
								</tr>
								@endfor
								@endif


							</tbody>
						</table>
						<form method="post" action="{{ url('/pay-purchase/edit') }}">
							{{ csrf_field() }}
							<div class="row" <?php if(!$errors->has('shopName')) echo 'style="margin-bottom: 18px;"' ?>>
								<div class="col-md-3 lr_padding_0">
									<div class="col-md-6 control-label lr_padding_0" style="width: 50%">
										<label class="pull-right">Total Amount:</label>
									</div>
									<div class="col-md-6">
										<h5 class="pull-left" id="total_amount_label">{{ !empty($purchase->total_amount)? $purchase->total_amount : old('totalAmount') }}</h5>

										<input type="hidden" id="total_amount_input" name="totalAmount" value="{{ !empty($purchase->total_amount)? $purchase->total_amount : old('totalAmount') }}">
									</div>

									<div class="col-md-6 control-label lr_padding_0" style="width: 50%">
										<label class="pull-right">Total Paid Amount:</label>
									</div>
									<div class="col-md-6">
										<h5 class="pull-left" id="total_amount_label">{{ !empty($purchase->total_paid_amount)? $purchase->total_paid_amount : old('totalAmount') }}</h5>

										<input type="hidden" id="total_amount_input" name="totalAmount" value="{{ !empty($purchase->total_amount)? $purchase->total_amount : old('totalAmount') }}">
									</div>

									<div class="col-md-6 control-label lr_padding_0" style="width: 50%">
										<label class="pull-right">Remaining Amount:</label>
									</div>
									<div class="col-md-6">
										<h5 class="pull-left" id="total_amount_label">{{ !empty($purchase->total_unpaid_amount)? $purchase->total_unpaid_amount : old('totalAmount') }}</h5>

										<input type="hidden" id="total_amount_input" name="totalAmount" value="{{ !empty($purchase->total_amount)? $purchase->total_amount : old('totalAmount') }}">
									</div>


								</div>

								<div class="col-md-9">
									@if( !empty($editPurchase) )
									<button class="btn btn-success pull-right add_fields" title="Add Fields">Add Fields</button>
									@endif		

									<input type="hidden" name="count" id="count" value="{{ !empty(old('count'))? old('count') : '' }}">	

									<input type="hidden" name="purchaseId" value="{{ !empty($purchase->id)? $purchase->id : old('purchaseId') }}">							

									<table class="table table-responsive-sm table-bordered" id="payTable" style="margin-bottom: 35px;">
										<thead>
											<tr>
												<th width="30%" class="pl-20">Installment</th>
												<th width="37%" class="pl-20">Paid Amount</th>
												<th width="30%" class="pl-20">Payment Method</th>
												<th width="3%"></th>
											</tr>
										</thead>
										<tbody>

											<?php 
													// dd(old('iPaymentMethod.8'));
											if(!empty(old('count')))
												$count = old('count');
											else 
												$count = $purchase->purchaseInstallmentPayment->count();
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
														if(!empty($purchase->purchaseInstallmentPayment[$i]->paid_amount))
														{
															echo $purchase->purchaseInstallmentPayment[$i]->paid_amount;
														}
														else
														echo '';

													}
													?>" {{ empty($editPurchase)? 'disabled' : '' }} >
												</td>

												<td>
													<select class="form-control" name="iPaymentMethod[]" {{ empty($editPurchase)? 'disabled' : '' }}>
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
															if(!empty($purchase->purchaseInstallmentPayment[$i]->payment_method))
															{
																if($purchase->purchaseInstallmentPayment[$i]->payment_method==$paymentMethod->id)
																	echo "selected";
															}
															else
																echo '';
														}

														?>>{{ $paymentMethod->description }}</option>
														@endforeach

													</select>
												</td>

												@if( !empty($editPurchase) )
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


									@if( !empty($editPurchase) )
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

							@if( empty($editPurchase) )
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
				<form method="post" id="payForm" action="{{ url('/purchase-pay-processing') }}">
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
											<input type="hidden" name="purchaseId" value="{{ $purchase->id }}">

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

								<div class="col-md-6">
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
			var totalPaidAmount = Number('{{ $purchase->total_paid_amount }}') + Number($('#payAmount').val());
			var remainingAmount = Number('{{ $purchase->total_amount }}') - totalPaidAmount;
			$('#remainingAmount').html(remainingAmount); 
		}

		


	</script>

	<script type="text/javascript">
		$(document).ready(function() {

			// var field = $('.table > tbody');
			var field = $('#payTable');
			var countField = '{{ $i }}';
			var count = '{{ $i }}';

			$('#pay').on('click', function() {

				var totalAmount = Number('{{ $purchase->total_amount }}');
				var totalPaidAmount = Number('{{ $purchase->total_paid_amount }}');

				if( totalAmount > totalPaidAmount )
					$('#payModal').modal('show');
			});

			$('#totalAmount').html('{{ $purchase->total_amount }}');
			$('#paidAmount').html('{{ $purchase->total_paid_amount }}');

			var remainingAmount = '{{ $purchase->total_unpaid_amount }}';

			if(remainingAmount != 0)
				$('#remainingAmount').html(remainingAmount);
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

				$(field).append('<tr><td class="pl-20"><h5>' + countField +'<sup>th</sup> Installment</h5></td><td><input type="text" class="form-control" name="iPaidAmount[]" placeholder="Paid Amount" value=""></td><td><select class="form-control" name="iPaymentMethod[]"><option value="">Select Payment Method</option>@foreach( $paymentMethods as $paymentMethod )<option value="{{ $paymentMethod->id }}">{{ $paymentMethod->description }}</option>@endforeach</select></td><td><a href="#" class="link delete" title="Delete"><i class="fa fa-trash-o"></i></a></td></tr>');

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
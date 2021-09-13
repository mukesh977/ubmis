@extends('layouts.layouts')
@section('title', 'Ultrabyte | List Notifications')

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

	<div class="box box-primary">
		@if( $rPT->r_operation == "editPurchase" )
			<div class="box-header">
				<h3 class="box-title" class="box-title">Edit Purchase Transaction</h3>
			</div>
		@endif

		@if( $rPT->r_operation == "deletePurchase" )
			<div class="box-header">
				<h3 class="box-title">Delete Purchase Transaction</h3>
			</div>
		@endif

	</div>

	<div class="row">
		<div class="col-md-12">
			<div class="box">
				<div class="box-header with-border">
					<h3 class="box-title">Wrong Purchase Transaction</h3>

				</div>
				<div class="box-body">
					<div class="form-horizontal">
						<div class="row sales_pay_table">
							<div class="col-md-6">
								<div class="row">
									<div class="form-group col-md-3 right_align">
										<label class="control-label">Puchase Code:</label>
									</div>

									<div class="col-md-9">
										<h5>{{ $pT->purchase_code }}</h5>
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
											<h5>{{ $pT->date }}</h5>
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
										if(!empty($pT->id))
										{
											echo '<h5>'. $pT->shop_id .'</h5>';
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
										<h5>{{ !empty($pT->purchaseTransactionItem[0]->items)? $pT->purchaseTransactionItem[0]->items : '' }}</h5>
									</td>

									<td class="pl-20">

										<?php	
										if(!empty($pT->id))
										{
												echo '<h5>'. !empty($pT->purchaseTransactionItem[0]->quantity)? $pT->purchaseTransactionItem[0]->quantity : '' .'</h5>';
										}
										?>

										<!-- /.input group -->
									</td>

									<td class="pl-20">
										<h5>{{ !empty($pT->purchaseTransactionItem[0]->unit)? $pT->purchaseTransactionItem[0]->unit : '' }}</h5>
									</td>

									<td class="pl-20">
										<h5>{{ !empty($pT->id)? $pT->purchaseTransactionItem[0]->rate : '' }}</h5>
									</td>

									<td class="pl-20">
										<h5>{{ !empty($pT->purchaseTransactionItem[0]->total_price)? $pT->purchaseTransactionItem[0]->total_price : '' }}</h5>
									</td>
									
								</tr>

								<?php $count = !empty($pT->id)? $pT->purchaseTransactionItem->count()-1 : old('count'); ?>

								@if(!empty($count))
								@for( $i = 1; $i <= $count; $i++ )
								<tr>
									<td class="pl-20">
										<h5>{{ !empty($pT->purchaseTransactionItem[$i]->items)? $pT->purchaseTransactionItem[$i]->items : '' }}</h5>
									</td>

									<td class="pl-20">

										<?php	
										if(!empty($pT->id))
										{
												echo '<h5>'. !empty($pT->purchaseTransactionItem[$i]->quantity)? $pT->purchaseTransactionItem[$i]->quantity : '' .'</h5>';
										}
										?>

										<!-- /.input group -->
									</td>

									<td class="pl-20">
										<h5>{{ !empty($pT->purchaseTransactionItem[$i]->unit)? $pT->purchaseTransactionItem[$i]->unit : '' }}</h5>
									</td>

									<td class="pl-20">
										<h5>{{ !empty($pT->purchaseTransactionItem[$i]->rate)? $pT->purchaseTransactionItem[$i]->rate : '' }}</h5>
									</td>

									<td class="pl-20">
										<h5>{{ !empty($pT->purchaseTransactionItem[$i]->total_price)? $pT->purchaseTransactionItem[$i]->total_price : '' }}</h5>
									</td>
									
								</tr>
								@endfor
								@endif


							</tbody>
						</table>
						<div class="row" <?php if(!$errors->has('shopName')) echo 'style="margin-bottom: 18px;"' ?>>
							<div class="col-md-3 lr_padding_0">
								<div class="col-md-6 control-label lr_padding_0" style="width: 50%">
									<label class="pull-right">Total Amount:</label>
								</div>
								<div class="col-md-6">
									<h5 class="pull-left" id="total_amount_label">{{ !empty($pT->total_amount)? $pT->total_amount : old('totalAmount') }}</h5>

									<input type="hidden" id="total_amount_input" name="totalAmount" value="{{ !empty($pT->total_amount)? $pT->total_amount : old('totalAmount') }}">
								</div>

								<div class="col-md-6 control-label lr_padding_0" style="width: 50%">
									<label class="pull-right">Total Paid Amount:</label>
								</div>
								<div class="col-md-6">
									<h5 class="pull-left" id="total_amount_label">{{ !empty($pT->total_paid_amount)? $pT->total_paid_amount : old('totalAmount') }}</h5>
								</div>

								<div class="col-md-6 control-label lr_padding_0" style="width: 50%">
									<label class="pull-right">Remaining Amount:</label>
								</div>
								<div class="col-md-6">
									<h5 class="pull-left" id="total_amount_label">{{ !empty($pT->total_unpaid_amount)? $pT->total_unpaid_amount : old('totalAmount') }}</h5>
								</div>


							</div>

							<div class="col-md-9">
								<input type="hidden" name="count" id="count" value="{{ !empty(old('count'))? old('count') : '' }}">	

								<input type="hidden" name="saleId" value="{{ !empty($pT->id)? $pT->id : old('purchaseId') }}">							

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
											$count = $pT->purchaseInstallmentPayment->count();
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
													if(!empty($pT->purchaseInstallmentPayment[$i]->paid_amount))
													{
														echo $pT->purchaseInstallmentPayment[$i]->paid_amount;
													}
													else
													echo '';

												}
												?>" {{ empty($editPurchase)? 'disabled' : '' }} >
											</td>

											<td>
												<select class="form-control" name="iPaymentMethod[]" {{ empty($editPurchase)? 'disabled' : '' }}>
													<option value="">Select Payment Method</option>

													@foreach( $paymentMethods as $paymentMethod )
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
														if(!empty($pT->purchaseInstallmentPayment[$i]->payment_method))
														{
															if($pT->purchaseInstallmentPayment[$i]->payment_method==$paymentMethod->id)
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
											</td>

										</tr>
										@endfor

									</tbody>
								</table>
								
							</div>
						</div>
						
					</div>

				</div>
				<!-- /.box-body -->
			</div>
			<!-- /.box -->
		</div>
		<!-- /.col (right) -->
	</section>

	@if( $rPT->r_operation != "deletePurchase" )
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
				<div class="box">
					<div class="box-header with-border">
						@if( !empty($rPT->r_purchase_code) )
						<h3 class="box-title">Corrected Purchase Transaction</h3>
						@else
						<h3 class="box-title">Corrected Purchase Transaction</h3>
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
											<h5>{{ $rPT->r_purchase_code }}</h5>
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
												<h5>{{ $rPT->r_date }}</h5>
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
											if(!empty($rPT->id))
											{
												echo '<h5>'. $rPT->r_shop_id .'</h5>';
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
											<h5>{{ !empty($rPT->requestedSalesTransactionItem[0]->r_items)? $rPT->requestedSalesTransactionItem[0]->r_items : '' }}</h5>
										</td>

										<td class="pl-20">

											<?php	
											if(!empty($rPT->id))
											{
													echo '<h5>'. !empty($rPT->requestedSalesTransactionItem[0]->r_quantity)? $rPT->requestedSalesTransactionItem[0]->r_quantity : '' .'</h5>';
											}
											?>

											<!-- /.input group -->
										</td>

										<td class="pl-20">
											<h5>{{ !empty($rPT->requestedSalesTransactionItem[0]->r_unit)? $rPT->requestedSalesTransactionItem[0]->r_unit : '' }}</h5>
										</td>

										<td class="pl-20">
											<h5>{{ !empty($rPT->id)? $rPT->requestedSalesTransactionItem[0]->r_rate : '' }}</h5>
										</td>

										<td class="pl-20">
											<h5>{{ !empty($rPT->id)? $rPT->requestedSalesTransactionItem[0]->r_total_price : '' }}</h5>
										</td>
									</tr>

										<?php $count = !empty($rPT->id)? $rPT->requestedSalesTransactionItem->count()-1 : old('count'); ?>

										@if(!empty($count))
										@for( $i = 1; $i <= $count; $i++ )
										<tr>
											<td class="pl-20">
											<h5>{{ !empty($rPT->requestedSalesTransactionItem[$i]->r_items)? $rPT->requestedSalesTransactionItem[$i]->r_items : '' }}</h5>
										</td>

										<td class="pl-20">

											<?php	
											if(!empty($rPT->id))
											{
													echo '<h5>'. !empty($rPT->requestedSalesTransactionItem[$i]->r_quantity)? $rPT->requestedSalesTransactionItem[$i]->r_quantity : '' .'</h5>';
											}
											?>

											<!-- /.input group -->
										</td>

										<td class="pl-20">
											<h5>{{ !empty($rPT->requestedSalesTransactionItem[$i]->r_unit)? $rPT->requestedSalesTransactionItem[$i]->r_unit : '' }}</h5>
										</td>

										<td class="pl-20">
											<h5>{{ !empty($rPT->id)? $rPT->requestedSalesTransactionItem[$i]->r_rate : '' }}</h5>
										</td>

										<td class="pl-20">
											<h5>{{ !empty($rPT->id)? $rPT->requestedSalesTransactionItem[$i]->r_total_price : '' }}</h5>
										</td>

									</tr>
									@endfor
									@endif


								</tbody>
							</table>
							<div class="row" <?php if(!$errors->has('shppName')) echo 'style="margin-bottom: 18px;"' ?>>
								<div class="col-md-3 lr_padding_0">
									<div class="col-md-6 control-label lr_padding_0" style="width: 50%">
										<label class="pull-right">Total Amount:</label>
									</div>
									<div class="col-md-6">
										<h5 class="pull-left" id="total_amount_label">{{ !empty($rPT->r_total_amount)? $rPT->r_total_amount : old('totalAmount') }}</h5>

										<input type="hidden" id="total_amount_input" name="totalAmount" value="{{ !empty($rPT->r_total_amount)? $rPT->r_total_amount : old('totalAmount') }}">
									</div>

									<div class="col-md-6 control-label lr_padding_0" style="width: 50%">
										<label class="pull-right">Total Paid Amount:</label>
									</div>
									<div class="col-md-6">
										<h5 class="pull-left" id="total_amount_label">{{ !empty($rPT->r_total_paid_amount)? $rPT->r_total_paid_amount : old('totalAmount') }}</h5>
									</div>

									<div class="col-md-6 control-label lr_padding_0" style="width: 50%">
										<label class="pull-right">Remaining Amount:</label>
									</div>
									<div class="col-md-6">
										<h5 class="pull-left" id="total_amount_label">{{ !empty($rPT->r_total_unpaid_amount)? $rPT->r_total_unpaid_amount : old('totalAmount') }}</h5>
									</div>


								</div>

								<div class="col-md-9">
									<input type="hidden" name="count" id="count" value="{{ !empty(old('count'))? old('count') : '' }}">	

									<input type="hidden" name="saleId" value="{{ !empty($rPT->id)? $rPT->id : old('purchaseId') }}">							

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
												$count = $rPT->requestedSalesInstallmentPayment->count();
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
														if(!empty($rPT->requestedSalesInstallmentPayment[$i]->r_paid_amount))
														{
															echo $rPT->requestedSalesInstallmentPayment[$i]->r_paid_amount;
														}
														else
														echo '';

													}
													?>" {{ empty($editPurchase)? 'disabled' : '' }} >
												</td>

												<td>
													<select class="form-control" name="iPaymentMethod[]" {{ empty($editPurchase)? 'disabled' : '' }}>
														<option value="">Select Payment Method</option>

														@foreach( $paymentMethods as $paymentMethod )
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
															if(!empty($rPT->requestedSalesInstallmentPayment[$i]->r_payment_method))
															{
																if($rPT->requestedSalesInstallmentPayment[$i]->r_payment_method==$paymentMethod->id)
																	echo "selected";
															}
															else
																echo '';
														}

														?>>{{ $paymentMethod->description }}</option>
														@endforeach

														<option value="cash" <?php 
														if(!empty(old('count')))
														{
															if(old('iPaymentMethod.'.$i)=="cash")
																echo "selected";
															else
																echo "";

														}
														else
														{
															if(!empty($rPT->requestedSalesInstallmentPayment[$i]->r_payment_method))
															{
																if($rPT->requestedSalesInstallmentPayment[$i]->r_payment_method=="cash")
																	echo "selected";
															}
															else
																echo '';
														}

														?>>Cash</option>

														<option value="cheque" <?php 
														if(!empty(old('count')))
														{
															if(old('iPaymentMethod.'.$i)=="cheque")
																echo "selected";
															else
																echo '';
														}
														else
														{
															if(!empty($rPT->requestedSalesInstallmentPayment[$i]->r_payment_method))
															{
																if($rPT->requestedSalesInstallmentPayment[$i]->r_payment_method=="cheque")
																	echo "selected";
															}
															else
																echo '';
														}

														?>>Cheque</option>
													</select>
												</td>

												<td>
												</td>

											</tr>
											@endfor

										</tbody>
									</table>
									
								</div>
							</div>
							
						</div>
					</div>
				</div>
				<!-- /.box-body -->
			</div>
			<!-- /.box -->
		</div>
		<!-- /.col (right) -->
	</section>
		@endif

	<section class="content" style="min-height: 6px!important; padding-top: 0px;">
	<div class="box">
		<div class="box-header">
			<form method="post" action="{{ url('admin/request/purchasechange/'.$rPT->id) }}">
				{{ csrf_field() }}
				<input type="hidden" name="salesTransactionId">
				<input type="hidden" name="requestedSalesTransactionId">

				<a href="{{ url('/admin/request/nochange/'.$rPT->id) }}" class="btn btn-danger pull-right">Deny Changes</a>

				<input type="submit" class="btn btn-success pull-right" style="margin-right: 10px;" value="Allow Changes">
			</form>
		</div>
	</div>
</section>


@endsection

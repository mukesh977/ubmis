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
		@if( $rST->r_operation == "edit" )
			<div class="box-header">
				<h3 class="box-title" class="box-title">Edit Sales Transaction</h3>
			</div>
		@endif

		@if( $rST->r_operation == "delete" )
			<div class="box-header">
				<h3 class="box-title">Delete Sales Transaction</h3>
			</div>
		@endif

	</div>

	<div class="row">
		<div class="col-md-12">
			<div class="box">
				<div class="box-header with-border">
					@if( !empty($rST->r_sales_code) )
					<h3 class="box-title">Wrong Sales Transaction</h3>
					@else
					<h3 class="box-title">Wrong Purchase Transaction</h3>
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
										<h5 class="{{ ( ($sT->sales_code) != ($rST->r_sales_code) )? 'red' : '' }}">{{ $sT->sales_code }}</h5>
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
											<h5 class="{{ ( ($sT->date) != ($rST->r_date) )? 'red' : '' }}">{{ $sT->date }}</h5>
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
										if(!empty($sT->id))
										{
											if( ($sT->company_id)==($company->id) )
											{
												if( $sT->company_id != $rST->r_company_id )
													echo '<h5 class="red">'. $company->name .'</h5>';
												else
													echo '<h5>'. $company->name .'</h5>';
											}
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
									<th width="35%" class="pl-20">Services</th>
									<th width="20%" class="pl-20">Price</th>
									<th width="15%" class="pl-20">Information</th>
									<th width="15%" class="pl-20">Start Date</th>
									<th width="15%" class="pl-20">End Date</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td class="pl-20">
										@foreach( $services as $service )

										<?php	
										if(!empty($sT->id))
										{
											if($sT->salesTransactionsItem[0]->service_id==$service->id )
											{
												if( $sT->salesTransactionsItem[0]->service_id != $rST->requestedSalesTransactionItem[0]->r_service_id )
													echo '<h5 class="red">'. $service->name .'</h5>';
												else
													echo '<h5>'. $service->name .'</h5>';

											}
										}
										?>

										@endforeach

										<!-- /.input group -->
									</td>

									<td class="pl-20">
										<h5 class="{{ ( ($sT->salesTransactionsItem[0]->total_price) != ($rST->requestedSalesTransactionItem[0]->r_total_price) )? 'red' : '' }}">{{ !empty($sT->id)? $sT->salesTransactionsItem[0]->total_price : '' }}</h5>
									</td>

									<td class="pl-20">
										<?php 
											if( !empty($sT->id) )
											{
												if($sT->salesTransactionsItem[0]->service_id== 2)
												{
													foreach( $seoPackages as $seoPackage )
													{
														if( $seoPackage->slug == $sT->salesTransactionsItem[0]->information )
														{
															if( $sT->salesTransactionsItem[0]->information != $rST->requestedSalesTransactionItem[0]->r_information )
																echo '<h5 class="red">'. $seoPackage->name . '</h5>';
															else
																echo '<h5>'. $seoPackage->name . '</h5>';
														}
													}

												}
												else if($sT->salesTransactionsItem[0]->service_id== 10)
												{
													foreach( $amcPackages as $amcPackage )
													{
														if( $amcPackage->slug == $sT->salesTransactionsItem[0]->information )
														{
															if( $sT->salesTransactionsItem[0]->information != $rST->requestedSalesTransactionItem[0]->r_information )
																echo '<h5 class="red">'. $amcPackage->name . '</h5>';
															else
																echo '<h5>'. $amcPackage->name . '</h5>';
														}
													}
												}
												else
												{
													if( $sT->salesTransactionsItem[0]->information != $rST->requestedSalesTransactionItem[0]->r_information )
														echo '<h5 class="red">'. $sT->salesTransactionsItem[0]->information . '</h5>';
													else
														echo '<h5>'. $sT->salesTransactionsItem[0]->information . '</h5>';
												}


											} 
										?>
									</td>

									<td class="pl-20">
										<h5 class="{{ ( ($sT->salesTransactionsItem[0]->start_date) != ($rST->requestedSalesTransactionItem[0]->r_start_date) )? 'red' : '' }}">{{ !empty($sT->id)? $sT->salesTransactionsItem[0]->start_date : '' }}</h5>
									</td>

									<td class="pl-20">
										<h5 class="{{ ( ($sT->salesTransactionsItem[0]->end_date) != ($rST->requestedSalesTransactionItem[0]->r_end_date) )? 'red' : '' }}">{{ !empty($sT->id)? $sT->salesTransactionsItem[0]->end_date : old('endDate.0') }}</h5>
									</td>

								</tr>

								<?php 
									$count = !empty($sT->id)? $sT->salesTransactionsItem->count()-1 : old('count'); 
									$countST = $sT->salesTransactionsItem->count(); 
									$countRST = $rST->requestedSalesTransactionItem->count();
									$lowestCount = ($countST > $countRST)? $countRST : $countST; 
								?>

								@if(!empty($count))
								@for( $i = 1; $i <= $count; $i++ )
								@if( ($i+1) <= $lowestCount )
								
								<tr>
									<td class="pl-20">
										@foreach( $services as $service )

										<?php	
										if(!empty($sT->id))
										{
											if(($sT->salesTransactionsItem[$i]->service_id)==($service->id) )
											{
												if( $sT->salesTransactionItem[$i]->service_id != $rST->requestedSalesTransactionItem[$i]->r_service_id)
													echo '<h5 class="red">'. $service->name .'</h5>';
												else
													echo '<h5>'. $service->name .'</h5>';

											}
										}

										?>

										@endforeach


									</td>

									<td class="pl-20">

										<h5 class="{{ ($sT->salesTransactionsItem[$i]->total_price == $rST->requestedSalesTransactionItem[$i]->r_total_price)? 'red' : '' }}">{{ !empty($sT->id)? $sT->salesTransactionsItem[$i]->total_price : old('price.'.$i) }}</h5>

									</td>

									<td class="pl-20">
										<?php 
											$colour = '';

											if( $sT->salesTransactionsItem[$i]->information != $rST->requestedSalesTransactionItem[$i]->r_information )
											{
												$colour = "red";
											}

											if( !empty($sT->id) )
											{
												if($sT->salesTransactionsItem[$i]->service_id== 2)
												{
													foreach( $seoPackages as $seoPackage )
													{
														if( $seoPackage->slug == $sT->salesTransactionsItem[$i]->information )
														{
															if( $colour == 'red' )
																echo '<h5 class="red">'. $seoPackage->name .'</h5>';
															else
																echo '<h5>'. $seoPackage->name .'</h5>';
														}
													}

												}
												else if($sT->salesTransactionsItem[$i]->service_id== 10)
												{
													foreach( $amcPackages as $amcPackage )
													{
														if( $amcPackage->slug == $sT->salesTransactionsItem[$i]->information )
														{
															if( $colour == 'red' )
																echo '<h5 class="red">'. $amcPackage->name . '</h5>';
															else
																echo '<h5>'. $amcPackage->name . '</h5>';
														}
													}
												}
												else
												{
													if( $colour == 'red' )
														echo '<h5 class="red">'. $sT->salesTransactionsItem[$i]->information . '</h5>';
													else
														echo '<h5>'. $sT->salesTransactionsItem[$i]->information . '</h5>';
												}


											} 
										?>
									</td>

									<td class="pl-20">
										<h5 class="{{ ($sT->salesTransactionsItem[$i]->start_date == $rST->requestedSalesTransactionItem[$i]->r_start_date)? 'red' : '' }}">{{ !empty($sT->id)? $sT->salesTransactionsItem[$i]->start_date : '' }}</h5>
									</td>

									<td class="pl-20">
										<h5 class="{{ ($sT->salesTransactionsItem[$i]->end_date == $rST->requestedSalesTransactionItem[$i]->r_end_date)? 'red' : '' }}">{{ !empty($sT->id)? $sT->salesTransactionsItem[$i]->end_date : old('endDate.'.$i) }}</h5>
									</td>

								</tr>
								@else
									<tr>
										<td class="pl-20">
											@foreach( $services as $service )

											<?php	
											if(!empty($sT->id))
											{
												if(($sT->salesTransactionsItem[$i]->service_id)==($service->id) )
												{
													echo '<h5 class="red">'. $service->name .'</h5>';
												}
											}

											?>

											@endforeach


										</td>

										<td class="pl-20">

											<h5 class="red">{{ !empty($sT->id)? $sT->salesTransactionsItem[$i]->total_price : old('price.'.$i) }}</h5>

										</td>

										<td class="pl-20">
											<?php 
												if( !empty($sT->id) )
												{
													if($sT->salesTransactionsItem[$i]->service_id== 2)
													{
														foreach( $seoPackages as $seoPackage )
														{
															if( $seoPackage->slug == $sT->salesTransactionsItem[$i]->information )
															{
																echo '<h5 class="red">'. $seoPackage->name .'</h5>';
															}
														}

													}
													else if($sT->salesTransactionsItem[$i]->service_id== 10)
													{
														foreach( $amcPackages as $amcPackage )
														{
															if( $amcPackage->slug == $sT->salesTransactionsItem[$i]->information )
															{
																echo '<h5 class="red">'. $amcPackage->name . '</h5>';
															}
														}
													}
													else
													{
														echo '<h5 class="red">'. $sT->salesTransactionsItem[$i]->information . '</h5>';
													}


												} 
											?>
										</td>

										<td class="pl-20">
											<h5 class="red">{{ !empty($sT->id)? $sT->salesTransactionsItem[$i]->start_date : '' }}</h5>
										</td>

										<td class="pl-20">
											<h5 class="red">{{ !empty($sT->id)? $sT->salesTransactionsItem[$i]->end_date : old('endDate.'.$i) }}</h5>
										</td>

									</tr>
								@endif
								@endfor
								@endif


							</tbody>
						</table>

						<?php 
							$countFbDetail = !empty($sT->id)? $sT->salesTransactionsItemFb->count() : '0' ; 
							$countRequestedFbDetail = !empty($rST->id)? $rST->requestedSTItemFb->count() : '0'; 
							$lowestCount = ($countFbDetail > $countRequestedFbDetail)? $countRequestedFbDetail : $countFbDetail; 
						?>

						@if( $countFbDetail > 0 )
							<h5><b>Facebook Details</b></h5>
								<table class="table table-responsive-sm table-bordered" style="margin-bottom: 35px;">
									<thead>
										<tr>
											<th width="38%">Particulars</th>
											<th width="21%">Dollar</th>
											<th width="21%">Graphics</th><th width="20%">Total</th>
										</tr>
									</thead>
									<tbody>
										
										@for( $i = 0; $i < $countFbDetail; $i++ )
											@if( ($i+1) <= $lowestCount )
												<tr>
													<td>
														<h5 class="{{ ($sT->salesTransactionsItemFb[$i]->particulars != $rST->requestedSTItemFb[$i]->particulars)? 'red' : '' }}">{{ !empty($sT->id)? $sT->salesTransactionsItemFb[$i]->particulars : '' }}</h5>
													</td>

													<td>
														<h5 class="{{ ($sT->salesTransactionsItemFb[$i]->dollar != $rST->requestedSTItemFb[$i]->dollar)? 'red' : '' }}">{{ !empty($sT->id)? $sT->salesTransactionsItemFb[$i]->dollar : '' }}</h5>
													</td>

													<td>
														<h5 class="{{ ($sT->salesTransactionsItemFb[$i]->graphics != $rST->requestedSTItemFb[$i]->graphics)? 'red' : '' }}">{{ !empty($sT->id)? $sT->salesTransactionsItemFb[$i]->graphics : '' }}</h5>
													</td>

													<td>
														<h5 class="{{ ($sT->salesTransactionsItemFb[$i]->total != $rST->requestedSTItemFb[$i]->total)? 'red' : '' }}">{{ !empty($sT->id)? $sT->salesTransactionsItemFb[$i]->total : '' }}</h5>
													</td>
												</tr>
											@else
												<tr>
													<td>
														<h5 class="red">{{ !empty($sT->id)? $sT->salesTransactionsItemFb[$i]->particulars : '' }}</h5>
													</td>

													<td>
														<h5 class="red">{{ !empty($sT->id)? $sT->salesTransactionsItemFb[$i]->dollar : '' }}</h5>
													</td>

													<td>
														<h5 class="red">{{ !empty($sT->id)? $sT->salesTransactionsItemFb[$i]->graphics : '' }}</h5>
													</td>

													<td>
														<h5 class="red">{{ !empty($sT->id)? $sT->salesTransactionsItemFb[$i]->total : '' }}</h5>
													</td>
												</tr>
											@endif
										@endfor	
									</tbody>
							</table>
						@endif

						<div class="row" <?php if(!$errors->has('officeName')) echo 'style="margin-bottom: 18px;"' ?>>
							<div class="col-md-3 lr_padding_0">
								<div class="col-md-6 control-label lr_padding_0" style="width: 50%">
									<label class="pull-right">Total Amount:</label>
								</div>
								<div class="col-md-6">
									<h5 class="pull-left {{ ($sT->total_amount != $rST->r_total_amount)? 'red' : '' }}" id="total_amount_label">{{ !empty($sT->total_amount)? $sT->total_amount : '' }}</h5>

									<input type="hidden" id="total_amount_input" name="totalAmount" value="{{ !empty($sT->total_amount)? $sT->total_amount : old('totalAmount') }}">
								</div>

								<div class="col-md-6 control-label lr_padding_0" style="width: 50%">
									<label class="pull-right">Total Paid Amount:</label>
								</div>
								<div class="col-md-6">
									<h5 class="pull-left {{ ($sT->total_paid_amount != $rST->r_total_paid_amount)? 'red' : '' }}" id="total_amount_label">{{ !empty($sT->total_paid_amount)? $sT->total_paid_amount : '' }}</h5>
								</div>

								<div class="col-md-6 control-label lr_padding_0" style="width: 52%">
									<label class="pull-right">Remaining Amount:</label>
								</div>
								<div class="col-md-5">
									<h5 class="pull-left {{ ($sT->total_unpaid_amount != $rST->r_total_unpaid_amount)? 'red' : '' }}" id="total_amount_label">{{ !empty($sT->total_unpaid_amount)? $sT->total_unpaid_amount : '' }}</h5>
								</div>


							</div>

							<div class="col-md-9">
								<input type="hidden" name="count" id="count" value="{{ !empty(old('count'))? old('count') : '' }}">	

								<input type="hidden" name="saleId" value="{{ !empty($sT->id)? $sT->id : old('saleId') }}">							

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
											$count = $sT->SalesInstallmentPayment->count();

										$countST = $sT->salesInstallmentPayment->count(); 
										$countRST = $rST->requestedSalesInstallmentPayment->count();

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

											@if( ($i+1 <= $countST) && ($i+1 <= $countRST) )
												<td>
													<?php
														$colourPaidAmount = '';
														$colourPaymentMethod = '';
														$colourChequeNumber = '';
														$colourDate = '';

														if( $sT->salesInstallmentPayment[$i]->paid_amount != $rST->requestedSalesInstallmentPayment[$i]->r_paid_amount )
														{
															$colourPaidAmount = 'red';
														}

														if( $sT->salesInstallmentPayment[$i]->payment_method != $rST->requestedSalesInstallmentPayment[$i]->r_payment_method )
														{
															$colourPaymentMethod = 'red';
														}

														if( $sT->salesInstallmentPayment[$i]->cheque_number != $rST->requestedSalesInstallmentPayment[$i]->r_cheque_number )
														{
															$colourChequeNumber = 'red';
														}

														if( $sT->salesInstallmentPayment[$i]->date != $rST->requestedSalesInstallmentPayment[$i]->r_date )
														{
															$colourDate = 'red';
														}

													?>

													<input type="text" class="form-control {{ $colourPaidAmount }}" name="iPaidAmount[]" placeholder="Paid Amount" value="<?php 
																
														if(!empty($sT->SalesInstallmentPayment[$i]->paid_amount))
														{
															echo $sT->SalesInstallmentPayment[$i]->paid_amount;
														}
														else
															echo '';

													?>" {{ empty($editSale)? 'disabled' : '' }} >
												</td>

												<td>
													<select class="form-control {{ $colourPaymentMethod }}" name="iPaymentMethod[]" {{ empty($editSale)? 'disabled' : '' }}>
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
																if(!empty($sT->SalesInstallmentPayment[$i]->payment_method))
																{
																	if($sT->SalesInstallmentPayment[$i]->payment_method==$paymentMethod->id)
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

													@if(!empty($sT->SalesInstallmentPayment[$i]->cheque_number))

													<input type="text" class="form-control {{ $colourChequeNumber }}" name="iChequeNumber[]" placeholder="Cheque Number" value="<?php 
																									
														echo $sT->SalesInstallmentPayment[$i]->cheque_number;

													?>" disabled>

													@endif


												</td>

												<td>
													<input type="text" class="form-control {{ $colourDate }}" name="date[]" placeholder="Date" value="<?php
														
														if(!empty($sT->SalesInstallmentPayment[$i]->date))
														{
															echo $sT->SalesInstallmentPayment[$i]->date;
														}
														else
															echo '';
													?>" disabled>
												</td>

												<td>
												</td>
											@else

												<td>
													<input type="text" class="form-control red" name="iPaidAmount[]" placeholder="Paid Amount" value="<?php 
																
														if(!empty($sT->SalesInstallmentPayment[$i]->paid_amount))
														{
															echo $sT->SalesInstallmentPayment[$i]->paid_amount;
														}
														else
															echo '';

													?>" {{ empty($editSale)? 'disabled' : '' }} >
												</td>

												<td>
													<select class="form-control red" name="iPaymentMethod[]" {{ empty($editSale)? 'disabled' : '' }}>
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
																if(!empty($sT->SalesInstallmentPayment[$i]->payment_method))
																{
																	if($sT->SalesInstallmentPayment[$i]->payment_method==$paymentMethod->id)
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

													@if(!empty($sT->SalesInstallmentPayment[$i]->cheque_number))

													<input type="text" class="form-control red" name="iChequeNumber[]" placeholder="Cheque Number" value="<?php 
																									
														echo $sT->SalesInstallmentPayment[$i]->cheque_number;

													?>" disabled>

													@endif


												</td>

												<td>
													<input type="text" class="form-control red" name="date[]" placeholder="Date" value="<?php
														
														if(!empty($sT->SalesInstallmentPayment[$i]->date))
														{
															echo $sT->SalesInstallmentPayment[$i]->date;
														}
														else
															echo '';
													?>" disabled>
												</td>

												<td>
												</td>
											@endif
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

	@if( $rST->r_operation != "delete" )
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
						@if( !empty($rST->r_sales_code) )
						<h3 class="box-title">Corrected Sales Transaction</h3>
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
											<label class="control-label">Sales Code:</label>
										</div>

										<div class="col-md-9 {{ ( ($sT->sales_code) != ($rST->r_sales_code) )? 'red' : '' }}">
											<h5>{{ $rST->r_sales_code }}</h5>
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
												<h5 class="{{ ( ($sT->date) != ($rST->r_date) )? 'red' : '' }}">{{ $rST->r_date }}</h5>
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
											if(!empty($rST->id))
											{
												if( ($rST->r_company_id)==($company->id) )
												{
													if( $sT->company_id != $rST->r_company_id )
														echo '<h5 class="red">'. $company->name .'</h5>';
													else
														echo '<h5>'. $company->name .'</h5>';
												}
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
										<th width="35%" class="pl-20">Services</th>
										<th width="20%" class="pl-20">Price</th>
										<th width="15%" class="pl-20">Information</th>
										<th width="15%" class="pl-20">Start Date</th>
										<th width="15%" class="pl-20">End Date</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td class="pl-20">
											@foreach( $services as $service )

											<?php	
											if(!empty($rST->id))
											{
												if($rST->requestedSalesTransactionItem[0]->r_service_id==$service->id )
												{
													if( $sT->salesTransactionsItem[0]->service_id != $rST->requestedSalesTransactionItem[0]->r_service_id )
														echo '<h5 class="red">'. $service->name .'</h5>';
													else
														echo '<h5>'. $service->name .'</h5>';
												}
											}
											?>

											@endforeach

											<!-- /.input group -->
										</td>

										<td class="pl-20">
											<h5 class="{{ ( ($sT->salesTransactionsItem[0]->total_price) != ($rST->requestedSalesTransactionItem[0]->r_total_price) )? 'red' : '' }}">{{ !empty($rST->id)? $rST->requestedSalesTransactionItem[0]->r_total_price : old('price.0') }}</h5>
										</td>

										<td class="pl-20">
											<h5>
												<?php 
												if( !empty($rST->id) )
												{
													if($rST->requestedSalesTransactionItem[0]->r_service_id== 2)
													{
														foreach( $seoPackages as $seoPackage )
														{
															if( $seoPackage->slug == $rST->requestedSalesTransactionItem[0]->r_information )
															{
																if( $sT->salesTransactionsItem[0]->information != $rST->requestedSalesTransactionItem[0]->r_information )
																	echo '<h5 class="red">'. $seoPackage->name . '</h5>';
																else
																	echo '<h5>'. $seoPackage->name . '</h5>';
															}
														}

													}
													else if($rST->requestedSalesTransactionItem[0]->r_service_id== 10)
													{
														foreach( $amcPackages as $amcPackage )
														{
															if( $amcPackage->slug == $rST->requestedSalesTransactionItem[0]->r_information )
															{
																if( $sT->salesTransactionsItem[0]->information != $rST->requestedSalesTransactionItem[0]->r_information )
																	echo '<h5 class="red">'. $amcPackage->name . '</h5>';
																else
																	echo '<h5>'. $amcPackage->name . '</h5>';
															}
														}
													}
													else
													{
														if( $sT->salesTransactionsItem[0]->information != $rST->requestedSalesTransactionItem[0]->r_information )
															echo '<h5 class="red">'. $rST->requestedSalesTransactionItem[0]->r_information . '</h5>';
														else
															echo '<h5>'. $rST->requestedSalesTransactionItem[0]->r_information . '</h5>';
													}
												} 
											?>
											</h5>
										</td>

										<td class="pl-20">
											<h5 class="{{ ( ($sT->salesTransactionsItem[0]->start_date) != ($rST->requestedSalesTransactionItem[0]->r_start_date) )? 'red' : '' }}">{{ !empty($sT->id)? $rST->requestedSalesTransactionItem[0]->r_start_date : old('startDate.0') }}</h5>
										</td>

										<td class="pl-20">
											<h5 class="{{ ( ($sT->salesTransactionsItem[0]->end_date) != ($rST->requestedSalesTransactionItem[0]->r_end_date) )? 'red' : '' }}">{{ !empty($sT->id)? $rST->requestedSalesTransactionItem[0]->r_end_date : old('endDate.0') }}</h5>
										</td>
									</tr>

									<?php 
										$count = !empty($rST->id)? $rST->requestedSalesTransactionItem->count()-1 : old('count'); 
										$countST = $sT->salesTransactionsItem->count(); 
										$countRST = $rST->requestedSalesTransactionItem->count();
										$lowestCount = ($countST > $countRST)? $countRST : $countST; 
									?>

									@if(!empty($count))
									@for( $i = 1; $i <= $count; $i++ )
									@if( ($i+1) <= $lowestCount )
									<tr>
										<td class="pl-20">
											@foreach( $services as $service )

											<?php	
											if(!empty($rST->id))
											{
												if(($rST->requestedSalesTransactionItem[$i]->r_service_id)==($service->id) )
												{
													if( $sT->salesTransactionItem[$i]->service_id != $rST->requestedSalesTransactionItem[$i]->r_service_id)
														echo '<h5 class="red">'. $service->name .'</h5>';
													else
														echo '<h5>'. $service->name .'</h5>';
												}
											}

											?>

											@endforeach


										</td>

										<td class="pl-20">

											<h5 class="{{ ($sT->salesTransactionsItem[$i]->total_price == $rST->requestedSalesTransactionItem[$i]->r_total_price)? 'red' : '' }}">{{ !empty($rST->id)? $rST->requestedSalesTransactionItem[$i]->r_total_price : old('price.'.$i) }}</h5>

										</td>

										<td class="pl-20">
											<?php
												$colour = '';

												if( $sT->salesTransactionsItem[$i]->information != $rST->requestedSalesTransactionItem[$i]->r_information )
												{
													$colour = "red";
												}

												if( !empty($rST->id) )
												{
													if($rST->requestedSalesTransactionItem[$i]->r_service_id== 2)
													{
														foreach( $seoPackages as $seoPackage )
														{
															if( $seoPackage->slug == $rST->requestedSalesTransactionItem[$i]->r_information )
															{
																if( $colour == 'red' )
																	echo '<h5 class="red">'. $seoPackage->name .'</h5>';
																else
																	echo '<h5>'. $seoPackage->name .'</h5>';
															}
														}

													}
													else if($rST->requestedSalesTransactionItem[$i]->r_service_id== 10)
													{
														foreach( $amcPackages as $amcPackage )
														{
															if( $amcPackage->slug == $rST->requestedSalesTransactionItem[$i]->r_information )
															{
																if( $colour == 'red' )
																	echo '<h5 class="red">'. $amcPackage->name . '</h5>';
																else
																	echo '<h5>'. $amcPackage->name . '</h5>';
															}
														}
													}
													else
													{
														if( $colour == 'red' )
															echo '<h5 class="red">'. $rST->requestedSalesTransactionItem[$i]->r_information . '</h5>';
														else
															echo '<h5>'. $rST->requestedSalesTransactionItem[$i]->r_information . '</h5>';
													}


												} 
											?>
										</td>

										<td class="pl-20">
											<h5 class="{{ ($sT->salesTransactionsItem[$i]->start_date == $rST->requestedSalesTransactionItem[$i]->r_start_date)? 'red' : '' }}">{{ !empty($rST->id)? $rST->requestedSalesTransactionItem[$i]->r_start_date : old('startDate.'.$i) }}</h5>
										</td>

										<td class="pl-20">
											<h5 class="{{ ($sT->salesTransactionsItem[$i]->end_date == $rST->requestedSalesTransactionItem[$i]->r_end_date)? 'red' : '' }}">{{ !empty($rST->id)? $rST->requestedSalesTransactionItem[$i]->r_end_date : old('endDate.'.$i) }}</h5>
										</td>

									</tr>

									@else

										<tr>
											<td class="pl-20">
												@foreach( $services as $service )

												<?php	
												if(!empty($rST->id))
												{
													if(($rST->requestedSalesTransactionItem[$i]->r_service_id)==($service->id) )
													{
														echo '<h5 class="red">'. $service->name .'</h5>';
													}
												}

												?>

												@endforeach


											</td>

											<td class="pl-20">

												<h5 class="red">{{ !empty($rST->id)? $rST->requestedSalesTransactionItem[$i]->r_total_price : old('price.'.$i) }}</h5>

											</td>

											<td class="pl-20">
												<?php
													if( !empty($rST->id) )
													{
														if($rST->requestedSalesTransactionItem[$i]->r_service_id== 2)
														{
															foreach( $seoPackages as $seoPackage )
															{
																if( $seoPackage->slug == $rST->requestedSalesTransactionItem[$i]->r_information )
																{
																	echo '<h5 class="red">'. $seoPackage->name .'</h5>';
																}
															}

														}
														else if($rST->requestedSalesTransactionItem[$i]->r_service_id== 10)
														{
															foreach( $amcPackages as $amcPackage )
															{
																if( $amcPackage->slug == $rST->requestedSalesTransactionItem[$i]->r_information )
																{
																	echo '<h5 class="red">'. $amcPackage->name . '</h5>';
																}
															}
														}
														else
														{
															echo '<h5 class="red">'. $rST->requestedSalesTransactionItem[$i]->r_information . '</h5>';
														}


													} 
												?>
											</td>

											<td class="pl-20">
												<h5 class="red">{{ !empty($rST->id)? $rST->requestedSalesTransactionItem[$i]->r_start_date : old('startDate.'.$i) }}</h5>
											</td>

											<td class="pl-20">
												<h5 class="red">{{ !empty($rST->id)? $rST->requestedSalesTransactionItem[$i]->r_end_date : old('endDate.'.$i) }}</h5>
											</td>

										</tr>
									@endif
									@endfor
									@endif


								</tbody>
							</table>

							<?php 
								$rCountFbDetail = !empty($rST->id)? $rST->requestedSTItemFb->count() : '0' ;
								$countRequestedFbDetail = !empty($rST->id)? $rST->requestedSTItemFb->count() : '0'; 
								$lowestCount = ($countFbDetail > $countRequestedFbDetail)? $countRequestedFbDetail : $countFbDetail;  
							?>

							@if( $rCountFbDetail > 0 )
								<h5><b>Facebook Details</b></h5>
									<table class="table table-responsive-sm table-bordered" style="margin-bottom: 35px;">
										<thead>
											<tr>
												<th width="38%">Particulars</th>
												<th width="21%">Dollar</th>
												<th width="21%">Graphics</th><th width="20%">Total</th>
											</tr>
										</thead>
										<tbody>
										@for( $i = 0; $i < $rCountFbDetail; $i++ )
											@if( ($i+1) <= $lowestCount )
												<tr>
													<td>
														<h5 class="{{ ($sT->salesTransactionsItemFb[$i]->particulars != $rST->requestedSTItemFb[$i]->particulars)? 'red' : '' }}">{{ !empty($rST->id)? $rST->requestedSTItemFb[$i]->r_particulars : '' }}</h5>
													</td>

													<td>
														<h5 class="{{ ($sT->salesTransactionsItemFb[$i]->dollar != $rST->requestedSTItemFb[$i]->dollar)? 'red' : '' }}">{{ !empty($rST->id)? $rST->requestedSTItemFb[$i]->r_dollar : '' }}</h5>
													</td>

													<td>
														<h5 class="{{ ($sT->salesTransactionsItemFb[$i]->graphics != $rST->requestedSTItemFb[$i]->graphics)? 'red' : '' }}">{{ !empty($rST->id)? $rST->requestedSTItemFb[$i]->r_graphics : '' }}</h5>
													</td>

													<td>
														<h5 class="{{ ($sT->salesTransactionsItemFb[$i]->total != $rST->requestedSTItemFb[$i]->total)? 'red' : '' }}">{{ !empty($rST->id)? $rST->requestedSTItemFb[$i]->r_total : '' }}</h5>
													</td>
												</tr>
											@else
												<tr>
													<td>
														<h5 class="red">{{ !empty($rST->id)? $rST->requestedSTItemFb[$i]->r_particulars : '' }}</h5>
													</td>

													<td>
														<h5 class="red">{{ !empty($rST->id)? $rST->requestedSTItemFb[$i]->r_dollar : '' }}</h5>
													</td>

													<td>
														<h5 class="red">{{ !empty($rST->id)? $rST->requestedSTItemFb[$i]->r_graphics : '' }}</h5>
													</td>

													<td>
														<h5 class="red">{{ !empty($rST->id)? $rST->requestedSTItemFb[$i]->r_total : '' }}</h5>
													</td>
												</tr>
											@endif
										@endfor	
									</tbody>
								</table>
							@endif

							<div class="row" <?php if(!$errors->has('officeName')) echo 'style="margin-bottom: 18px;"' ?>>
								<div class="col-md-3 lr_padding_0">
									<div class="col-md-6 control-label lr_padding_0" style="width: 50%">
										<label class="pull-right">Total Amount:</label>
									</div>
									<div class="col-md-6">
										<h5 class="pull-left {{ ($sT->total_amount != $rST->r_total_amount)? 'red' : '' }}" id="total_amount_label">{{ !empty($rST->r_total_amount)? $rST->r_total_amount : old('totalAmount') }}</h5>

										<input type="hidden" id="total_amount_input" name="totalAmount" value="{{ !empty($rST->r_total_amount)? $rST->r_total_amount : old('totalAmount') }}">
									</div>

									<div class="col-md-6 control-label lr_padding_0" style="width: 50%">
										<label class="pull-right">Total Paid Amount:</label>
									</div>
									<div class="col-md-6">
										<h5 class="pull-left {{ ($sT->total_paid_amount != $rST->r_total_paid_amount)? 'red' : '' }}" id="total_amount_label">{{ !empty($rST->r_total_paid_amount)? $rST->r_total_paid_amount : old('totalAmount') }}</h5>
									</div>

									<div class="col-md-6 control-label lr_padding_0" style="width: 52%">
										<label class="pull-right">Remaining Amount:</label>
									</div>
									<div class="col-md-5">
										<h5 class="pull-left {{ ($sT->total_unpaid_amount != $rST->r_total_unpaid_amount)? 'red' : '' }}" id="total_amount_label">{{ !empty($rST->r_total_unpaid_amount)? $rST->r_total_unpaid_amount : old('totalAmount') }}</h5>
									</div>
								</div>

								<div class="col-md-9">
									<input type="hidden" name="count" id="count" value="{{ !empty(old('count'))? old('count') : '' }}">	

									<input type="hidden" name="saleId" value="{{ !empty($rST->id)? $rST->id : old('saleId') }}">							

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
												if(!empty(old('count')))
													$count = old('count');
												else 
													$count = $rST->requestedSalesInstallmentPayment->count();
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

												@if( ($i+1 <= $countST) && ($i+1 <= $countRST) )
													<?php
														$colourPaidAmount = '';
														$colourPaymentMethod = '';
														$colourChequeNumber = '';
														$colourDate = '';

														if( $sT->salesInstallmentPayment[$i]->paid_amount != $rST->requestedSalesInstallmentPayment[$i]->r_paid_amount )
														{
															$colourPaidAmount = 'red';
														}

														if( $sT->salesInstallmentPayment[$i]->payment_method != $rST->requestedSalesInstallmentPayment[$i]->r_payment_method )
														{
															$colourPaymentMethod = 'red';
														}

														if( $sT->salesInstallmentPayment[$i]->cheque_number != $rST->requestedSalesInstallmentPayment[$i]->r_cheque_number )
														{
															$colourChequeNumber = 'red';
														}

														if( $sT->salesInstallmentPayment[$i]->date != $rST->requestedSalesInstallmentPayment[$i]->r_date )
														{
															$colourDate = 'red';
														}

													?>

													<td>
														<input type="text" class="form-control {{ $colourPaidAmount }}" name="iPaidAmount[]" placeholder="Paid Amount" value="<?php 
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
															if(!empty($rST->requestedSalesInstallmentPayment[$i]->r_paid_amount))
															{
																echo $rST->requestedSalesInstallmentPayment[$i]->r_paid_amount;
															}
															else
															echo '';

														}
														?>" {{ empty($editSale)? 'disabled' : '' }} >
													</td>

													<td>
														<select class="form-control {{ $colourPaymentMethod }}" name="iPaymentMethod[]" {{ empty($editSale)? 'disabled' : '' }}>
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
																if(!empty($rST->requestedSalesInstallmentPayment[$i]->r_payment_method))
																{
																	if($rST->requestedSalesInstallmentPayment[$i]->r_payment_method==$paymentMethod->id)
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

														@if(!empty($rST->requestedSalesInstallmentPayment[$i]->r_cheque_number))

														<input type="text" class="form-control {{ $colourChequeNumber }}" name="iChequeNumber[]" placeholder="Cheque Number" value="<?php 
																										
															echo $rST->requestedSalesInstallmentPayment[$i]->r_cheque_number;

														?>" disabled>
														
														@endif

													</td>

													<td>
														<input type="text" class="form-control {{ $colourDate }}" name="date[]" placeholder="Date" value="<?php
															
															if(!empty($rST->requestedSalesInstallmentPayment[$i]->r_date))
															{
																echo $rST->requestedSalesInstallmentPayment[$i]->r_date;
															}
															else
																echo '';
														?>" disabled>
													</td>

													<td>
													</td>
												
												@else

													<td>
														<input type="text" class="form-control red" name="iPaidAmount[]" placeholder="Paid Amount" value="<?php 
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
															if(!empty($rST->requestedSalesInstallmentPayment[$i]->r_paid_amount))
															{
																echo $rST->requestedSalesInstallmentPayment[$i]->r_paid_amount;
															}
															else
															echo '';

														}
														?>" {{ empty($editSale)? 'disabled' : '' }} >
													</td>

													<td>
														<select class="form-control red" name="iPaymentMethod[]" {{ empty($editSale)? 'disabled' : '' }}>
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
																if(!empty($rST->requestedSalesInstallmentPayment[$i]->r_payment_method))
																{
																	if($rST->requestedSalesInstallmentPayment[$i]->r_payment_method==$paymentMethod->id)
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

														@if(!empty($rST->requestedSalesInstallmentPayment[$i]->r_cheque_number))

														<input type="text" class="form-control red" name="iChequeNumber[]" placeholder="Cheque Number" value="<?php 
																										
															echo $rST->requestedSalesInstallmentPayment[$i]->r_cheque_number;

														?>" disabled>
														
														@endif

													</td>

													<td>
														<input type="text" class="form-control red" name="date[]" placeholder="Date" value="<?php
															
															if(!empty($rST->requestedSalesInstallmentPayment[$i]->r_date))
															{
																echo $rST->requestedSalesInstallmentPayment[$i]->r_date;
															}
															else
																echo '';
														?>" disabled>
													</td>

													<td>
													</td>
												@endif

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
			<form method="post" action="{{ url('admin/request/change/'.$rST->id) }}">
				{{ csrf_field() }}
				<input type="hidden" name="salesTransactionId">
				<input type="hidden" name="requestedSalesTransactionId">
				
				<a href="{{ url('/admin/request/nochange/'.$rST->id) }}" class="btn btn-danger pull-right">Deny Changes</a>

				<input type="submit" class="btn btn-success pull-right" style="margin-right: 10px;" value="Allow Changes">
			</form>
		</div>
	</div>

	</section>
@endsection

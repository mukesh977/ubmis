@extends('layouts.layouts')
@section('title', 'Ultrabyte | Add Purchase')

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

						@if(empty($editPurchase->id))
							<h3 class="box-title">Add Purchase Transaction</h3>
						@else
							<h3 class="box-title">Edit Purchase Transaction</h3>
						@endif

					</div>
					<div class="box-body">
						<form class="form-horizontal" method="post" action="{{ url('/store-purchase') }}">
							{{ csrf_field() }}

							<input type="hidden" name="purchaseId" value="{{ !empty($editPurchase->id)? $editPurchase->id : old('purchaseId') }}">
							<input type="hidden" name="count" id="count" value="{{ !empty(old('count'))? old('count') : '' }}">

							<div class="row sales_table">
								<div class="col-md-6">
									<div class="row">
										<div class="form-group col-md-3 right_align">
											<label class="control-label">Purchase Code:</label>
										</div>

										<div class="col-md-9">
											<input type="text" class="form-control" name="purchaseCode" id="purchaseCode" value="{{ !empty($editPurchase->id)? $editPurchase->purchase_code : old('purchaseCode') }}" readonly>

											@if ($errors->has('purchaseCode'))
                        <span class="help-block" style="color: #f86c6b;">
                            {{ $errors->first('purchaseCode') }}
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

												<input type="text" class="form-control pull-right datepicker pl-12" name="date" id="date" value="<?php 
													if(!empty($editPurchase->id))
														echo $editPurchase->date;
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
								<div class="col-md-6" id="shop">

									<div class="row">
										<div class="form-group col-md-3 right_align">
											<label class="control-label">Shop Name:</label>
										</div>
										
										<div class="col-md-9">
											<select class="form-control shop_name" name="shopName" id="shop_id">
												<option value="">Select Shop Name</option>
												
												@foreach( $shops as $shop )
													<option value="{{ $shop->id }}" <?php	
														if(!empty($editPurchase->id))
															{
																if( ($editPurchase->shop_id)==($shop->id) )
																	echo 'selected';
															}
															else
															{
																
																if( old('shopName')==($shop->id) )
																	echo 'selected';
															}
													
												?>>{{ $shop->name }}</option>
												@endforeach
												
											</select>

											<div id="shopMsg"></div>

											@if ($errors->has('shopName'))
                        <span class="help-block" style="color: #f86c6b;">
                            {{ $errors->first('shopName') }}
                        </span>
	                    @endif

										</div>
									</div>
								</div>
							</div>

							
							<!-- /.form group -->
							
								<!-- <a href="#" class="add-new-office pull-right">Add New Office</a> -->
							<button class="btn btn-success pull-right add_fields" title="Add Fields">Add Fields</button>
							<button class="btn btn-primary pull-right add-new-shop" title="Add New Shop">Add New Shop</button>
							<div id="purchaseTable">
								<table class="table table-responsive-sm table-bordered" style="margin-bottom: 35px;">
									<thead>
										<tr>
											<th width="30%">Items</th>
											<th width="16%">Quantity</th>
											<th width="16%">Unit</th>
											<th width="16%">Rate</th>
											<th width="19%">Price</th>
											<th width="3%">&nbsp;</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>
												<input type="text" class="form-control" name="items[]"  value="{{ !empty($editPurchase->purchaseTransactionItem[0]->items)? $editPurchase->purchaseTransactionItem[0]->items : old('items.0') }}"placeholder="Items"> 
											</td>

											<td>
												<input type="text" class="form-control" id="quantity_0" name="quantity[]" value="{{ !empty($editPurchase->purchaseTransactionItem[0]->quantity)? $editPurchase->purchaseTransactionItem[0]->quantity : old('quantity.0') }}" placeholder="Quantity" onkeyup="quantity('0')">
											</td>

											<td>
												<input type="text" class="form-control" id="unit_0" name="unit[]" value="{{ !empty($editPurchase->purchaseTransactionItem[0]->unit)? $editPurchase->purchaseTransactionItem[0]->unit : old('unit.0') }}" placeholder="Unit" onkeyup="unit('0')">
											</td>

											<td>
												<input type="text" class="form-control" id="rate_0" name="rate[]" value="{{ !empty($editPurchase->purchaseTransactionItem[0]->rate)? $editPurchase->purchaseTransactionItem[0]->rate : old('rate.0') }}" placeholder="Rate" onkeyup="rate('0')">
											</td>

											<td>
												<input type="text" class="form-control" id="price_0" name="price[]" value="{{ !empty($editPurchase->purchaseTransactionItem[0]->total_price)? $editPurchase->purchaseTransactionItem[0]->total_price : old('price.0') }}" placeholder="Price" onkeyup="price('0')">
											</td>

											<td>
											</td>
										</tr>

										<?php $count = !empty($editPurchase->id)? $editPurchase->purchaseTransactionItem->count()-1 : old('count'); ?>

										@if(!empty($count))
											@for( $i = 1; $i <= $count; $i++ )
												<tr>
													<td>
														<input type="text" class="form-control" name="items[]" value="{{ !empty($editPurchase->purchaseTransactionItem[$i]->items)? $editPurchase->purchaseTransactionItem[$i]->items : old('items.'.$i) }}" placeholder="Items"> 
													</td>

													<td>
														<input type="text" class="form-control" id="quantity_{{ $i }}" name="quantity[]" value="{{ !empty($editPurchase->purchaseTransactionItem[$i]->quantity)? $editPurchase->purchaseTransactionItem[$i]->quantity : old('quantity.'.$i) }}" placeholder="Quantity" onkeyup="quantity('{{ $i }}')">
													</td>

													<td>
														<input type="text" class="form-control" id="unit_{{ $i }}" name="unit[]" value="{{ !empty($editPurchase->purchaseTransactionItem[$i]->unit)? $editPurchase->purchaseTransactionItem[$i]->unit : old('unit.'.$i) }}" placeholder="Unit" onkeyup="unit('{{ $i }}')">
													</td>

													<td>
														<input type="text" class="form-control" id="rate_{{ $i }}" name="rate[]" value="{{ !empty($editPurchase->purchaseTransactionItem[$i]->rate)? $editPurchase->purchaseTransactionItem[$i]->rate : old('rate.'.$i) }}" placeholder="Rate" onkeyup="rate('{{ $i }}')">
													</td>

													<td>
														<input type="text" class="form-control" id="price_{{ $i }}" name="price[]" value="{{ !empty($editPurchase->purchaseTransactionItem[$i]->total_price)? $editPurchase->purchaseTransactionItem[$i]->total_price : old('price.'.$i) }}" placeholder="Price" onkeyup="price('{{ $i }}')">
													</td>

															<td>
																<a href="#" class="link delete" title="Delete" onclick="deleteid({{ $i }})"><i class="fa fa-trash-o"></i></a>
															</td>
												</tr>
											@endfor
										@endif


									</tbody>
								</table>
							</div>
							<div class="row" <?php if(!$errors->has('shopName')) echo 'style="margin-bottom: 18px;"' ?>>
								<div class="col-md-3 lr_padding_0">
									<div class="col-md-6 control-label lr_padding_0" style="width: 41%">
										<label class="pull-right">Total Amount:</label>
									</div>
									<div class="col-md-6 control-label">
										<label class="pull-left" id="total_amount_label">{{ !empty($editPurchase->total_amount)? $editPurchase->total_amount : old('totalAmount') }}</label>

										<input type="hidden" id="total_amount_input" name="totalAmount" value="{{ !empty($editPurchase->total_amount)? $editPurchase->total_amount : old('totalAmount') }}">
									</div>
								</div>

								<div class="col-md-3 lr_padding_0">
									<div class="col-md-6 control-label lr_padding_0" style="width: 34%;">
										<label>Paid Amount:</label>
									</div>
									<div class="col-md-6">
										<input type="text" class="form-control" id="paid_amount" name="paidAmount" placeholder="Paid Amount" value="{{ !empty($editPurchase->total_paid_amount)? $editPurchase->total_paid_amount : old('paidAmount') }}" {{ !empty($editPurchase->id)? 'readonly' : '' }} onkeyup="paidamount()"> 
									</div>
								</div>

								<div class="col-md-3 lr_padding_0">
									<div class="col-md-6 control-label lr_padding_0" style="width: 49%;">
										<label>Remaining Amount:</label>
									</div>
									<div class="col-md-6">
										<input type="text" class="form-control" id="remaining_amount" name="unpaidAmount" value="{{ !empty($editPurchase->total_unpaid_amount)? $editPurchase->total_unpaid_amount : old('unpaidAmount') }}" placeholder="Remaining" {{ !empty($editPurchase->id)? 'readonly' : '' }}> 
									</div>
								</div>

								<div class="col-md-3 lr_padding_0">
									<div class="col-md-6 control-label lr_padding_0" style="width: 43%;">
										<label>Payment Method:</label>
									</div>
									<div class="col-md-6">
										<select class="form-control" name="paymentMethod" {{ !empty($editPurchase->id)? 'readonly' : '' }}>
											<option value="">Method</option>
											
											@foreach( $paymentMethods as $paymentMethod )
												<option value="{{ $paymentMethod->id }}" <?php 
													if(!empty($editPurchase->id))
													{
														if($editPurchase->purchaseInstallmentPayment[0]->payment_method==$paymentMethod->id)
															echo "selected ";
													}
													else
													{
														if(!empty(old('paymentMethod')))
														{
															if(old('paymentMethod')==$paymentMethod->id)
																echo "selected";
														}
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


							<div class="row">
								<div class="col-md-10">
									<div class="col-md-12">
										@if ($errors->has('items.*'))
                      <span class="help-block" style="color: #f86c6b;">
                          {{ $errors->first('items.*') }}
                      </span>
		                  @endif
		              </div>

		              <div class="col-md-12">
										@if ($errors->has('quantity.*'))
                      <span class="help-block" style="color: #f86c6b;">
                          {{ $errors->first('quantity.*') }}
                      </span>
		                  @endif
		              </div>

		              <div class="col-md-12">
										@if ($errors->has('unit.*'))
                      <span class="help-block" style="color: #f86c6b;">
                          {{ $errors->first('unit.*') }}
                      </span>
		                  @endif
		              </div>

		              <div class="col-md-12">
										@if ($errors->has('rate.*'))
                      <span class="help-block" style="color: #f86c6b;">
                          {{ $errors->first('rate.*') }}
                      </span>
		                  @endif
		              </div>

                  <div class="col-md-12">
										@if ($errors->has('price.*'))
                      <span class="help-block" style="color: #f86c6b;">
                          {{ $errors->first('price.*') }}
                      </span>
	                  @endif
		              </div>
								</div>

								<div class="col-md-2">
									<button type="submit" class="btn btn-primary sales_submit pull-right">

										@if(empty($editPurchase->id))	
											Add Purchase
										@else
											Edit Purchase
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
		@include('shop.partials.create-new-shop-modal')
	</section>
@endsection

@section('script')
	<script src="{{asset('js/office-modal.js')}}"></script>

	<script>
		var stored_id = [];
		var countField = 0;
		var i;

		@if( !empty($editPurchase->id) )
			countField = '{{ $count }}';

			for( i = 0; i <= countField; i++ )
				stored_id.push(i);

			$('#count').val(Number(countField) + 1);
			console.log(countField);

		@endif

		function totalsum(id)
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

			console.log(sum);

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

		function quantity(id)
		{
			var ans = 0;

			ans = Number($('#quantity_' + id).val()) * Number($('#rate_' + id).val());

			$('#price_' + id).val(ans);

			totalsum(id);			
		}


		function rate(id)
		{
			var ans = 0;

			ans = Number($('#quantity_' + id).val()) * Number($('#rate_' + id).val());

			$('#price_' + id).val(ans);

			totalsum(id);
		}


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
			console.log('hy');

							
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
					// console.log(stored_id);
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

		function clearform(){
      $('#officeModal').find('.form-group').each(function(){
          $('.form-group').removeClass('has-error');
          $('.help-block').empty();
      });
	  }

	</script>

	<script>
		$(document).ready(function() {
			
			var count = '<?php 
							if(!empty($editPurchase->id))
								echo ($count +1);
							else
							{
								if(!empty(old('count')))
									echo old('count');
								else
									echo '0';
							}
			 ?>';
			 
			// console.log(count);
			var field = $('#purchaseTable').find('.table > tbody');
			var lstPurchaseId = "{{ $lastPurchaseId }}";
			var shopid = "{{ old('shopName') }}";

			var lastPurchaseId = String("00000" + lstPurchaseId).slice(-5);

			@if( empty($editPurchase->id) )
				$('#purchaseCode').val('P-000-' + lastPurchaseId);
			@endif

			$('#shop_id').on('select2:select', function(){
				var shop = $('#shop_id option:selected').val();
				var shopId = String("000" + shop).slice(-3);

				$('#purchaseCode').val('P-' + shopId + '-' + lastPurchaseId);
			});
			
			$('#total_amount_label').val($('#total_amount_input').val());

			$('#date').datepicker({
				dateFormat: "yy-mm-dd",
				changeMonth: true,
				changeYear: true,
			});

			$('.shop_name').select2();

			$('.add_fields').on('click', function(e){
				e.preventDefault();
				count++;
				countField++;

				$(field).append('<tr><td><input type="text" class="form-control" name="items[]" placeholder="Items"></td><td><input type="text" class="form-control" id="quantity_' + countField + '" name="quantity[]" value="" placeholder="Quantity" onkeyup="quantity(' + countField + ')"></td><td><input type="text" class="form-control" id="unit_' + countField + '" name="unit[]" value="" placeholder="Unit" onkeyup="unit(' + countField + ')"></td><td><input type="text" class="form-control" id="rate_' + countField + '" name="rate[]" value="" placeholder="Rate" onkeyup="rate(' + countField + ')"></td><td><input type="text" class="form-control" id="price_' + countField + '" name="price[]" value="" placeholder="Price" onkeyup="price(' + countField + ')"></td><td><a href="#" class="link delete" title="Delete" onclick="deleteid('+ countField +')"><i class="fa fa-trash-o"></i></a></td></tr>');

				$('#count').val(count);

			});

			$(field).on('click', '.delete', function(e){
				e.preventDefault();
				$(this).parent().closest('tr').remove();

				count--;
				$('#count').val(count);
			});


			

			
			//shop modal script starts

			



			$('.phone_add').on('click', function(e){
		    e.preventDefault();

	    $('#modalTable').find('.table > tbody').append('<tr><td width="95%"><input type="text" name="contactNumber[]" placeholder="Enter Contact Number" class="form-control"></td><td width="5%"><a href="#" class="link delete" title="Delete" onclick="deleteid()"><i class="fa fa-trash-o" style="margin-top: 10px;"></i></a></td></tr>');
	  });
    
  $('#modalTable').find('.table > tbody').on('click', '.delete', function(e){
    e.preventDefault();
    $(this).parent().closest('tr').remove();

  });

			$('#shopModal').on('hidden.bs.modal', function () {
        clearform();
      });

      $('.add-new-shop').click(function(e){
		    e.preventDefault();
		    $('#shopModal').modal('show');
			});



			$('#shopModal').on('hidden.bs.modal', function () {
			    clearform();
			})


			function clearform(){
			    $('#shopModal').find('.form-group').each(function( index, element ){
			        $('.form-group').removeClass('has-error');
			        $('.help-block').empty();

			    });

	        $('#modalTable').find('.table > tbody').find('tr').not(':first').empty();
	        $('#shopModal').find('input').val("");
	        $('.shopModal').find('label').find('.error').remove();
			}

			$('#save-new-shop').click(function(e){
				var contactNumberArray = [];
			  var token = $('input[name="_token"]').val();
			  var name = $('input[name="name"]').val();
			  var address = $('input[name="address"]').val();
			  var contactNumber = $('input[name="contactNumber[]"]').each( function(){
			  		contactNumberArray.push($(this).val());
			  });

			  // console.log(contactNumberArray);
			  console.log(baseUrl);

			  $.ajax({
			      url: baseUrl + "shop",
			      type: "POST",
			      data:{ _token:token, name:name, address:address, contactNumbers: contactNumberArray, method:'post'},
			      success: function(result){
			          $('#shopModal').find('.form-group').each(function(){
			              //reset field
			              $(this).find('input').val();
			              //clear erorrs class
			              $('.form-group').removeClass('has-error');
			              $('.help-block').empty();
			          });
			          
			          $('#shopModal').modal('hide');
			          clearform();
			          console.log(result);
			          $('#shop').find('select[name="shopName"]').append('<option value="'+ result.data.id +'" selected>'+ result.data.name +'</option>');
		            
		            $('#shop').find('#shopMsg').append(result.message).css('color','#449d44');
			          
			          setTimeout(function() { $('#shopMsg').text(''); }, 5000);

			      },

			      error: function(errors){
			      		$('.help-block').text("Empty fields !!!");

			      },
			  	});

				});

			

		});

	</script>
@endsection
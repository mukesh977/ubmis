@extends('layouts.layouts')
@section('title', 'Ultrabyte | List Sales')

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

		<div class="box">
			<div class="box-header">
				<h3 class="box-title">List Purchase Transactions</h3>

				<div class="box-tools">
					<div class="input-group input-group-sm" style="width: 150px;">
						<input type="text" name="table_search" class="form-control pull-right" placeholder="Search">

						<div class="input-group-btn">
							<button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
						</div>
					</div>
				</div>
			</div>
			<!-- /.box-header -->
			<div class="box-body table-responsive no-padding">
				<table class="table table-hover">
					<tr>
						<th>Purchase Code</th>
						<th>Date</th>
						<th>Shop Name</th>
						<th>Total Amount</th>
						<th>Remaining Amount</th>
						<th>Action</th>
						<th>Pay</th>
					</tr>

					@if(!$purchaseTransactions->isEmpty())
						@foreach( $purchaseTransactions as $purchaseTransaction )
							<tr>
								<td>{{ $purchaseTransaction->purchase_code }}</td>
								<td>{{ \Carbon\Carbon::parse($purchaseTransaction->date)->format('F j, Y') }}</td>
								<td>
									<a href="" class="shopDetail" data-shopid="{{ $purchaseTransaction->shop_id }}">{{ $purchaseTransaction->shop->name }}</a>
								</td>
								<td>{{ $purchaseTransaction->total_amount }}</td>
								<td>{{ $purchaseTransaction->total_unpaid_amount }}</td>
								<td>
									<a href="{{ url('/edit-purchase/'. $purchaseTransaction->id ) }}" class="link edit" title="Edit"><i class="fa fa-pencil"></i></a> | 

									<a href="#" class="link delete" title="Delete" data-purchaseid="{{ $purchaseTransaction->id }}" data-toggle="modal" data-target="#delete"><i class="fa fa-trash-o"></i></a> |

									<a href="#" class="link view" id="v" title="View" data-viewid="{{ $purchaseTransaction->id }}"><i class="fa fa-eye"></i></a>
								</td>
								<td>
									@if( $purchaseTransaction->payment_complete_status == 1 )
										<a href="{{ url('/pay-purchase/'.$purchaseTransaction->id) }}" class="link" title="Pay">
											<span class="label label-success">Paid</span>
										</a>
									@else
										<a href="{{ url('/pay-purchase/'.$purchaseTransaction->id) }}" class="link" title="Pay">
											<span class="label label-danger">Pay</span>
										</a>
									@endif
								</td>
							</tr>
						@endforeach
					@endif


				</table>

				@if( $purchaseTransactions->total() > $paginationNumber )
					{{ $purchaseTransactions->links('layouts.paginator') }}
		        @else
					<div class="box-footer clearfix">
		              <ul class="pagination pagination-sm no-margin pull-right">
		                <li><a href="#">&laquo;</a></li>
		                <li><a href="#">1</a></li>
		                <li><a href="#">&raquo;</a></li>
		              </ul>
		            </div>
	            @endif
			</div>
			<!-- /.box-body -->
		</div>
		<!-- /.box -->

		<div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title">Delete Purchase Transaction</h4>
					</div>
					<form method="POST" action="{{ url('/delete-purchase') }}"> 
						{{ csrf_field() }}
					<div class="modal-body">
						<p>Are you sure you want to delete this purchase transaction?</p>
						<input type="hidden" name="purchase_id_delete" id="purchase_id_delete" value="">
					</div>
					<div class="modal-footer">

						<button class="btn btn-danger" type="button" data-dismiss="modal">Close</button>
						<button class="btn btn-success" id="submit" type="submit">Delete</button>
					</div>
					</form>
				</div>
			<!-- /.modal-content-->
			</div>
		<!-- /.modal-dialog-->
		</div>
      <!-- /.modal-->

	<div class="modal fade" id="viewModal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<label class="supplierModalLabel">View Purchase</label>
					<button class="close" type="button" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">×</span>
					</button>
				</div>
				
				<div class="modal-body">
					<div class="row">
						<div class="col-sm-3">
							<h5 class="supplierResult">Purchase Code:</h5>
						</div>
						<div class="col-sm-9">
							<h5 id="purchaseCode" class="supplierResult"></h5>
						</div>
					</div>

					<div class="row">
						<div class="col-sm-3">
							<h5 class="supplierResult">Date:</h5>
						</div>
						<div class="col-sm-9">
							<h5 id="date" class="supplierResult"></h5>
						</div>
					</div>

					<div class="row">
						<div class="col-sm-3">
							<h5 class="supplierResult" style="margin-bottom: 25px;">Shop Name:</h5>
						</div>
						<div class="col-sm-9">
							<h5 id="shopName" class="col-sm-8 supplierResult"></h5>
						</div>
					</div>

					<table class="table table-responsive-sm table-bordered" style="margin-bottom: 30px;">
						<thead>
							<tr>
								<th width="30%">Items</th>
								<th width="17%">Quantity</th>
								<th width="17%">Unit</th>
								<th width="17%">Rate</th>
								<th width="19%">Price</th>
							</tr>
						</thead>
						<tbody id="tableData">

						</tbody>

					</table>
					<div class="row">
						<div class="col-md-6">
							<div class="row">
								<div class="col-sm-7">
									<h5 class="supplierResult">Total Amount:</h5>
								</div>
								<div class="col-sm-5">
									<h5 id="totalAmount" class="supplierResult"></h5>
								</div>
							</div>

							<div class="row">
								<div class="col-sm-7">
									<h5 class="supplierResult">Paid Amount:</h5>
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

						<div class="col-md-6" id="payment">

					</div>
				</div>
				<div class="modal-footer">

					<button class="btn btn-default" type="button" data-dismiss="modal">Close</button>
				</div>
			</div>
		<!-- /.modal-content-->
		</div>
	<!-- /.modal-dialog-->
	</div>
	<!--.modal-->

	@include('shop.partials.shop-detail-modal')

</section>
@endsection

@section('script')
	<script>
		$(document).ready(function() {
			$('#delete').on('show.bs.modal', function (event) {
				var button = $(event.relatedTarget)
				var purchase_id_delete = button.data('purchaseid')
				var modal = $(this)

				modal.find('.modal-body #purchase_id_delete').val(purchase_id_delete);
			});

			$('#submit').click(function(){
				$('#delete').modal('hide')
			});

			$('.view').on('click', function(e){
				
				e.preventDefault();

				var view_id = $(this).data('viewid');

				$.ajax({
					type: 'get',
					url: '{{ URL::to("/show-purchase") }}',
					data: {'id' : view_id},
					success: function(data){
						// console.log(data);
						$('#purchaseCode').html(data.purchase_code);
						$('#date').html(data.date);
						$('#shopName').html(data.shop.name);

						var count = data.purchase_transaction_item.length;
						$('#count').val(count);

						var i;
						var j;
						var field = $('#viewModal .table > tbody');

						for( i = 0; i < count; i++ )
						{
							
							$(field).append('<tr><td>'+ data.purchase_transaction_item[i].items + '</td><td>' + data.purchase_transaction_item[i].quantity + '</td></td><td>' + data.purchase_transaction_item[i].unit + '</td></td><td>' + data.purchase_transaction_item[i].rate + '</td></td><td>' + data.purchase_transaction_item[i].total_price + '</td></tr>');

						}

						$('#totalAmount').html(data.total_amount);
						$('#paidAmount').html(data.total_paid_amount);
						$('#remainingAmount').html(data.total_unpaid_amount);

						for( i = 0; i < data.purchase_installment_payment.length; i++ )
						{
							if( i == 0 )
								$('#payment').append('<div class="row"><div class="col-sm-8"><h5 class="supplierResult">' + (i+1) +'<sup>st</sup> Installment Payment:</h5></div>' + '<div class="col-sm-4" style="padding-left: 0px;"><h5 class="supplierResult">'+ data.purchase_installment_payment[i].paid_amount +'</h5></div></div>');

							else if( i == 1 )
								$('#payment').append('<div class="row"><div class="col-sm-8"><h5 class="supplierResult">' + (i+1) +'<sup>nd</sup> Installment Payment:</h5></div>' + '<div class="col-sm-4" style="padding-left: 0px;"><h5 class="supplierResult">'+ data.purchase_installment_payment[i].paid_amount +'</h5></div></div>');

							else if( i == 2 )
								$('#payment').append('<div class="row"><div class="col-sm-8"><h5 class="supplierResult">' + (i+1) +'<sup>rd</sup> Installment Payment:</h5></div>' + '<div class="col-sm-4" style="padding-left: 0px;"><h5 class="supplierResult">'+ data.purchase_installment_payment[i].paid_amount +'</h5></div></div>');

							else if( i == 3 )
								$('#payment').append('<div class="row"><div class="col-sm-8"><h5 class="supplierResult">' + (i+1) +'<sup>rth</sup> Installment Payment:</h5></div>' + '<div class="col-sm-4" style="padding-left: 0px;"><h5 class="supplierResult">'+ data.purchase_installment_payment[i].paid_amount +'</h5></div></div>');

							else
								$('#payment').append('<div class="row"><div class="col-sm-8"><h5 class="supplierResult">' + (i+1) +'<sup>th</sup> Installment Payment:</h5></div>' + '<div class="col-sm-4" style="padding-left: 0px;"><h5 class="supplierResult">'+ data.purchase_installment_payment[i].paid_amount +'</h5></div></div>');
						}

						$('#viewModal').modal('show');
						
					}
				});

				$('#viewModal').on('hidden.bs.modal', function () {
					console.log('hy');
					$('#tableData').empty(); 
					$('#payment').empty();
				});


			});


			$('.shopDetail').on('click', function(e){
				
				e.preventDefault();

				var shop_id = $(this).data('shopid');

				$.ajax({
					type: 'get',
					url: '{{ URL::to("/show-shop") }}',
					data: {'shopId' : shop_id},
					success: function(data){
						console.log(data);

						$('#shopname').html(data.name);
						$('#address').html(data.address);

						var i;
						var count = data.contact_numbers.length;

						for( i = 0; i < count; i++ )
						{
							if( i == (count-1) )
								$('#contactNumber').append('<h5 class="supplierResult inlineblock">'+ data.contact_numbers[i].contact_number +'</h5>');
							else
								$('#contactNumber').append('<h5 class="supplierResult inlineblock">'+ data.contact_numbers[i].contact_number +',</h5>');
						}

						$('#shopDetailModal').modal('show');

					}
				});
			});

			$('#shopDetailModal').on('hidden.bs.modal', function () {
				$('#shopName').empty(); 
				$('#address').empty(); 
				$('#contactNumber').empty(); 
			});

		});
	</script>
@endsection
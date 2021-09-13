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
				<h3 class="box-title">Searched Sales Transactions</h3>

				<div class="box-tools">
					<form method="get" action="{{ url('/list-sales/search') }}">
						<div class="input-group input-group-sm" style="width: 150px;">
							<input type="text" name="companyName" class="form-control pull-right" placeholder="Search" value="{{ !empty($companyName)? $companyName : '' }}">

							<div class="input-group-btn">
								<button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
							</div>
						</div>
					</form>
				</div>
			</div>
			<!-- /.box-header -->
			<div class="box-body table-responsive no-padding">
				<table class="table table-hover">
					<tr>
						<th>Sales Code</th>
						<th>Date</th>
						<th>Office Name</th>
						<th>Total Amount</th>
						<th>Remaining Amount</th>
						<th>Action</th>
						<th>Pay</th>
					</tr>

					@if(!$searchedSales->isEmpty())
						@foreach( $searchedSales as $salesTransaction )
							<tr>
								<td>{{ $salesTransaction->sales_code }}</td>
								<td>{{ \Carbon\Carbon::parse($salesTransaction->date)->format('F j, Y') }}</td>
								<td>
									<a href="#" class="companyDetail" data-companyid="{{ $salesTransaction->company_id }}">{{ $salesTransaction->company->name }}</a>
								</td>
								<td>{{ $salesTransaction->total_amount }}</td>
								<td>{{ $salesTransaction->total_unpaid_amount }}</td>
								<td>
									<a href="{{ url('/edit-sales/'. $salesTransaction->id ) }}" class="link edit" title="Edit"><i class="fa fa-pencil"></i></a> | 

									<a href="#" class="link delete" title="Delete" data-salesid="{{ $salesTransaction->id }}" data-toggle="modal" data-target="#delete"><i class="fa fa-trash-o"></i></a> |

									<a href="#" class="link view" id="v" title="View" data-viewid="{{ $salesTransaction->id }}"><i class="fa fa-eye"></i></a>
								</td>
								<td>
									@if( $salesTransaction->payment_complete_status == 1 )
										<a href="{{ url('/pay-sales/'.$salesTransaction->id) }}" class="link" title="Pay">
											<span class="label label-success">Paid</span>
										</a>
									@else
										<a href="{{ url('/pay-sales/'.$salesTransaction->id) }}" class="link" title="Pay">
											<span class="label label-danger">Pay</span>
										</a>
									@endif
								</td>
							</tr>
						@endforeach
					@endif


				</table>

				@if( $searchedSales->total() > $searchedSales->perPage() )
					{{ $searchedSales->links('layouts.paginator') }}
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
						<h4 class="modal-title">Delete Sales Transaction</h4>
					</div>
					<form method="POST" action="{{ url('/delete-sales') }}"> 
						{{ csrf_field() }}
					<div class="modal-body">
						<p>Are you sure you want to delete this sales transaction?</p>
						<input type="hidden" name="sales_id_delete" id="sales_id_delete" value="">
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
					<label class="supplierModalLabel">View Sales</label>
					<button class="close" type="button" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">×</span>
					</button>
				</div>
				
				<div class="modal-body">
					<div class="row">
						<div class="col-sm-3">
							<h5 class="supplierResult">Sales Code:</h5>
						</div>
						<div class="col-sm-9">
							<h5 id="salesCode" class="supplierResult"></h5>
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
							<h5 class="supplierResult" style="margin-bottom: 25px;">Office Name:</h5>
						</div>
						<div class="col-sm-9">
							<h5 id="officeName" class="col-sm-8 supplierResult"></h5>
						</div>
					</div>

					<table class="table table-responsive-sm table-bordered" style="margin-bottom: 30px;">
						<thead>
							<tr>
								<th width="30%">Services</th>
								<th width="17%">Price</th>
								<th width="17%">Disk Space</th>
								<th width="18%">Start Date</th>
								<th width="18%">End Date</th>
							</tr>
						</thead>
						<tbody id="tableData">

						</tbody>

					</table>
					<div class="row">
						<div class="col-md-5">
							<div class="row">
								<div class="col-sm-7 pr-0">
									<h5 class="supplierResult ">Total Amount:</h5>
								</div>
								<div class="col-sm-5 plr-0">
									<h5 id="totalAmount" class="supplierResult"></h5>
								</div>
							</div>

							<div class="row">
								<div class="col-sm-7 pr-0">
									<h5 class="supplierResult">Paid Amount:</h5>
								</div>
								<div class="col-sm-5 plr-0">
									<h5 id="paidAmount" class="supplierResult"></h5>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-7 pr-0">
									<h5 class="supplierResult">Remaining Amount:</h5>
								</div>
								<div class="col-sm-5 plr-0">
									<h5 id="remainingAmount" class="supplierResult"></h5>
								</div>
							</div>
						</div>

						<div class="col-md-7" id="payment">
							
						</div>

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

	@include('company.partials.company-detail-modal')

</section>
@endsection

@section('script')
	<script>
		$(document).ready(function() {
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
            
			$('#delete').on('show.bs.modal', function (event) {
				var button = $(event.relatedTarget)
				var sales_id_delete = button.data('salesid')
				var modal = $(this)

				modal.find('.modal-body #sales_id_delete').val(sales_id_delete);
			});

			$('#submit').click(function(){
				$('#delete').modal('hide')
			});

			$('.view').on('click', function(e){
				
				e.preventDefault();

				var view_id = $(this).data('viewid');

				$.ajax({
					type: 'get',
					url: '{{ URL::to("/show-sales") }}',
					data: {'id' : view_id},
					success: function(data){
						$('#salesCode').html(data[0].sales_code);
						$('#date').html(data[0].date);
						$('#officeName').html(data[0].company.name);

						console.log(data);

						var count = data[0].sales_transactions_item.length;
						$('#count').val(count);

						var i;
						var j;
						var field = $('#viewModal .table > tbody');

						for( i = 0; i < count; i++ )
						{
							
							if(data[0].sales_transactions_item[i].service_id == 2)
							{
								var result = '<tr><td>'+ data[2][i].sales_category.name + '</td><td>' + data[0].sales_transactions_item[i].total_price + '</td><td>';
								
								if( data[0].sales_transactions_item[i].information != null )
								{
									for( var j = 0; j < seoPackageLength; j++ )
									{
										if(seoPackage[j].slug == data[0].sales_transactions_item[i].information ){
											result = result + seoPackage[j].name;
										}
									}
								}

								result = result + '</td><td>' + ((data[0].sales_transactions_item[i].start_date != null)? data[0].sales_transactions_item[i].start_date : '')  + '</td><td>' + ((data[0].sales_transactions_item[i].end_date != null)? data[0].sales_transactions_item[i].end_date : '' ) + '</td></tr>';
							}
							else if(data[0].sales_transactions_item[i].service_id == 10)
							{
								var result = '<tr><td>'+ data[2][i].sales_category.name + '</td><td>' + data[0].sales_transactions_item[i].total_price + '</td><td>';
								
								if( data[0].sales_transactions_item[i].information != null )
								{
									for(var j = 0; j < amcPackageLength; j++)
									{
										if(amcPackage[j].slug == data[0].sales_transactions_item[i].information ){
											result = result + amcPackage[j].name;
										}
									}
								}

								result = result + '</td><td>' + ((data[0].sales_transactions_item[i].start_date != null)? data[0].sales_transactions_item[i].start_date : '')  + '</td><td>' + ((data[0].sales_transactions_item[i].end_date != null)? data[0].sales_transactions_item[i].end_date : '' ) + '</td></tr>';
							}
							else
							{
								var result = '<tr><td>'+ data[2][i].sales_category.name + '</td><td>' + data[0].sales_transactions_item[i].total_price + '</td><td>' + ((data[0].sales_transactions_item[i].information != null)? data[0].sales_transactions_item[i].information : '') + '</td><td>' + ((data[0].sales_transactions_item[i].start_date != null)? data[0].sales_transactions_item[i].start_date : '')  + '</td><td>' + ((data[0].sales_transactions_item[i].end_date != null)? data[0].sales_transactions_item[i].end_date : '' ) + '</td></tr>';
							}

							$(field).append(result);

						}

						$('#totalAmount').html(data[0].total_amount +' /-');
						$('#paidAmount').html(data[0].total_paid_amount +' /-');
						$('#remainingAmount').html(data[0].total_unpaid_amount +' /-');

						for( i = 0; i < data[0].sales_installment_payment.length; i++ )
						{
							if( i == 0 )
								$('#payment').append('<div class="row"><div class="col-sm-5"><h5 class="supplierResult">' + (i+1) +'<sup>st</sup> Payment:</h5></div>' + '<div class="col-sm-4" style="padding-left: 0px; padding-right: 0px;"><h5 class="supplierResult">'+ data[0].sales_installment_payment[i].paid_amount +' /-</h5></div><div class="col-sm-3 plr-0"><h5 class="supplierResult">'+ data[0].sales_installment_payment[i].date +'</h5></div></div>');

							else if( i == 1 )
								$('#payment').append('<div class="row"><div class="col-sm-5"><h5 class="supplierResult">' + (i+1) +'<sup>nd</sup> Payment:</h5></div>' + '<div class="col-sm-4" style="padding-left: 0px;"><h5 class="supplierResult">'+ data[0].sales_installment_payment[i].paid_amount +' /-</h5></div><div class="col-sm-3 plr-0"><h5 class="supplierResult">'+ data[0].sales_installment_payment[i].date +'</h5></div></div>');

							else if( i == 2 )
								$('#payment').append('<div class="row"><div class="col-sm-5"><h5 class="supplierResult">' + (i+1) +'<sup>rd</sup> Payment:</h5></div>' + '<div class="col-sm-4" style="padding-left: 0px;"><h5 class="supplierResult">'+ data[0].sales_installment_payment[i].paid_amount +' /-</h5></div><div class="col-sm-3 plr-0"><h5 class="supplierResult">'+ data[0].sales_installment_payment[i].date +'</h5></div></div>');

							else if( i == 3 )
								$('#payment').append('<div class="row"><div class="col-sm-5"><h5 class="supplierResult">' + (i+1) +'<sup>rth</sup> Payment:</h5></div>' + '<div class="col-sm-4" style="padding-left: 0px;"><h5 class="supplierResult">'+ data[0].sales_installment_payment[i].paid_amount +' /-</h5></div><div class="col-sm-3 plr-0"><h5 class="supplierResult">'+ data[0].sales_installment_payment[i].date +'</h5></div></div>');

							else
								$('#payment').append('<div class="row"><div class="col-sm-5"><h5 class="supplierResult">' + (i+1) +'<sup>th</sup> Payment:</h5></div>' + '<div class="col-sm-4" style="padding-left: 0px;"><h5 class="supplierResult">'+ data[0].sales_installment_payment[i].paid_amount +' /-</h5></div><div class="col-sm-3 plr-0"><h5 class="supplierResult">'+ data[0].sales_installment_payment[i].date +'</h5></div></div>');
						}

						$('#viewModal').modal('show');

					}
				});

				$('#viewModal').on('hidden.bs.modal', function () {
					$('#tableData').empty();
					$('#payment').empty(); 
				});


			});


			//company-detail-modal operations


			$('.companyDetail').on('click', function(e){
				
				e.preventDefault();

				var company_id = $(this).data('companyid');

				$.ajax({
					type: 'get',
					url: '{{ URL::to("/show-company") }}',
					data: {'companyId' : company_id},
					success: function(data){
						console.log(data);

						$('#companyName').html(data.name);
						$('#address').html(data.address);

						var i;
						var count1 = data.emails.length; 

						for( i = 0; i < count1; i++ )
						{
							if( i == (count1-1) )
								$('#email').append('<h5 class="supplierResult inlineblock">'+ data.emails[i].email +'</h5>');
							else
								$('#email').append('<h5 class="supplierResult inlineblock">'+ data.emails[i].email +',</h5>');
						}


						var count2 = data.contact_numbers.length;

						for( i = 0; i < count2; i++ )
						{
							if( i == (count2-1) )
								$('#contactNumber').append('<h5 class="supplierResult inlineblock">'+ data.contact_numbers[i].contact_number +'</h5>');
							else
								$('#contactNumber').append('<h5 class="supplierResult inlineblock">'+ data.contact_numbers[i].contact_number +',</h5>');

						}

						$('#companyDetailModal').modal('show');
						
					}
				});
			});

			$('#companyDetailModal').on('hidden.bs.modal', function () {
				$('#companyName').empty(); 
				$('#address').empty(); 
				$('#email').empty(); 
				$('#contactNumber').empty(); 
			});


		});
	</script>
@endsection
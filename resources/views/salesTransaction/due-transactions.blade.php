<?php $sn = ($results->currentPage()-1)*($results->perPage()); ?>

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
				<h3 class="box-title">Due Transactions</h3>

				<div class="box-tools">
					<form method="get" action="{{ url('/due-transactions/search') }}">
						<div class="input-group input-group-sm" style="width: 150px;">
							<input type="text" name="companyName" class="form-control pull-right" placeholder="Search">

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
						<th>S.N</th>
						<th width="50%">Office Name</th>
						<th>Total Amount</th>
						<th>Total Paid Amount</th>
						<th>Due Amount</th>
						<th>Transaction</th>
						<th>Pay</th>
					</tr>


					@foreach( $results as $result )
						<?php $sn++; ?>
						<tr>
							<td>
								{{ $sn }}
							</td>
							<td>
								<a href="#" class="companyDetail" data-companyid="{{ $result['officeDetailArray']->company->id }}">
									{{ $result['officeDetailArray']->company->name }}
								</a>
							</td>

							<td>
								{{ nepali_number_format($result['totalAmount']) }}
							</td>

							<td>
								{{ nepali_number_format($result['totalPaidAmount']) }}
							</td>

							<td>
								{{ nepali_number_format($result['totalUnpaidAmount']) }}
							</td>

							<td>
								<a href="{{ url('/due-transactions/'.$result['officeDetailArray']->company_id) }}" class="link">
								<span class="label label-primary">View</span>
							</td>

							<td>
								@if( $result['totalAmount'] == $result['totalPaidAmount'] )
									<span class="label label-success">Paid</span>
								@else
									<a href="" class="link pay" title="Pay" data-companyid="{{ $result['officeDetailArray']->company_id }}" data-toggle="modal" data-target="#payModal">
										<span class="label label-danger">Pay</span>
									</a>
								@endif
							</td>
						</tr>
					@endforeach

					

				</table>

				@if( $results->total() > $paginationNumber )
					{{ $results->links('layouts.paginator') }}
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

	</section>

	<div class="modal fade" id="payModal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<form method="post" id="payForm" action="{{ url('/due-transactions/pay') }}">
				{{ csrf_field() }}
				<div class="modal-content">
					<div class="modal-header">
						<label class="supplierModalLabel">Make Payment</label>
						<button class="close" type="button" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>
					</div>
					
					<div class="modal-body">
						<div class="row" style="margin-bottom: 10px;">
							<div class="col-md-5">
								<input type="hidden" name="companyId" id="companyId" value="">
								<div class="row">
									<div class="col-sm-3 plr-0">
										<h5 class="supplierResult pull-right">Pay:</h5>
									</div>
									<div class="col-sm-9">
										<input type="text" class="form-control" id="payAmount" name="payAmount" placeholder="Enter paid amount">
									</div>
								</div>
							</div>
							<div class="col-md-7">
								<div class="row">
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

						<div class="row">
							<div class="col-md-5">
							</div>

							<div class="col-md-7">
								<div class="row">
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

	@include('company.partials.company-detail-modal')

@endsection

@section('script')
	<script>
	//company-detail-modal operations

		$(document).ready(function() {

			$('.companyDetail').on('click', function(e){
				
				e.preventDefault();

				var company_id = $(this).data('companyid');

				// $('.companyDetail').click(function(e) {
				// 	e.preventDefault();

				// 	$('#companyDetailModal').modal('show');
				// });

				$.ajax({
					type: 'get',
					url: '{{ URL::to("/show-company") }}',
					data: {'companyId' : company_id},
					success: function(data){
						console.log(data);

						$('#companyName').html(data.name);
						$('#address').html(data.address);

						var i;
						var count = data.emails.length;

						for( i = 0; i < count; i++ )
						{
							if( i == (count-1) )
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

			$('#payModal').on('show.bs.modal', function (event) {
				var button = $(event.relatedTarget);
				var companyId = button.data('companyid');
				var modal = $(this);

				modal.find('.modal-body #companyId').val(companyId);
			});

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
						required:"Please enter amount",
						maxlength:"Max"
					},

					pMethod: {
						required:"Please select one option",
						maxlength:"Max"
					}
				}
			});
		});

	</script>

@endsection
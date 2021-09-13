<?php $sn = ($results->currentPage()-1)*($results->perPage()); ?>

@extends('layouts.layouts')
@section('title', 'Ultrabyte | List Sales')

	@section('content')
	<section class="content">
		<div class="box">
			<div class="box-header">
				<h3 class="box-title">Client Transactions</h3>

				<div class="box-tools">
					<form method="get" action="{{ url('/client-transactions/search') }}">
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
								{{ !empty($result['totalAmount'])? nepali_number_format($result['totalAmount']) : '' }}
							</td>

							<td>
								{{ !empty($result['totalPaidAmount'])? nepali_number_format($result['totalPaidAmount']) : '' }}
							</td>

							<td>
								{{ !empty($result['totalUnpaidAmount'])? nepali_number_format($result['totalUnpaidAmount']) : '' }}
							</td>

							<td>
								<a href="{{ url('/client-transaction/'.$result['officeDetailArray']->company_id) }}" class="link">
								<span class="label label-primary">View</span>
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

	@include('company.partials.company-detail-modal')

@endsection

@section('script')
	<script>
	//company-detail-modal operations

		$(document).ready(function() {

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
		});

	</script>

@endsection
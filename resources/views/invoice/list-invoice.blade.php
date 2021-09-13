<?php $sn = ($invoices->currentPage()-1)*($invoices->perPage()); ?>

@extends('layouts.layouts')
@section('title', 'Ultrabyte | Companies')

@section('content')
	<section class="content">
		<div class="box">
			<div class="box-header">
				<h3 class="box-title">List Invoices</h3>

				<div class="box-tools">
					<form method="get" action="#">
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
						<th>Bill No.</th>
						<th>Creation Date</th>
						<th>Company Name</th>
						<th>Address</th>
						<th>Invoice</th>
					</tr>

					@if(!$invoices->isEmpty())
						@foreach( $invoices as $invoice )

						<?php $sn++; ?>

							<tr>
								<td>{{ $sn }}</td>
								<td>{{ $invoice->bill_no }}</td>
								<td>{{ $invoice->date }}</td>
								<td>{{ $invoice->company->name }}</td>
								<td>{{ $invoice->company->address }}</td>
								<td>
									<a href="{{ url('/invoices/'.$invoice->id) }}" class="btn btn-xs btn-primary link edit" title="View Invoice">View Invoice</a> 
								</td>
							</tr>
						@endforeach
					@endif


				</table>
	
				@if( $invoices->total() > $invoices->perPage() )
					{{ $invoices->links('layouts.paginator') }}
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
@endsection
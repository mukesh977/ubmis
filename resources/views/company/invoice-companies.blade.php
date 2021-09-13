<?php $sn = ($salesTransactions->currentPage()-1)*($salesTransactions->perPage()); ?>

@extends('layouts.layouts')
@section('title', 'Ultrabyte | Companies')

@section('content')
	<section class="content">
		<div class="box">
			<div class="box-header">
				<h3 class="box-title">Due Transaction Company</h3>

				<div class="box-tools">
					<form method="get" action="{{ url('/admin/list-company/search') }}">
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
						<th>Company Name</th>
						<th>Address</th>
						<th>Invoice</th>
					</tr>

					@if(!$salesTransactions->isEmpty())
						@foreach( $salesTransactions as $salesTransaction )

						<?php $sn++; ?>

							<tr>
								<td>{{ $sn }}</td>
								<td>{{ $salesTransaction->company->name }}</td>
								<td>{{ $salesTransaction->company->address }}</td>
								<td>
									<a href="{{ url('/invoice-pdf-export/'.$salesTransaction->company->id.'/get') }}" class="btn btn-xs btn-primary link edit" target="_blank" title="Edit">Download Invoice</a> 
								</td>
							</tr>
						@endforeach
					@endif


				</table>
	
				@if( $salesTransactions->total() > $salesTransactions->perPage() )
					{{ $salesTransactions->links('layouts.paginator') }}
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
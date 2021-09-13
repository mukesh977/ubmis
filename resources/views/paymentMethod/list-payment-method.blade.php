<?php $sn = ($listPaymentMethod->currentPage()-1)*($listPaymentMethod->perPage()); ?>

@extends('layouts.layouts')
@section('title', 'Ultrabyte | List Payment Method')

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
				<h3 class="box-title">List Payment Method</h3>

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
						<th>S.N</th>
						<th>Name</th>
						<th>Description</th>
						<th>Action</th>
					</tr>

					@if(!$listPaymentMethod->isEmpty())
						@foreach( $listPaymentMethod as $method )

						<?php $sn++; ?>

							<tr>
								<td>{{ $sn }}</td>
								<td>{{ $method->name }}</td>
								<td>{{ $method->description }}</td>
								<td>
									<a href="{{ url('/admin/payment-method/'.$method->id.'/edit') }}" class="link edit" title="Edit"><i class="fa fa-pencil"></i></a> | 

									<a href="#" class="link delete" title="Delete" data-paymentmethodid="{{ $method->id }}" data-toggle="modal" data-target="#delete"><i class="fa fa-trash-o"></i></a>
								</td>
							</tr>
						@endforeach
					@endif


				</table>

				@if( $listPaymentMethod->total() > $listPaymentMethod->perPage() )
					{{ $listPaymentMethod->links('layouts.paginator') }}
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
						<h4 class="modal-title">Delete Payment Method</h4>
					</div>
					<form method="POST" action="{{ url('/admin/payment-method') }}"> 
						{{ csrf_field() }}
						{{ method_field('DELETE') }}
					<div class="modal-body">
						<p>Are you sure you want to delete this payment method ?</p>
						<input type="hidden" name="method_id_delete" id="method_id_delete" value="">
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

	</section>
@endsection

@section('script')
	<script>
		$(document).ready(function() {

			$('#delete').on('show.bs.modal', function (event) {
				var button = $(event.relatedTarget)
				var method_id_delete = button.data('paymentmethodid')
				var modal = $(this)

				modal.find('.modal-body #method_id_delete').val(method_id_delete);
			});
		});
			
	</script>
@endsection
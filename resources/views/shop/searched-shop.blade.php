<?php $sn = ($searchedShops->currentPage()-1)*($searchedShops->perPage()); ?>

@extends('layouts.layouts')
@section('title', 'Ultrabyte | List Shop')

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
				<h3 class="box-title">Searched Shop</h3>

				<div class="box-tools">
					<form method="get" action="{{ url('/admin/list-shop/search') }}">
						<div class="input-group input-group-sm" style="width: 150px;">
							<input type="text" name="shopName" class="form-control pull-right" value="{{ !empty($searchedWord)? $searchedWord : '' }}" placeholder="Search">

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
						<th>Shop Name</th>
						<th>Address</th>
						<th>Action</th>
					</tr>

					@if(!$searchedShops->isEmpty())
						@foreach( $searchedShops as $shop )

						<?php $sn++; ?>

							<tr>
								<td>{{ $sn }}</td>
								<td>{{ $shop->name }}</td>
								<td>{{ $shop->address }}</td>
								<td>
									<a href="{{ url('/admin/edit-shop/'.$shop->id) }}" class="link edit" title="Edit"><i class="fa fa-pencil"></i></a> | 

									<a href="#" class="link delete" title="Delete" data-shopid="{{ $shop->id }}" data-toggle="modal" data-target="#delete"><i class="fa fa-trash-o"></i></a> |

									<a href="#" class="link view" id="v" title="View" data-viewid="{{ $shop->id }}"><i class="fa fa-eye"></i></a>
								</td>
							</tr>
						@endforeach
					@endif


				</table>

				@if( $searchedShops->total() > $searchedShops->perPage() )
					{{ $searchedShops->links('layouts.paginator') }}
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
						<h4 class="modal-title">Delete Shop</h4>
					</div>
					<form method="POST" action="{{ url('/admin/delete-shop') }}"> 
						{{ csrf_field() }}
					<div class="modal-body">
						<p>Are you sure you want to delete this shop ?</p>
						<input type="hidden" name="shop_id_delete" id="shop_id_delete" value="">
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


      <div class="modal fade" id="shopDetailModal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<label class="supplierModalLabel">Shop Details</label>
					<button class="close" type="button" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">×</span>
					</button>
				</div>
				
				<div class="modal-body">
					<div class="row">
						<div class="col-sm-3">
							<h5 class="supplierResult" style="margin-bottom: 20px;">Shop Name:</h5>
						</div>
						<div class="col-sm-9">
							<h5 id="shopName" class="supplierResult" style="margin-bottom: 20px;"></h5>
						</div>
					</div>

					<div class="row">
						<div class="col-sm-3">
							<h5 class="supplierResult" style="margin-bottom: 20px;">Address:</h5>
						</div>
						<div class="col-sm-9">
							<h5 id="address" class="supplierResult" style="margin-bottom: 20px;"></h5>
						</div>
					</div>

					<div class="row">
						<div class="col-sm-3">
							<h5 class="supplierResult" style="margin-bottom: 20px;">Contact Number:</h5>
						</div>
						<div class="col-sm-9" id="contactNumber" style="margin-bottom: 20px;">
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

	</section>
@endsection

@section('script')
	<script>
		$(document).ready(function() {

			$('#delete').on('show.bs.modal', function (event) {
				var button = $(event.relatedTarget)
				var shop_id_delete = button.data('shopid')
				var modal = $(this)

				modal.find('.modal-body #shop_id_delete').val(shop_id_delete);
			});
		});

		$('.view').on('click', function(e){
				
			e.preventDefault();

			var view_id = $(this).data('viewid');

			$.ajax({
				type: 'get',
				url: '{{ URL::to("/admin/show-shop") }}',
				data: {'id' : view_id},
				success: function(data){
					$('#shopName').html(data.name);
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

			$('#shopDetailModal').on('hidden.bs.modal', function () {
				$('#contactNumber').empty();
			});

		});
	</script>
@endsection
<?php $sn = ($listVisitCategory->currentPage()-1)*($listVisitCategory->perPage()); ?>

@extends('layouts.layouts')
@section('title', 'Ultrabyte | List Visit Category')

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
				<h3 class="box-title">List Visit Category</h3>

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
						<th>Visit Category Name</th>
						<th>Description</th>
						<th>Action</th>
					</tr>

					@if(!$listVisitCategory->isEmpty())
						@foreach( $listVisitCategory as $category )

						<?php $sn++; ?>

							<tr>
								<td>{{ $sn }}</td>
								<td>{{ $category->name }}</td>
								<td>{{ $category->description }}</td>
								<td>
									<a href="{{ url('/admin/edit-visit-category/'.$category->id) }}" class="link edit" title="Edit"><i class="fa fa-pencil"></i></a> | 

									<a href="#" class="link delete" title="Delete" data-visitcategoryid="{{ $category->id }}" data-toggle="modal" data-target="#delete"><i class="fa fa-trash-o"></i></a>
								</td>
							</tr>
						@endforeach
					@endif


				</table>

				@if( $listVisitCategory->total() > $listVisitCategory->perPage() )
					{{ $listVisitCategory->links('layouts.paginator') }}
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
						<h4 class="modal-title">Delete Visit Category</h4>
					</div>
					<form method="POST" action="{{ url('/admin/delete-visit-category') }}"> 
						{{ csrf_field() }}
					<div class="modal-body">
						<p>Are you sure you want to delete this Visit Category ?</p>
						<input type="hidden" name="category_id_delete" id="category_id_delete" value="">
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

	     <div class="modal fade" id="companyDetailModal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<label class="supplierModalLabel">Company Details</label>
						<button class="close" type="button" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>
					</div>
					
					<div class="modal-body">
						<div class="row">
							<div class="col-sm-3">
								<h5 class="supplierResult" style="margin-bottom: 20px;">Company Name:</h5>
							</div>
							<div class="col-sm-9">
								<h5 id="companyName" class="supplierResult" style="margin-bottom: 20px;"></h5>
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
								<h5 class="supplierResult" style="margin-bottom: 20px;">E-mail:</h5>
							</div>
							<div class="col-sm-9" id="email" style="margin-bottom: 20px;">
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
				var category_id_delete = button.data('visitcategoryid')
				var modal = $(this)

				modal.find('.modal-body #category_id_delete').val(category_id_delete);
			});



			$('.view').on('click', function(e){
				
				e.preventDefault();

				var company_id = $(this).data('viewid');

				$.ajax({
					type: 'get',
					url: '{{ URL::to("/admin/show-office") }}',
					data: {'companyId' : company_id},
					success: function(data){

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
				$('#email').empty();
				$('#contactNumber').empty();
			});
		});
	</script>
@endsection
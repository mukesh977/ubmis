<?php $sn = ($dueTasks->perPage() * ($dueTasks->currentPage()-1)); ?>

@extends('layouts.layouts')
@section('title', 'Ultrabyte | Due Tasks')

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
				<h3 class="box-title"> Due Tasks</h3>

				<div class="box-tools search">
					<div class="input-group input-group-sm search_input" style="width: 150px;">
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
						<th>Company Name</th>
						<th>Service</th>
						<th>Remaining Days to expire</th>
						<th>Action</th>
					</tr>

					@if(!$dueTasks->isEmpty())
						@foreach( $dueTasks as $dueTask )
							<?php $sn++; ?>
							<tr>
								<td>{{ $sn }}</td>
								<td>
									<a href="#" class="companyDetail" data-companyid="{{ $dueTask->company_id }}">{{ $dueTask->company->name }}</a>
								</td>

								<td> {{ $dueTask->service->name }}</td>
								
								<td><?php 
								$endDate = new DateTime($dueTask->expiration_date);
	        					$days = $currentDate->diff($endDate)->days;
	        					$updatedExpirationDate = new DateTime($dueTask->updated_expiration_date);

	        					if( $dueTask->updated_expiration_date != NULL )
	        					{
	        						if( $currentDate < $updatedExpirationDate )
	        						{
		        						$updatedExpirationDays = $currentDate->diff($updatedExpirationDate)->days;
		        						echo $updatedExpirationDays.' days (Renewed)';
	        						}
	        						else if( $currentDate == $updatedExpirationDate )
		        						echo 'Today Expiration date';
		        					else
		        					{
		        						$updatedExpirationDays = $currentDate->diff($updatedExpirationDate)->days;
		        						echo $updatedExpirationDays.' days ago (Expired)';
		        					}
	        					}
	        					else
	        					{
	        						if( $currentDate < $endDate )
		        						echo $days.' days';
		        					else if( $currentDate == $endDate )
		        						echo 'Today Expiration date';
		        					else
		        						echo $days.' days ago (Expired)';
	        					}
	        						
									?></td>

								<td>
									<a href="" class="btn btn-success btn-xs" title="Mark as task complete" data-duetaskid="{{ $dueTask->id }}" data-toggle="modal" data-target="#markAsComplete">Mark as task done</a>
								</td>
							</tr>
						@endforeach
					@endif

				</table>

				@if( $dueTasks->total() > $dueTasks->perPage() )
					{{ $dueTasks->links('layouts.paginator') }}
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

	<div class="modal fade" id="markAsComplete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title"> Mark as Tasks Complete </h4>
				</div>
				<form method="POST" action="{{ url('/marked') }}"> 
					{{ csrf_field() }}
				<div class="modal-body">
					<p>Do you want to mark this task as complete ?</p>
					<input type="hidden" name="task_id" id="task_id" value="">
				</div>
				<div class="modal-footer">

					<button class="btn btn-danger" type="button" data-dismiss="modal">Close</button>
					<button class="btn btn-success" id="submit" type="submit">Mark</button>
				</div>
				</form>
			</div>
		<!-- /.modal-content-->
		</div>
	<!-- /.modal-dialog-->
	</div>
  <!-- /.modal-->

	@include('company.partials.company-detail-modal')

@endsection

@section('script')
	<script>
		$('#markAsComplete').on('show.bs.modal', function (event) {
			var button = $(event.relatedTarget);
			var taskid = button.data('duetaskid');
			var modal = $(this);

			modal.find('.modal-body #task_id').val(taskid);
		});

		//company-detail-modal operations


		$('.companyDetail').on('click', function(e){
			
			e.preventDefault();

			var company_id = $(this).data('companyid');

			$.ajax({
				type: 'get',
				url: '{{ URL::to("/show-company-with-field-contact") }}',
				data: {'companyId' : company_id},
				success: function(data){
					// console.log(data);

					$('#companyName').html(data[0].name);
					$('#address').html(data[0].address);

					var i;
					var j;
					var count1 = data[0].emails.length; 

					for( i = 0; i < count1; i++ )
					{
						if( i == (count1-1) )
							$('#email').append('<h5 class="supplierResult inlineblock">'+ data[0].emails[i].email +'</h5>');
						else
							$('#email').append('<h5 class="supplierResult inlineblock">'+ data[0].emails[i].email +',</h5>');
					}


					var count2 = data[1].length;

					for( i = 0; i < count2; i++ )
					{
						var count3 = data[1][i].contact_details.length;

						for( j = 0; j < count3; j++ )
						{
							if( j == (count3-1) )
								$('#contactNumber').append('<h5 class="supplierResult inlineblock">'+ data[1][i].contact_details[j].contact_number +'</h5>');
							else
								$('#contactNumber').append('<h5 class="supplierResult inlineblock">'+ data[1][i].contact_details[j].contact_number +',</h5>');
						}

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
	</script>
@endsection
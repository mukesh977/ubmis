<?php $sn = ($clientFollowUps->currentPage()-1)*($clientFollowUps->perPage()); ?>

@extends('layouts.layouts')
@section('title', 'Ultrabyte | List Client Follow ')

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
				<h3 class="box-title">List Client Follow Up</h3>

				<div class="box-tools" style="display: flex;">

					<div style="margin-right: 10px;">
						<a href="{{ url('/client-follow-up/create') }}" class="btn btn-primary btn-sm">Add Client Follow Up</a>
					</div>

					<div class="input-group input-group-sm" style="width: 150px; ">
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
						<th>Follow Up Date</th>
						<th>Action</th>
					</tr>

					@if(!$clientFollowUps->isEmpty())
						@foreach( $clientFollowUps as $followUp )

						<?php $sn++; ?>

							<tr>
								<td>{{ $sn }}</td>
								<td>
									@foreach( $companies as $company )
										@if( $company->id == $followUp->company_id )
											{{ $company->name }}
										@endif
									@endforeach
								</td>
								<td>{{ $followUp->follow_up_date }}</td>
								<td>
									<a href="{{ url('/client-follow-up/'.$followUp->id.'/edit') }}" class="link edit" title="Edit"><i class="fa fa-pencil"></i></a>

								</td>
							</tr>
						@endforeach
					@endif


				</table>

				@if( $clientFollowUps->total() > $clientFollowUps->perPage() )
					{{ $clientFollowUps->links('layouts.paginator') }}
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


@extends('layouts.layouts')
@section('title', 'Ultrabyte | List Notifications')

@section('content')
	<section class="content">

		@if(!empty(session('successMessage')))
			<div class="alert alert-success success-notification">
		        <a href="#" class="close" data-dismiss="alert">&times;</a>
		        {{ session('successMessage') }}
		    </div>
	    @endif

		@if(!empty(session('unsuccessMessage')))
			<div class="alert alert-danger unsuccess-notification">
		        <a href="#" class="close" data-dismiss="alert">&times;</a>
		        {{ session('unsuccessMessage') }}
		    </div>
		@endif

		<div class="box">
			<div class="box-header">
				<h3 class="box-title">List Notifications</h3>

				<div class="box-tools">
					<div class="input-group input-group-sm" style="width: 150px;">
						<input type="text" name="table_search" class="form-control pull-right" placeholder="Search">

						<div class="input-group-btn">
							<button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
						</div>
					</div>
				</div>
			</div>
			<div class="box-body table-responsive no-padding">
				<table class="table table-hover">
					@if(!empty($notifications))
						@foreach( $notifications as $notification )
							@if( $notification->r_operation == "edit")
								<tr>
									<td>
										<a href="{{ url('/admin/notification/'. $notification->id ) }}" >
											<h5>You have been requested to edit sales account by staff {{ $notification->User->first_name }} {{ $notification->User->last_name }}</h5>
										</a>
									{{-- <a href="{{ url('/admin/notification/'. $notification->r_actual_sale_id ) }}" class="overlay"></a> --}}
									</td>
								</tr>
							@elseif( $notification->r_operation == "delete")
								<tr>
									<td>
										<a href="{{ url('/admin/notification/'. $notification->id ) }}">
										You have been requested to delete sales account by staff {{ $notification->User->first_name }} {{ $notification->User->last_name }}
									</a>
								{{-- <a href="{{ url('/admin/notification/'. $notification->r_actual_sale_id ) }}" class="overlay"></a> --}}
									</td>
								</tr>
							@elseif( $notification->r_operation == "editPurchase" )
								<tr>
									<td>
										<a href="{{ url('/admin/purchase-notification/'. $notification->id ) }}" >
											<h5>You have been requested to edit purchase account by staff {{ $notification->User->first_name }} {{ $notification->User->last_name }}</h5>
										</a>
									</td>
								</tr>
							@else
								<tr>
									<td>
										<a href="{{ url('/admin/purchase-notification/'. $notification->id ) }}">
										You have been requested to delete purchase account by staff {{ $notification->User->first_name }} {{ $notification->User->last_name }}
									</a>
									</td>
								</tr>
							@endif

						@endforeach
					@endif
				</table>

				@if( $notifications->total() > $paginationNumber )
					{{ $notifications->links('layouts.paginator') }}
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
		</div>
		<!-- /.box -->
	
</section>

@endsection
<?php $sn = ($completedTickets->currentPage()-1)*($completedTickets->perPage()); ?>

@extends('layouts.layouts')
@section('title', 'Ultrabyte | Completed Tickets')

@section('content')
	<section class="content">
		@include('message.message')

		<div class="box">
			<div class="box-header">
				<h3 class="box-title">Completed Tickets</h3>

				<div class="box-tools" style="display: flex;">
					@role('client')
						<div style="margin-right: 10px;">
							<a href="{{ url('/tickets/create') }}" class="btn btn-xs btn-primary">Create New Ticket</a>
						</div>
					@endrole
					
					<form method="get" action="{{ url('tickets/search/completed-ticket') }}">
						<div class="input-group input-group-sm" style="width: 150px;">
							<input type="text" name="keyword" class="form-control pull-right" placeholder="Search" value="{{ (isset($subject))? $subject:'' }}">

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
						<th>Subject</th>
						<th>Status</th>
						<th>Updated at</th>
						<th>Agent</th>
						<th>Priority</th>
						<th>Owner</th>
						<th>Category</th>
					</tr>

					@if(!$completedTickets->isEmpty())
						@foreach( $completedTickets as $completedTicket )
							<tr>
								<?php $sn++; ?>

								<td>{{ $sn }}</td>
								<td><a href="{{ url('/tickets/'. $completedTicket->id) }}">{{ str_limit($completedTicket->subject, 50) }}</a></td>
								<td style="color: {{ $completedTicket->status->color }}">{{ $completedTicket->status->display_name }}</td>
								
								<td>{{ \Carbon\Carbon::parse($completedTicket->updated_at)->diffForHumans() }}</td>

								<td>{{ $completedTicket->agent->first_name.' '.$completedTicket->agent->last_name }}</td>

								<td style="color: {{ $completedTicket->priority->color }}">{{ $completedTicket->priority->name }}</td>
								
								<td>{{ $completedTicket->owner->first_name.' '.$completedTicket->owner->last_name }}</td>

								<td style="color: {{ $completedTicket->category->color }}">{{ $completedTicket->category->name }}</td>
								
							</tr>
						@endforeach
					@endif


				</table>

				@if( $completedTickets->total() > $completedTickets->perPage() )
					{{ $completedTickets->links('layouts.paginator') }}
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
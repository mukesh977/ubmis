<?php $sn = ($activeTickets->currentPage()-1)*($activeTickets->perPage()); ?>

@extends('layouts.layouts')
@section('title', 'Ultrabyte | Active Tickets')

@section('content')
	<section class="content">
		@include('message.message')

		<div class="box">
			<div class="box-header">
				<h3 class="box-title">Active Tickets</h3>

				<div class="box-tools" style="display: flex;">
					@role('client')
						<div style="margin-right: 10px;">
							<a href="{{ url('/tickets/create') }}" class="btn btn-xs btn-primary">Create New Ticket</a>
						</div>
					@endrole

					<form method="get" action="{{ url('tickets/search/active-ticket') }}">
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

					@if(!$activeTickets->isEmpty())
						@foreach( $activeTickets as $activeTicket )
							<tr>
								<?php $sn++; ?>

								<td>{{ $sn }}</td>
								<td><a href="{{ url('/tickets/'. $activeTicket->id) }}">{{ str_limit($activeTicket->subject, 50) }}</a></td>
								<td style="color: {{ $activeTicket->status->color }}">{{ $activeTicket->status->display_name }}</td>
								
								<td>{{ \Carbon\Carbon::parse($activeTicket->updated_at)->diffForHumans() }}</td>

								<td>{{ $activeTicket->agent->first_name.' '.$activeTicket->agent->last_name }}</td>

								<td style="color: {{ $activeTicket->priority->color }}">{{ $activeTicket->priority->name }}</td>
								
								<td>{{ $activeTicket->owner->first_name.' '.$activeTicket->owner->last_name }}</td>

								<td style="color: {{ $activeTicket->category->color }}">{{ $activeTicket->category->name }}</td>
								
							</tr>
						@endforeach
					@endif


				</table>

				@if( $activeTickets->total() > $activeTickets->perPage() )
					{{ $activeTickets->links('layouts.paginator') }}
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
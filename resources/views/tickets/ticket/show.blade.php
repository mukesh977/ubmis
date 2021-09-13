@extends('layouts.layouts')
@section('title', 'Ultrabyte | Active Tickets')

@section('content')
<section class="content">
	@include('message.message')
	@include('tickets.ticket.modals.edit')
	@include('tickets.ticket.modals.delete-modal')

	<div class="box">
		<div class="box-header with-border">
			<h3 class="box-title">{{ $ticket->subject }}</h3>

			<div class="box-tools">
				@if( is_null($ticket->completed_at) )
					<a href="{{ url('/tickets/'. $ticket->id .'/complete') }}" class="btn btn-xs btn-success">Mark Complete</a>
				@else
					<a href="{{ url('/tickets/'. $ticket->id .'/reopen') }}" class="btn btn-xs btn-success">Reopen Ticket</a>
				@endif

				@role(['admin', 'agent'])
					<a href="#" class="btn btn-xs btn-primary" id="edit">Edit</a>
				@endrole

				@role('admin')
					<a href="#" class="btn btn-xs btn-danger delete" data-ticketid="{{ $ticket->id }}" data-toggle="modal" data-target="#delete">Delete</a>
				@endrole

			</div>
		</div>
		<!-- /.box-header -->
		<div class="box-body">
			<div class="box-shadow">
				<div class="row" style="border: 2px;">
					
					<div class="col-md-6">
						<div class="row">
							<div class="col-md-3">
								<p><strong>Owner</strong>:</p>

								<p><strong>Status</strong>:</p>

								<p><strong>Priority</strong>:</p>
							</div>
							<div class="col-md-9">
								<p>{{ $ticket->owner->first_name.' '.$ticket->owner->last_name }}</p>

								<p><span style="color: {{ $ticket->status->color }}">{{ $ticket->status->display_name }}</span></p>

								<p><span style="color: {{ $ticket->priority->color }}">{{ $ticket->priority->name }}</span></p>
							</div>
						</div>
					</div>

					<div class="col-md-6">
						<div class="row">
							<div class="col-md-3">
								<p><strong>Responsible</strong>:</p>

								<p><strong>Category</strong>:</p>

								<p><strong>Created</strong>:</p>

								<p><strong>Last Update</strong>:</p>
							</div>

							<div class="col-md-9">
								<p>{{ $ticket->agent->first_name.' '.$ticket->agent->last_name }}</p>

								<p><span style="color: {{ $ticket->category->color }}">{{ $ticket->category->name }}</span></p>

								<p>{{ \Carbon\Carbon::parse($ticket->created_at)->diffForHumans() }}</p>

								<p>{{ \Carbon\Carbon::parse($ticket->updated_at)->diffForHumans() }}</p>

							</div>
						</div>
					</div>
				</div>
			</div>

			<p>{!! $ticket->description !!}</p>		
		</div>
		<!-- /.box-body -->
	</div>
	<!-- /.box -->

	<h2 class="mt-15">Comments</h2>

	@foreach( $ticket->comment as $comment )
		<div class="comment-section">

			<div class="comment-avatar">
				<img alt="" class="avatar" src="{{asset('img/avatar.png')}}">		
			</div><!-- .comment-avatar -->

			<div class="comment-meta">
				<cite class="comment-author">{{ $comment->user->first_name.' '.$comment->user->last_name }} <span class="says">says</span></cite>
				<time class="comment-published"><i class="fa fa-calendar"></i> {{ \Carbon\Carbon::parse($comment->created_at)->diffForHumans() }}</time>
			</div><!-- .comment-meta -->

			<div class="comment-content">
				{!! $comment->content !!}
			</div><!-- .comment-content -->
		</div>
	@endforeach

	<form class="mt-20" method="post" action="{{ url('/tickets/comment') }}">
		{{ csrf_field() }}
		<textarea class="form-control" name="comment" id="comment"></textarea>
		<input type="hidden" name="ticketId" value="{{ $ticket->id }}">
		<input type="submit" class="btn btn-primary mt-20" value="Reply">
	</form>

</section>
@endsection

@section('script')
	<script src="{{ asset('js/ckeditor/ckeditor.js') }}"></script>
	<script>
		CKEDITOR.replace('comment');
		CKEDITOR.replace('description');
		CKEDITOR.config.height = 100;

		$('#edit').click(function(e){
	    e.preventDefault();
	    $('#ticket-edit-modal').modal('show');
		});

		$('#delete').on('show.bs.modal', function (event) {
			var button = $(event.relatedTarget);
			var ticket_id_delete = button.data('ticketid');
			var modal = $(this);

			modal.find('.modal-body #ticket_id_delete').val(ticket_id_delete);
		});
 
	</script>
@endsection
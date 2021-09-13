<div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Delete Ticket</h4>
			</div>
			<form method="POST" action="{{ url('/tickets/delete') }}"> 
				{{ csrf_field() }}
				<div class="modal-body">
					<p>Are you sure you want to delete this ticket ?</p>
					<input type="hidden" name="ticket_id_delete" id="ticket_id_delete" value="">
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
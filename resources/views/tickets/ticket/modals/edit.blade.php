<div class="modal fade" id="ticket-edit-modal" tabindex="-1" role="dialog" aria-labelledby="ticket-edit-modal-Label">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content" style="padding: 20px;">
      <form class="form-horizontal" method="POST" action="">
        {{ csrf_field() }}
        {{ method_field('patch') }}
        <div class="modal-header" style="padding-left: 0px;">
          <h4 class="modal-title" id="ticket-edit-modal-Label"><b>{{ $ticket->subject }}</b></h4>
        </div>
        <div class="modal-body">
          <div class="form-group">
            
            <input type="text" class="form-control" name="subject" value="{{ $ticket->subject }}" required> 

          </div>
          <div class="form-group">
            <textarea class="form-control" id="description" name="description" required>{{ $ticket->description }}</textarea>
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="priority">Priority: </label>
                <select class="form-control" name="priority">
                  <option value="">Select Priority</option>

                  @foreach( $priorities as $priority )
                    <option value="{{ $priority->id }}" {{ ($ticket->priority->id == $priority->id)? 'selected' : '' }}>{{ $priority->name }}</option>
                  @endforeach
                </select>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label for="agent">Agent: </label>
                <select class="form-control" name="agent">
                  <option value="">Select Agent</option>

                  @foreach( $agents as $agent )
                    <option value="{{ $agent->id }}" {{ ($ticket->agent->id == $agent->id)? 'selected' : '' }}>{{ $agent->first_name.' '.$agent->last_name }}</option>
                  @endforeach
                </select>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="category">Category: </label>
                <select class="form-control" name="category">
                  <option value="">Select Category</option>

                  @foreach( $categories as $category )
                    <option value="{{ $category->id }}" {{ ($ticket->category->id == $category->id)? 'selected' : '' }}>{{ $category->name }}</option>
                  @endforeach
                </select>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label for="status">Status: </label>
                <select class="form-control" name="status">
                  <option value="">Select Status</option>

                  @foreach( $statuses as $status )
                    <option value="{{ $status->id }}" {{ ($ticket->status->id == $status->id)? 'selected' : '' }}>{{ $status->name }}</option>
                  @endforeach
                </select>
              </div>
            </div>
          </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <input type="submit" class="btn btn-primary" value="Submit">
        </div>
      </form>
    </div>
  </div>
</div>
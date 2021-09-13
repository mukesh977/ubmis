@extends('layouts.layouts')
@section('title', 'Ultrabyte | Add Tickets')

@section('content')
	<section class="content">
		@include('message.message')

		<div class="box box-primary">
			<form class="form-horizontal" method="post" action="{{ url('/tickets') }}">
				{{ csrf_field() }}
					
				<div class="box-header with-border">
					<h3 class="box-title">Create New Ticket</h3>
				</div>

				<div class="box-body">
					<div class="form-group row mb-30">
            <label for="subject" class="col-md-2 control-label">Subject:</label> 
            <div class="col-lg-10">
              <input type="text" class="form-control" name="subject" value="{{ old('subject') }}">
              <small class="form-text text-muted">A brief of your issue ticket</small>

              @if ($errors->has('subject'))
			          <span class="help-block" style="color: #f86c6b;">{{ $errors->first('subject') }}</span>
				      @endif

            </div>
	        </div>

	        <div class="form-group row mb-30">
            <label for="description" class="col-md-2 control-label">Description:</label> 
            <div class="col-lg-10">
              <textarea class="form-control" name="description" id="description">
              	 {{ old('description') }}
              </textarea>
              <small class="form-text text-muted">Describe your issue here in details</small>

              @if ($errors->has('description'))
			          <span class="help-block" style="color: #f86c6b;">{{ $errors->first('description') }}</span>
				      @endif

            </div>
	        </div>

	        <div class="form-group row mb-30">
            <label for="priority" class="col-md-2 control-label">Priority:</label> 
            <div class="col-lg-4">
              <select class="form-control" name="priority">
              	<option value="">Select priority</option>

              	@foreach( $priorities as $priority )
	              	<option value="{{ $priority->id }}" {{ (old('priority') == $priority->id)?'selected':'' }}> {{$priority->name}} </option>
	              @endforeach

              </select>

              @if ($errors->has('priority'))
			          <span class="help-block" style="color: #f86c6b;">{{ $errors->first('priority') }}</span>
				      @endif

            </div>

            <label for="category" class="col-md-2 control-label">Category:</label> 
            <div class="col-lg-4">
              <select class="form-control" name="category">
              	<option value="">Select Category</option>

              	@foreach( $categories as $category )
	              	<option value="{{ $category->id }}" {{ (old('category') == $category->id)?'selected':'' }}>{{ $category->name }}</option>
	              @endforeach

              </select>

              @if ($errors->has('category'))
			          <span class="help-block" style="color: #f86c6b;">{{ $errors->first('category') }}</span>
				      @endif

            </div>
	        </div>

				</div>
				<!-- /.box-body -->

				<div class="box-footer">
					<input type="submit" class="btn btn-primary pull-right" value="Submit">
				</div>
				<!-- box-footer -->
			</form>

		</div>
		<!-- /.box -->
	</section>
@endsection

@section('script')
	<script src="{{ asset('js/ckeditor/ckeditor.js') }}"></script>
	<script>
		CKEDITOR.replace('description');
	</script>
@endsection
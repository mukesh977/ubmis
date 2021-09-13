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

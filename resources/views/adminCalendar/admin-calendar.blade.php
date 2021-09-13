@extends('layouts.layouts')
@section('title', 'Ultrabyte | Admin Calender')

@section('content')
<section class="content">
	<div class="row">
		<div class="col-md-12">
			<div class="box box-primary">
				<div class="box-header with-border">

					<h3 class="box-title">Notification Calendar</h3>

				</div>
				<div class="box-body no-padding">
						<div id="c">
						</div>
				</div>
			</div>
		</div>
	</div>
</section>
@endsection

@section('script')
	<script>
		$(document).ready(function() {

		  // page is now ready, initialize the calendar...
		    
		    $('#c').fullCalendar({
		      header    : {
		        left  : 'prev,next today',
		        center: 'title',
		        right : 'month,agendaWeek,agendaDay'
		      },
		      buttonText: {
		        today: 'today',
		        month: 'month',
		        week : 'week',
		        day  : 'day'
		      },
		      //Random default events
		      events    : [
		      	@foreach( $employees as $employee )
		        {
		        	<?php $date = Carbon\Carbon::createFromFormat('Y-m-d', $employee->date_of_birth)->setTime(0,0); ?>
		          title          : 'Birthday: {{ $employee->name }}',
		          start          : '{{ Carbon\Carbon::now()->year .'-'. $date->month.'-'.$date->day }}',
		          backgroundColor: '#00a65a', //green
		          borderColor    : '#00a65a' //green
		        },
		       @endforeach

		       @foreach( $clientFollowUp as $followUp )
		       	{
		          title          : 'Call: <?php echo addslashes($followUp->company->name); ?>',
		          start          : '{{ $followUp->follow_up_date }}',
		          backgroundColor: '#00a65a', //green
		          borderColor    : '#00a65a' //green
		        },
		       @endforeach
		        	
		      ],
		      editable  : false,
		      droppable : false // this allows things to be dropped onto the calendar !!!
		      
		    });

		});
	</script>
@endsection
@extends('layouts.layouts')
@section('title', 'Ultrabyte | Calender Workloads')

@section('content')
<section class="content">
	<div class="row">
		<div class="col-md-12">
			<div class="box box-primary">
				<div class="box-header with-border">

					<h3 class="box-title">Field Visit Follow Up</h3>


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
		      @foreach( $visitDatas as $visitData )
		        {
		          title          : '{{ $visitData->companies->name }}',
		          start          : '{{ $visitData->next_visit_date }}',
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
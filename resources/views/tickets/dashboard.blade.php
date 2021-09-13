@extends('layouts.layouts')
@section('title', 'Ultrabyte | Tickets')

@section('content')
<section class="content">
	<div class="row mb-5">
    <div class="col-md-4 col-sm-6 col-xs-12">
        <div class="info-box">
            <span class="info-box-icon bg-yellow"><i class="glyphicon glyphicon-th"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">Total Tickets</span>
                <span class="info-box-number">{{ $totalTickets }}</span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <!-- /.col -->
    <div class="col-md-4 col-sm-6 col-xs-12">
        <div class="info-box">
            <span class="info-box-icon bg-red"><i class="glyphicon glyphicon-wrench"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">Open Tickets</span>
                <span class="info-box-number">{{ $openTickets }}</span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <!-- /.col -->

    <!-- fix for small devices only -->
    <div class="clearfix visible-sm-block"></div>

    <div class="col-md-4 col-sm-6 col-xs-12">
        <div class="info-box">
            <span class="info-box-icon bg-green"><i class="glyphicon glyphicon-thumbs-up"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">Closed Tickets</span>
                <span class="info-box-number">{{ $closedTickets }}</span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <!-- /.col -->
  </div>

	<div class="row mb-15">   
	  <div class="col-md-6">
			<div id="categoriesChart" style="height: 300px; width: 100%;"></div>
		</div>

		<div class="col-md-6">
			<div id="agentsChart" style="height: 300px; width: 100%;"></div>
		</div> 
	</div>

	<div class="row mb-5">
	  <div class="col-md-6">
	    <!-- Custom Tabs -->
	    <div class="nav-tabs-custom">
	      <ul class="nav nav-tabs">
	        <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true"><i class="glyphicon glyphicon-folder-close mr-10"></i> Categories</a></li>
	        <li class=""><a href="#tab_2" data-toggle="tab" aria-expanded="false"><i class="fa fa-user-secret mr-10"></i>Agents</a></li>
	        <li class=""><a href="#tab_3" data-toggle="tab" aria-expanded="false"><i class="glyphicon glyphicon-user mr-10"></i>Users</a></li>
	        
	        
	      </ul>
	      <div class="tab-content">
	        <div class="tab-pane active" id="tab_1">

	        	<div class="tab_content">
		          <p>
		          	<span>Category</span><span class="badge">Total</span>
		          	<em>Open / Closed</em>
		          </p>
		        </div>

		        @foreach( $categories as $category )
			        <div class="tab_content">
			          <p>
			          	<span style="color: {{ $category->color }}">{{ $category->name }}</span><span class="badge">{{ $category->tickets()->count() }}</span>
			          	<em>{{ $category->tickets()->whereNull('completed_at')->count() }} / {{ $category->tickets()->whereNotNull('completed_at')->count() }}</em>
			          </p>
			        </div>
			      @endforeach

	        </div>
	        <!-- /.tab-pane -->
	        <div class="tab-pane" id="tab_2">
	          <div class="tab_content">
		          <p>
		          	<span>Agent</span><span class="badge">Total</span>
		          	<em>Open / Closed</em>
		          </p>
		        </div>

		        @foreach( $agents as $agent )
			        <div class="tab_content">
			          <p>
			          	<span>{{ $agent->name() }}</span><span class="badge">{{ $agent->tickets()->count() }}</span>
			          	<em>{{ $agent->agentTickets(false)->count() }} / {{ $agent->agentTickets(true)->count() }}</em>
			          </p>
			        </div>
			      @endforeach
	        </div>
	        <!-- /.tab-pane -->
	        <div class="tab-pane" id="tab_3">
	          <div class="tab_content">
		          <p>
		          	<span>Client</span><span class="badge">Total</span>
		          	<em>Open / Closed</em>
		          </p>
		        </div>

		        @foreach( $clients as $client )
			        <div class="tab_content">
			          <p>
			          	<span>{{ $client->name() }}</span><span class="badge">{{ $client->tickets()->count() }}</span>
			          	<em>{{ $client->clientTickets($client->id, false)->count() }} / {{ $client->clientTickets($client->id, true)->count() }}</em>
			          </p>
			        </div>
			      @endforeach
	        </div>
	        <!-- /.tab-pane -->
	      </div>
	      <!-- /.tab-content -->
	    </div>
	    <!-- nav-tabs-custom -->
	  </div>

	</div>
</section>

@endsection

@section('script')
	<script src="{{ asset('js/chart/canvasjs.min.js') }}"></script>
	<script>
		var chart1 = new CanvasJS.Chart("categoriesChart", {
			animationEnabled: true,
			title: {
				text: "Tickets distribution per category"
			},
			data: [{
				type: "pie",
				startAngle: 240,
				yValueFormatString: "##0.00\"%\"",
				indexLabel: "{label} {y}",
				dataPoints: [
					@foreach($categories as $cat)
						{y: {{ $categoriesPercentage[$cat->name] }}, label: "{{ $cat->name }}"},
					@endforeach
					
				]
			}]
		});
		chart1.render();

		var chart2 = new CanvasJS.Chart("agentsChart", {
			animationEnabled: true,
			title: {
				text: "Tickets distribution per agent"
			},
			data: [{
				type: "pie",
				startAngle: 240,
				yValueFormatString: "##0.00\"%\"",
				indexLabel: "{label} {y}",
				dataPoints: [
					@foreach($agents as $agent)
						{y: {{ $agentsPercentage[$agent->name()] }}, label: "{{ $agent->name() }}"},
					@endforeach
					
				]
			}]
		});
		chart2.render();
	</script>
@endsection


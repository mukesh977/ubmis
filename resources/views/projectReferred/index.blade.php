@extends('layouts.layouts')
@section('title', 'Ultrabyte | List Project Referred Relationship')

@section('content')

<section class="content">
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

		<div class="box">
			<div class="box-header">
				<h3 class="box-title">List Project Referred Relationship</h3>

				<div class="box-tools" style="display: flex;">
					
					<div style="margin-right: 10px;">
						<a href="{{ url('/admin/referred/create') }}" class="btn btn-primary btn-sm">Add</a>
					</div>

					<div style="margin-right: 10px;">
						<a href="{{ url('/admin/referred/edit') }}" class="btn btn-primary btn-sm">Edit</a>
					</div>

					<form method="get" action="">
						<div class="input-group input-group-sm" style="width: 150px;">
							<input type="text" name="companyName" class="form-control pull-right" placeholder="Search">

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
						<th>Sales Code</th>
						<th>Referred</th>
					</tr>

					@if(!empty($resultArray))
						@foreach( $resultArray as $result )
							<tr>
								<td>{{ $result[0]->salesTransaction->sales_code }}</td>
								<td>
									<?php 
										$countResult = (count($result)) - 1;
																	 
										echo $result[0]->salesTransaction->referredBy->first_name.' '.$result[0]->salesTransaction->referredBy->last_name.' <= ';

										foreach( $result as $index => $r )
										{
											if( $countResult == $index )
												echo $r->parent->first_name. ' '. $r->parent->last_name; 
											else
												echo $r->parent->first_name. ' '. $r->parent->last_name. ' <= ';
										}
									?>
								</td>
							</tr>
						@endforeach
					@endif


				</table>

				
			</div>
			<!-- /.box-body -->
		</div>
		<!-- /.box -->

	</section>
@endsection


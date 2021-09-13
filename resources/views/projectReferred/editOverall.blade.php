@extends('layouts.layouts')
@section('title', 'Ultrabyte | Edit')

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
				<h3 class="box-title">Edit Project Referred Relationship</h3>

				<div class="box-tools" style="display: flex;">
					
					<div style="margin-right: 10px;">
						<a href="{{ url('/admin/referred/create') }}" class="btn btn-primary btn-sm">Add</a>
					</div>

					<div style="margin-right: 10px;">
						<a href="{{ url('/admin/referred') }}" class="btn btn-primary btn-sm">List</a>
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
						<th>Company Name</th>
						<th>Name</th>
						<th>Action</th>

					</tr>

					<?php $id = array(); ?>

					@if(!$editParentChild->isEmpty())
						@foreach( $editParentChild as $edit )
							@if( !in_array($edit->parent->id, $id))
								<tr>
									<td>{{ $edit->salesTransaction->sales_code }}</td>
									<td>{{ $edit->salesTransaction->company->name }}</td>
									<td>{{ $edit->parent->first_name.' '.$edit->parent->last_name }}</td>
									<td>
										<a href="{{ url('/admin/referred/'. $edit->parent->id .'/edit/'.$edit->salesTransaction->id) }}" class="link edit" title="Edit"><i class="fa fa-pencil"></i></a> | 

										<a href="#" class="link delete" title="Delete" data-companyid="" data-toggle="modal" data-target="#delete"><i class="fa fa-trash-o"></i></a>

									</td>
								</tr>
								<?php $id[] = $edit->parent->id; ?>
							@endif

							@if( !in_array($edit->child->id, $id ))
							<tr>
								<td>{{ $edit->salesTransaction->sales_code }}</td>
								<td>{{ $edit->salesTransaction->company->name }}</td>
								<td>{{ $edit->child->first_name.' '.$edit->child->last_name }}</td>
								<td>
									<a href="{{ url('/admin/referred/'. $edit->child->id .'/edit/'.$edit->salesTransaction->id) }}" class="link edit" title="Edit"><i class="fa fa-pencil"></i></a> | 

									<a href="#" class="link delete" title="Delete" data-companyid="" data-toggle="modal" data-target="#delete"><i class="fa fa-trash-o"></i></a> 

								</td>
							</tr>

							<?php $id[] = $edit->child->id; ?>
							@endif

						@endforeach
					@endif

				</table>

				
			</div>
			<!-- /.box-body -->
		</div>
		<!-- /.box -->

	</section>
@endsection


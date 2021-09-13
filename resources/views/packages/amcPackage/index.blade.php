<?php $sn = ($amcPackages->currentPage()-1)*($amcPackages->perPage()); ?>

@extends('layouts.layouts')
@section('title', 'Ultrabyte | List AMC Attribute')

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
				<h3 class="box-title">List AMC Attribute</h3>

				<div class="box-tools" style="display: flex;">

					<div style="margin-right: 10px;">
						<a href="{{ url('/admin/amc-package/create') }}" class="btn btn-primary btn-sm">Add AMC Attribute</a>
					</div>

					<div class="input-group input-group-sm" style="width: 150px; ">
						<input type="text" name="table_search" class="form-control pull-right" placeholder="Search">

						<div class="input-group-btn">
							<button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
						</div>

					</div>
				</div>
			</div>
			<!-- /.box-header -->
			<div class="box-body table-responsive no-padding">
				<table class="table table-hover">
					<tr>
						<th>S.N</th>
						<th>AMC Attribute Name</th>
						<th>Action</th>
					</tr>

					@if(!$amcPackages->isEmpty())
						@foreach( $amcPackages as $amcPackage )

						<?php $sn++; ?>

							<tr>
								<td>{{ $sn }}</td>
								<td>{{ $amcPackage->name }}</td>
								<td>
									<a href="{{ url('/admin/amc-package/'.$amcPackage->id.'/edit') }}" class="link edit" title="Edit"><i class="fa fa-pencil"></i></a>

								</td>
							</tr>
						@endforeach
					@endif


				</table>

				@if( $amcPackages->total() > $amcPackages->perPage() )
					{{ $amcPackages->links('layouts.paginator') }}
		        @else
					<div class="box-footer clearfix">
		              <ul class="pagination pagination-sm no-margin pull-right">
		                <li><a href="#">&laquo;</a></li>
		                <li><a href="#">1</a></li>
		                <li><a href="#">&raquo;</a></li>
		              </ul>
		            </div>
	            @endif
			</div>
			<!-- /.box-body -->
		</div>
		<!-- /.box -->
	</section>
@endsection


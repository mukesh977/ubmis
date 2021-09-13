<?php $sn = ($seoPackages->currentPage()-1)*($seoPackages->perPage()); ?>

@extends('layouts.layouts')
@section('title', 'Ultrabyte | List Seo Packages')

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
				<h3 class="box-title">List Seo Packages</h3>

				<div class="box-tools" style="display: flex;">

					<div style="margin-right: 10px;">
						<a href="{{ url('/admin/seo-package/create') }}" class="btn btn-primary btn-sm">Add Seo Packages</a>
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
						<th>Seo Package Name</th>
						<th>Price</th>
						<th>Action</th>
					</tr>

					@if(!$seoPackages->isEmpty())
						@foreach( $seoPackages as $seoPackage )

						<?php $sn++; ?>

							<tr>
								<td>{{ $sn }}</td>
								<td>{{ $seoPackage->name }}</td>
								<td>{{ $seoPackage->price }}</td>
								<td>
									<a href="{{ url('/admin/seo-package/'.$seoPackage->id.'/edit') }}" class="link edit" title="Edit"><i class="fa fa-pencil"></i></a>

								</td>
							</tr>
						@endforeach
					@endif


				</table>

				@if( $seoPackages->total() > $seoPackages->perPage() )
					{{ $seoPackages->links('layouts.paginator') }}
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


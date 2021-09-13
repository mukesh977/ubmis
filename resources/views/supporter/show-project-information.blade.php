<?php $sn = 0; ?>

@extends('layouts.layouts')
@section('title', 'Ultrabyte | Show Project Information')

@section('content')
	<section class="content-header">
		<small class="md-txt">Welcome @if(Auth::user()->hasRole('admin') == '1')Administrator @else {{ Auth::user()->first_name.' '.Auth::user()->last_name }} @endif, <a href="https://www.google.com/maps/place/3720+Emerald+St,+Torrance,+CA+90503/@33.8403836,-118.3543828,17z/data=!4m18!1m15!4m14!1m6!1m2!1s0x80c2b4d407f58b11:0xdedca55964c89054!2s3720+Emerald+St,+Torrance,+CA+90503!2m2!1d-118.3520761!2d33.8403792!1m6!1m2!1s0x80c2b4d407f58b11:0xdedca55964c89054!2s3720+Emerald+St,+Torrance,+CA+90503!2m2!1d-118.3520761!2d33.8403792!3m1!1s0x80c2b4d407f58b11:0xdedca55964c89054" target="_blank"><i class="fa fa-map-marker rad-txt-danger"></i> Nepal</a></small>
		<ol class="breadcrumb">
			<li><a href="{{route('home')}}"><i class="fa fa-dashboard"></i>Home</a></li>
			<li class="{{route('users-sales.index')}}">Project Information</li>
		</ol>
	</section>

	<section class="content">
		<div class="row">
			<div class="col-md-12">
				<div class="box box-primary">
					<div class="box-header with-border">
						
						<h3 class="box-title">Project Information</h3>

					</div>
					<div class="box-body">
						<div class="form-horizontal">

							<h4 style="text-align: center;"><b>Ultrabyte International Pvt. Ltd.</b></h4>

							<h5 style="text-align: center;"><b>Maitidevi, Kathmandu</b></h5>

							<table class="table table-responsive-sm table-bordered" style="margin-top: 20px; margin-bottom: 35px; ">
								<thead>
									<tr>
										<th width="7%" class="pl-20">S.N</th>
										<th width="18%" class="pl-20">Sales Code</th>
										<th width="17%" class="pl-20">Date</th>
										<th width="40%" class="pl-20">Company Name</th>
										<th width="18%" class="pl-20">Total Amount</th>
									</tr>
								</thead>
								<tbody>
									@foreach( $salesTransactions as $salesTransaction )
									<?php $sn++; ?>
										<tr>
											<td class="pl-20">
												{{ $sn }}
											</td>

											<td>
												{{ !empty($salesTransaction->sales_code)? $salesTransaction->sales_code : '' }}
											</td>

											<td class="pl-20">
												{{ !empty($salesTransaction->date)? \Carbon\Carbon::parse($salesTransaction->date)->format('F j, Y') : '' }}
											</td>

											<td class="pl-20">
												{{ !empty($salesTransaction->company->name)? $salesTransaction->company->name : '' }}
											</td>

											<td class="pl-20">
												{{ !empty($salesTransaction->total_amount)? $salesTransaction->total_amount : '' }}
											</td>
										</tr>

									@endforeach

									<td colspan="4" class="pl-20">
										<h5 class="pl-76"><b>Total</b></h5>
									</td>

									<td class="pl-20">
										<h5><b>{{ !empty($totalAmount)? $totalAmount : '' }} /-</b></h5>
									</td>

								</tbody>

							</table>

						</div>
					</div>

				</div>
				<!-- /.box-body -->
			</div>
			<!-- /.box -->
		</div>
		<!-- /.col (right) -->
	</section>

@endsection


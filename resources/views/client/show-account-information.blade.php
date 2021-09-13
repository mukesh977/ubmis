<?php $sn = 0; ?>

@extends('layouts.layouts')
@section('title', 'Ultrabyte | Add Sales')

@section('content')
	<section class="content-header">
		<small class="md-txt">Welcome @if(Auth::user()->hasRole('admin') == '1')Administrator @else {{ Auth::user()->first_name.' '.Auth::user()->last_name }} @endif, <a href="https://www.google.com/maps/place/3720+Emerald+St,+Torrance,+CA+90503/@33.8403836,-118.3543828,17z/data=!4m18!1m15!4m14!1m6!1m2!1s0x80c2b4d407f58b11:0xdedca55964c89054!2s3720+Emerald+St,+Torrance,+CA+90503!2m2!1d-118.3520761!2d33.8403792!1m6!1m2!1s0x80c2b4d407f58b11:0xdedca55964c89054!2s3720+Emerald+St,+Torrance,+CA+90503!2m2!1d-118.3520761!2d33.8403792!3m1!1s0x80c2b4d407f58b11:0xdedca55964c89054" target="_blank"><i class="fa fa-map-marker rad-txt-danger"></i> Nepal</a></small>
		<ol class="breadcrumb">
			<li><a href="{{route('home')}}"><i class="fa fa-dashboard"></i>Home</a></li>
			<li class="{{route('users-sales.index')}}">Account Information</li>
		</ol>
	</section>

	<section class="content">
		<div class="row">
			<div class="col-md-12">
				<div class="box box-primary">
					<div class="box-header with-border">
						
						<h3 class="box-title">Account Information</h3>

					</div>
					<div class="box-body">
						<div class="form-horizontal">

							<h4 style="text-align: center;"><b>{{ $company->name }}</b></h4>
							<h5 style="text-align: center;"><b>{{ $company->address }}</b></h5>

							<table class="table table-responsive-sm table-bordered" style="margin-top: 20px; margin-bottom: 35px; ">
								<thead>
									<tr>
										<th width="7%" class="pl-20">S.N</th>
										<th width="17%" class="pl-20">Date</th>
										<th width="40%" class="pl-20">Particulars</th>
										<th width="18%" class="pl-20">Debit</th>
										<th width="18%" class="pl-20">Credit</th>
									</tr>
								</thead>
								<tbody>
									@foreach( $salesTransactions as $salesTransaction )
										<?php 
											$countSTI = $salesTransaction->salesTransactionsItem->count();
											$countSTIF = $salesTransaction->salesTransactionsItemFb->count();
											$countFbItems = (( $countSTIF > 0)? ($countSTIF - 1) : 0);

											$rowSpan = $countSTI + $countFbItems; 
											$flag = 1;
											$sn++;
										?>

										@foreach( $salesTransaction->salesTransactionsItem as $item )
											
											<?php 
												$information = '';

												if( $item->salesCategory->slug == "seo" )
												{
													foreach( $seoPackages as $seoPackage )
													{
														if( $seoPackage->slug == $item->information )
														{
															$information = $seoPackage->name;
														}
													}

												}
												else if( $item->salesCategory->slug == "amc-(annual-maintenance-charge)")
												{
													foreach( $amcPackages as $amcPackage )
													{
														if( $amcPackage->slug == $item->information )
														{
															$information = $amcPackage->name;
														}
													}
												}
												else
												{
													$information = $item->information;
												}

											?>

											@if( $item->salesCategory->slug != "facebook" )
												<tr>
													@if( $flag == 1 )
														<td class="pl-20" rowspan="{{ $rowSpan }}">
															{{ $sn }}
														</td>
													@endif

													@if( $flag == 1 )
														<td class="pl-20" rowspan="{{ $rowSpan }}">
															{{ \Carbon\Carbon::parse($salesTransaction->date)->format('F j, Y') }}
														</td>
													@endif

													<td class="pl-20">
														{{ $item->salesCategory->name .' - '. $information }}
													</td>

													<td class="pl-20">
														{{ $item->total_price }}
													</td>

													@if( $flag == 1 )
														<?php $flag = 0; ?>
														<td class="pl-20" rowspan="{{ $rowSpan }}">
															{{ $salesTransaction->total_paid_amount }}
														</td>
													@endif
												</tr>
											@else
												@foreach( $salesTransaction->salesTransactionsItemFb as $fbItem )
												<tr>
													@if( $flag == 1 )
														<td class="pl-20" rowspan="{{ $rowSpan }}">
															{{ $sn }}
														</td>
													@endif

													@if( $flag == 1 )
														<td class="pl-20" rowspan="{{ $rowSpan }}">
															{{ \Carbon\Carbon::parse($salesTransaction->date)->format('F j, Y') }}
														</td>
													@endif

													<td class="pl-20">
														{{ $item->salesCategory->name .' - '. $fbItem->particulars }}
													</td>

													<td class="pl-20">
														{{ $fbItem->total }}
													</td>
													
													@if( $flag == 1 )
														<?php $flag = 0; ?>
														<td class="pl-20" rowspan="{{ $rowSpan }}">
															{{ $salesTransaction->total_paid_amount }}
														</td>
													@endif

												</tr>
												@endforeach
											@endif
										@endforeach
									@endforeach

									<td colspan="3" class="pl-20">
										<h5 class="pl-76"><b>Total</b></h5>
									</td>

									<td class="pl-20">
										<h5><b>{{ $totalAmount }} /-</b></h5>
									</td>

									<td class="pl-20">
										<h5><b>{{ $totalPaidAmount }} /-</b></h5>
									</td>

								</tbody>


							</table>

							<h5 class="pl-97">
								<b>Due Amount: <u>{{ $dueAmount }}</u> /-</b>
							</h5>
						
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


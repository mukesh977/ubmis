@extends('layouts.layouts')
@section('title', 'Ultrabyte | Add Sales')

@section('content')
	<section class="content">
		<div class="row">
	    	<div class="col-md-12">
	          	<div class="box box-solid">
		            <div class="box-body">
		            	@if( $singleNotification->successfully_sent == 1 )
			            	<h4 class="text-green">This e-mail notification has been successfully sent to <b>{{ $singleNotification->company->name }}</b>.</h4>
			            @else
			            	<h4 class="text-red">Failed to send this e-mail notification to <b>{{ $singleNotification->company->name }}</b>.</h4>
			            @endif
		            </div>
		        </div>
		    </div>
	    </div>
		<div class="row">
			<div class="col-md-12">
				<div class="box box-solid">
					<div class="box-header with-border">
						<i class="fa fa-building-o"></i>

						<h3 class="box-title">Company Details</h3>
					</div>
					<!-- /.box-header -->
					<div class="box-body">
						<dl class="dl-horizontal">
							<dt>Name :</dt>
							<dd>{{ $singleNotification->company->name }}</dd>
							
							<dt>Emails :</dt>
							<dd>
								<?php $countEmails = $singleNotification->company->emails->count() - 1; ?>

								@foreach( $singleNotification->company->emails as $index => $email )
									@if( $countEmails == $index )
										{{ $email->email }}
									@else
										{{ $email->email }},
									@endif
								@endforeach
							</dd>

							<dt>Contact Numbers :</dt>
							<dd>
								@foreach( $fieldVisitContacts as $index1 => $fieldVisitContact )
									<?php 
										$countContact = $fieldVisitContact->contactDetails->count()-1;
										$countFieldVisitContacts = $fieldVisitContacts->count()-1;

										if( $index1 == $countFieldVisitContacts )
											$lastIndex = 1;
										else
											$lastIndex = 0;
									?>

									@foreach( $fieldVisitContact->contactDetails as $index2 => $contact )
										@if( $lastIndex == 1 )
											@if( $countContact != $index2 )
												@if( !empty($contact->contact_number) )
													{{ $contact->contact_number }}, 
												@endif
											@else
												@if( !empty($contact->contact_number) )
													{{ $contact->contact_number }}
												@endif
											@endif
										@else
											@if( !empty($contact->contact_number) )
												{{ $contact->contact_number }}, 
											@endif
										@endif

									@endforeach
								@endforeach
							</dd>
						</dl>
					</div>
					<!-- /.box-body -->
				</div>
				<!-- /.box -->
			</div>
			<!-- ./col -->
		</div>

		<div class="row">
	        <div class="col-md-12">
		        <div class="box box-solid">
		            <div class="box-header with-border">
		              <i class="fa fa-envelope-o"></i>

		              <h3 class="box-title">E-mail</h3>
		            </div>
		            <!-- /.box-header -->
		            <div class="box-body">
			            <h4>Dear Valued Customer,</h4>

			            <?php $serviceName = ''; ?>

			            @foreach( $services as $service )
			            	@if( $service->id == $singleNotification->service_id )
			            		<?php $serviceName = $service->name; ?>
			            	@endif
			            @endforeach

			            @if( $singleNotification->service_id == 2 )
			                @foreach( $seoPackages as $seoPackage )
			                    @if( $seoPackage->slug == $singleNotification->information )
			                        <?php $information = $seoPackage->name; ?>
			                    @endif
			                @endforeach

			            @elseif( $singleNotification->service_id == 10 )
			                @foreach( $amcPackages as $amcPackage )
			                    @if( $amcPackage->slug == $singleNotification->information )
			                        <?php $information = $amcPackage->name; ?>
			                    @endif
			                @endforeach
			            @else
			                <?php $information = $singleNotification->information; ?>
			            @endif

						<p style="margin-left: 20px;">
							Your {{ $serviceName }} ({{ $information }}) is going to expire after {{ $singleNotification->remaining_days }} days. Please renew before the time.
						</p>

						 <h4 style="margin-bottom: 0px;">With Regards,</h4>
						 <h4 style="margin-top: 0px;">Account Department</h4>

						 <h4 style="margin-bottom: 0px;">E-mail: account@ultrabyteit.com</h4>
					     <h4 style="margin-top: 0px; margin-bottom: 0px;">Fb.com/ultrabyteinternational</h4>
					     <h4 style="margin-top: 0px; margin-bottom: 0px;">Tel: +977-01-4418141, +977-9802063954</h4>
					     <h4 style="margin-top: 0px; margin-bottom: 0px;">Skype: ultrabyte.international</h4>
					     <h4 style="margin-top: 0px;">G.P.O. Box: 23533</h4>
		            </div>
		            <!-- /.box-body -->
	          	</div>
	          <!-- /.box -->
	        </div>
	        <!-- ./col -->
	    </div>

	</section>
@endsection
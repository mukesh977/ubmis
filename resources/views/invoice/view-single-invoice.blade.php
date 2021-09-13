@extends('layouts.layouts')
@section('title', 'Ultrabyte | Single Invoice')

@section('content')
<section class="content">
	<section class="invoice">
      <div class="row">
        <div class="col-xs-12">
          <div class="text-center">
            <h2>Ultrabyte International Pvt. Ltd.</h2>
            <h4 class="text-center">Maitidevi, Kathmandu</h4>
            <!-- <h5 class="pull-right">Date: 2/10/2014</h5> -->
          </div>
        </div>
      </div>
      <br>

      <div class="row invoice-info">
        <div class="col-xs-12 invoice-col">
          To
          <address>
            <strong>{{ $invoice->company->name }}</strong><br>
            {{ $invoice->company->address }}
          </address>
        </div>
      </div>

      <div class="row invoice-info">
        <div class="col-xs-6 invoice-col">
          <h5>Bill No: {{ $invoice->bill_no }}</h5>
        </div>
        <div class="col-xs-6 invoice-col">
          <h5 class="pull-right">Date: {{ $invoice->date }}</h5>
        </div>
      </div>

      <div class="row invoice-info">
        <div class="col-xs-12 invoice-col">
          <h3 class="text-center"><u>Estimate Bill</u></h3>
        </div>
      </div>
      <br>

      <div class="row">
        <div class="col-xs-12">
          <table class="table table-bordered">
            <thead>
              <tr>
                <th>Date</th>
                <th>Particulars</th>
                <th>Debit (Rs)</th>
                <th>Credit (Rs)</th>
              </tr>
            </thead>
            <tbody>

              <?php
                $countInvoiceItems = $invoice->invoiceItems->count();

                if( !$invoice->invoiceItems->isEmpty())
	                $uniqueGroupId = $invoice->invoiceItems[0]->group_id;
              ?>

            @foreach( $invoice->invoiceItems as $index => $item )
	            <?php 
	              $information = '';
	              $currentGroupId = $item->group_id;

	              if( $index == 0 || $uniqueGroupId != $currentGroupId )
	              {
		              $count = $countGroup->countGroup($invoice->id, $currentGroupId);
	              }

	              if( !empty($item->id) )
	              {
	                if($item->service_id == 2)
	                {
	                  foreach( $seoPackages as $seoPackage )
	                  {
	                    if( $seoPackage->slug == $item->information )
	                    {
	                      $information = $seoPackage->name;
	                    }
	                  }

	                }
	                else if($item->service_id == 10)
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
	              } 
	                    
	            ?>
	            
	            
	            <tr>
                @if( $index == 0 || $uniqueGroupId != $currentGroupId )
  	            	<td rowspan="{{ $count }}">
                    {{ \Carbon\Carbon::parse($invoice->date)->format('F j, Y') }}  
                  </td>
                @endif
                
	            	<td>{{ $item->salesCategory->name .' - '. $information }} </td>
	            	<td>{{ nepali_number_format($item->total_price) }}</td>

	            	@if( $index == 0 || $uniqueGroupId != $currentGroupId )
		            	<td rowspan="{{ $count }}">
	                        {{ nepali_number_format($item->invoiceItemAmounts->total_paid_amount) }}
	                    </td>
	                    <?php $uniqueGroupId = $currentGroupId; ?>
	                @endif
	            </tr>
	              
            @endforeach
              
            </tbody>
          </table>
        </div>
      </div>
      <br>

      <div class="row">
        <div class="col-xs-6">
        </div>
        <div class="col-xs-6">
            <table class="table table-xs">
              <tr> 
                <td class="bt_none pull-right">{{ nepali_number_format($invoice->previous_due_amount) }}</td>
                <th class="bt_none pull-right" style="width:50%;">Previous Due Amount:</th>
              </tr>

              <tr> 
                <td class="bt_none pull-right">{{ nepali_number_format($invoice->total_due_amount) }}</td>
                <th class="bt_none pull-right" style="width:50%;">Total Due Amount:</th>
              </tr>

            </table>
        </div>
      </div>
    </section>
</section>
@endsection
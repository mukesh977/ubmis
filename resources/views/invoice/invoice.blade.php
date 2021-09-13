<!DOCTYPE html>
  <html lang="en">
    <head>
      <title>Bootstrap Example</title>
      <meta http-equiv="Content-Type" content="text/html" charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
      <script src="{{ asset('dist/bower_components/jquery/dist/jquery.min.js') }}"></script>
      <script src="{{ asset('dist/bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>

      <style>
        .bt_none{ border-top: none !important; }  
        footer {
            position: fixed; 
            bottom: -60px; 
            left: 0px; 
            right: 0px;
            height: 50px; 

            /** Extra personal styles **/
            background-color: white;
            color: black;
            text-align: center;
            line-height: 25px;

            /* border */
            border-color: black;
            border-left-width: 0px;
            border-right-width: 0px;
            border-top-width: 1px;
            border-style: line;
            border-top-color: black;
        }
      </style>
    </head>
    <body>
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
      <br>

      <div class="row invoice-info">
        <div class="col-xs-12 invoice-col">
          To
          <address>
            <strong>{{ $company->name }}</strong><br>
            {{ $company->address }}
          </address>
        </div>
      </div>

      <div class="row invoice-info">
        <div class="col-xs-6 invoice-col">
          <h5>Bill No: {{ $billNo }}</h5>
        </div>
        <div class="col-xs-5 invoice-col">
          <h5 class="pull-right">Date: {{ $today->toDateString() }}</h5>
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

              @foreach( $currentMonthTransactions as $sT )

                <?php
                  $countFb = $sT->salesTransactionsItemFb->count();
                  $countFbDetail = ( ($countFb > 0)? ($countFb - 1) : 0);
                  $countSTI = $sT->salesTransactionsItem->count() + $countFbDetail;
                  $flag = 1; 
                ?>

                @foreach( $sT->salesTransactionsItem as $index => $item )
                <?php 
                  $information = '';

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
                
                @if( $item->salesCategory->slug != "facebook" )
                    
                  <tr>
                    @if( $flag == 1 )
                      <td rowspan="{{ $countSTI }}">
                        {{ \Carbon\Carbon::parse($sT->date)->format('F j, Y') }}
                      </td>
                    @endif

                    <td>{{ $item->salesCategory->name .' - '. $information }} </td>
                    <td>{{ nepali_number_format($item->total_price) }}</td>

                    @if( $flag == 1 )
                      <?php $flag = 0; ?>
                      <td rowspan="{{ $countSTI }}">
                        {{ nepali_number_format($sT->total_paid_amount) }}
                      </td>
                    @endif
                  </tr>
                  
                @else
                  @if( $countFb > 0 )
                    @foreach( $item->salesTransactionsItemFb as $index2 => $fbItem )
                        
                      <tr>
                        @if( $flag == 1 ) 
                          <td rowspan="{{ $countSTI }}">
                            {{ \Carbon\Carbon::parse($sT->date)->format('F j, Y') }}
                          </td>
                        @endif

                        <td>{{ $item->salesCategory->name .' - '. $fbItem->particulars }} </td>
                        <td>{{ nepali_number_format($fbItem->total) }}</td>
                        
                        @if( $flag == 1 )
                          <?php $flag = 0; ?>
                          <td rowspan="{{ $countSTI }}">
                            {{ nepali_number_format($sT->total_paid_amount) }}
                          </td>
                        @endif

                      </tr>

                    @endforeach
                  @endif
                @endif
                @endforeach
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
                <th class="bt_none pull-right" style="width:50%;">Previous Due Amount:</th>
                <td class="bt_none pull-right">{{ nepali_number_format($previousDueAmount) }}</td>
              </tr>

              <tr> 
                <th class="bt_none pull-right" style="width:50%;">Total Due Amount:</th>
                <td class="bt_none pull-right">{{ nepali_number_format($totalDueAmount) }}</td>
              </tr>

            </table>
        </div>
      </div>

      <footer>
        <h5 style="margin-bottom: 50px; display: inline;"><b>E-mail: care@ultrabyteit.com, </b></h5>
        <h5 style="display: inline;"><b>Contact Number: 01-4418141, 9802063954</b></h5>
      </footer>
    </section>
  </body>
</html>
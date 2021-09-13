@role(['marketingManager', 'admin'])
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Sales Recap Report</h3>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                    <div class="btn-group">
                        <button type="button" class="btn btn-box-tool dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-wrench"></i></button>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="#">Action</a></li>
                            <li><a href="#">Another action</a></li>
                            <li><a href="#">Something else here</a></li>
                            <li class="divider"></li>
                            <li><a href="#">Separated link</a></li>
                        </ul>
                    </div>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div class="row">
                    <div class="col-md-8">
                        <p class="text-center">
                            <strong>Target Sales & User Sales</strong>
                        </p>

                        <div class="chart">
                            <!-- Sales Chart Canvas -->
                            <div id="targetSalesChart" style="height: 200px;"></div>
                        </div>
                        <!-- /.chart-responsive -->
                    </div>
                    <!-- /.col -->
                    <div class="col-md-4">
                        <p class="text-center">
                            <strong>Goal Completion</strong>
                        </p>
                        @forelse($salesTargets as $target)
                            @if($target['label'] == 'Daily')
								<?php $class = 'aqua'; ?>
                            @elseif($target['label'] == 'Weekly')
								<?php $class = 'red'; ?>
                            @elseif($target['label'] == 'Quarterly')
								<?php $class = 'green'; ?>
                            @else
								<?php $class = 'yellow'; ?>
                            @endif
                            <div class="progress-group">
                                <span class="progress-text">{{ $target['label'] }} Sales</span>
                                <span class="progress-number"><b>{{ $target['total_sales'] }}</b>/{{$target['y']}}</span>

                                <div class="progress sm">
                                    <div class="progress-bar progress-bar-{{ $class }}" style="width: @if($target['y']){{($target['total_sales']/$target['y'])*100}}% @endif"></div>
                                </div>
                            </div>
                    @empty
                    @endforelse
                    <!-- /.progress-group -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- ./box-body -->
            <div class="box-footer">
                <div class="row">
                    <div class="col-sm-3 col-xs-6">
                        <div class="description-block border-right">
                            <span class="description-percentage text-green"><i class="fa fa-caret-up"></i> 100%</span>
                            <h5 class="description-header">Rs.{{ $totalSalesTargets }}</h5>
                            <span class="description-text">TOTAL SALES TARGET</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-3 col-xs-6">
                        <div class="description-block border-right">
                            <span class="description-percentage text-yellow"><i class="fa fa-caret-left"></i> @if($totalSalesTargets){{($totalSales/$totalSalesTargets)*100}}% @endif</span>
                            <h5 class="description-header">Rs. {{ $totalSales }}</h5>
                            <span class="description-text">TOTAL SALES</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-3 col-xs-6">
                        <div class="description-block border-right">
                            @if($totalSales > $totalSalesTargets)
                                <span class="description-percentage text-green"><i class="fa fa-caret-up"></i> @if($totalSalesTargets){{ (($totalSales - $totalSalesTargets)*100)/$totalSalesTargets }}% @endif</span>
                                <h5 class="description-header">Rs. {{ $totalSales - $totalSalesTargets }}</h5>
                                <span class="description-text">TARGET EXCEED AMOUNT</span>
                            @else
                                <span class="description-percentage text-green"><i class="fa fa-caret-up"></i>@if($totalSalesTargets) {{ (($totalSalesTargets - $totalSales)*100)/$totalSalesTargets }}% @endif</span>
                                <h5 class="description-header">Rs. {{ $totalSalesTargets - $totalSales }}</h5>
                                <span class="description-text">REMAINING SALES TARGET</span>
                            @endif
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-3 col-xs-6">
                        <div class="description-block">
                            <span class="description-percentage text-red"><i class="fa fa-caret-down"></i>@if($totalSalesTargets) {{($totalSales/$totalSalesTargets)*100}}% @endif</span>
                            <h5 class="description-header">{{$totalSales}}</h5>
                            <span class="description-text">GOAL COMPLETIONS</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                </div>
                <!-- /.row -->
            </div>
            <!-- /.box-footer -->
        </div>
        <!-- /.box -->
    </div>
    <!-- /.col -->
</div>
@endauth
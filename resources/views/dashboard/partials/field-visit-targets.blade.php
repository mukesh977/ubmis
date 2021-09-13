@role(['marketingBoy', 'marketingOfficer', 'marketingManager'])
<!-- Main row -->
<div class="row">
    <!-- Left col -->
    <section class="col-lg-12 connectedSortable">
        <!-- Target List -->
        <div class="box box-primary">
            <div class="box-header">
                <i class="ion ion-clipboard"></i>
                <h3 class="box-title">Field Visit Lists</h3>
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
                            <strong>Targets</strong>
                        </p>
                        <ul class="todo-list">
                            @forelse($userTargets as $target)
                                <li>
                                    <!-- drag handle -->
                                    <span class="handle">
                                            <i class="fa fa-ellipsis-v"></i>
                                            <i class="fa fa-ellipsis-v"></i>
                                          </span>
                                    <!-- checkbox -->
                                    <input type="checkbox" value="">
                                    <!-- todo text -->
                                    <span class="text">{{$target->targets->name}} Field Visit Target</span>
                                    <!-- Emphasis label -->
                                    @if($target->targets->name == 'Daily')
										<?php $class = 'label-primary'; ?>
                                    @elseif( $target->targets->name == 'Weekly' )
										<?php $class = 'label-warning'; ?>
                                    @elseif( $target->targets->name == 'Monthly' )
										<?php $class = 'label-success'; ?>
                                    @else
										<?php $class = 'label-danger'; ?>
                                    @endif
                                    <small class="label {{ $class }}"><i class="fa fa-clock-o"></i> {{ $target->total_target }} Visits</small>
                                </li>
                            @empty
                            @endforelse
                        </ul>
                    </div>

                    <div class="col-md-4">
                        <p class="text-center">
                            <strong>Goal Completion</strong>
                        </p>
                        @forelse($userTargets as $target)
                            @if($target->targets->name == 'Daily')
								<?php $class = 'aqua'; $visits = $total_daily_visits; ?>
                            @elseif($target->targets->name == 'Weekly')
								<?php $class = 'red'; $visits = $total_weekly_visits; ?>
                            @elseif( $target->targets->name == 'Monthly')
								<?php $class = 'green'; $visits = $total_monthly_visits; ?>
                            @else
								<?php $class = 'yellow'; $visits = $total_quarterly_visits; ?>
                            @endif
                            <div class="progress-group">
                                <span class="progress-text">{{ ucfirst($target->targets->name) }} Field Visits</span>
                                <span class="progress-number"><b>{{ $visits }}</b>/{{ $target->total_target }}</span>

                                <div class="progress sm">
                                    <div class="progress-bar progress-bar-{{ $class }}" style="width: @if($target->total_target){{($visits/$target->total_target)*100}}% @endif"></div>
                                </div>
                            </div>
                        @empty
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endauth